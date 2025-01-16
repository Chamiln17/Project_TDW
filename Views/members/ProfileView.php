<?php
use Controllers\ProfileController;

class ProfileView {
    private $controller;

    function __construct() {
        if ($this->controller == null) {
            $this->controller = new ProfileController();
        }
    }

    public function afficherProfile(): void {
        $member = $this->controller->get_member($_SESSION["user_id"]);
        $memberData = $member[0];
        $qrCode = $this->controller->generate_member_qr($memberData['member_id']);
        $discounts = $this->controller->getDiscounts($memberData['type_adhesion']);
        $cities = $this->controller->getCities();

        require_once "./views/includes/header.php";
        ?>

        <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <a href="/Project_TDW/catalogue?favorites=1" class="bg-brand-red text-white px-4 py-2 mb-24 rounded-md">Afficher les partenaires favoris</a>
                <a href="http://localhost/Project_TDW/donation/history" class="bg-brand-red text-white px-4 py-2 mb-24 rounded-md">Historique des dons</a>
                <!-- Member Information Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden my-8">
                    <div class="md:flex">
                        <div class="md:flex-shrink-0">
                            <img class="h-48 w-full object-cover md:w-48"
                                 src="<?php echo htmlspecialchars($memberData['photo'] ?? '/images/default-avatar.png'); ?>"
                                 alt="Photo de profil">
                        </div>
                        <div class="p-8">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900">
                                        <?php echo htmlspecialchars($memberData['first_name'] . ' ' . $memberData['last_name']); ?>
                                    </h1>
                                    <p class="mt-2 text-gray-600">
                                        Membre <?php echo htmlspecialchars($memberData['type_adhesion']); ?>
                                    </p>
                                </div>
                                <?php if ($qrCode): ?>
                                    <img src="<?php echo $qrCode; ?>" alt="QR Code" class="w-24 h-24">
                                <?php endif; ?>
                            </div>
                            <div class="mt-4">
                                <p class="text-gray-600">
                                    <span class="font-semibold">Date d'expiration:</span>
                                    <?php echo date('d/m/Y', strtotime($memberData['expiration_date'])); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mb-8">
                    <h2 class="text-4xl font-bold text-gray-900 mb-2">Modifier mes informations</h2>
                    <p class="text-lg text-gray-600">Mettez à jour vos informations personnelles</p>
                </div>

                <form action=/Project_TDW/profile/update method="POST" enctype="multipart/form-data" class="bg-white shadow-lg rounded-lg p-8 space-y-6">
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                            <?php
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <!-- Informations Personnelles -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-gray-900">Informations Personnelles</h3>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       value="<?php echo htmlspecialchars($memberData['email']); ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                                       required
                                />
                            </div>
                            <div class="space-y-2">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                <input type="tel"
                                       id="phone"
                                       name="phone"
                                       value="<?php echo htmlspecialchars($memberData['telephone']); ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                                       required
                                />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="space-y-2">
                                <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
                                <input type="text" id="first_name" name="first_name" required value="<?php echo htmlspecialchars($memberData['first_name']); ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>
                            <div class="space-y-2">
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
                                <input type="text" id="last_name" name="last_name" required value="<?php echo htmlspecialchars($memberData['last_name']); ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                            <textarea id="address"
                                      name="address"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                                      required
                            ><?php echo htmlspecialchars($memberData['address']); ?></textarea>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" required value="<?php echo htmlspecialchars($memberData['date_of_birth']); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>

                    <div class="space-y-2">
                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                        <select id="city" name="city" required

                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                                onchange="updateMembershipDetails(this.value)">
                            <option value="">Sélectionnez votre ville</option>
                            <?php foreach ($cities as $city): ?>
                                <option value="<?php echo htmlspecialchars($city['city_name']); ?>"><?php echo htmlspecialchars($city['city_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Documents Requis -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-gray-900">Documents Requis</h3>

                        <div class="space-y-2">
                            <label for="photo" class="block text-sm font-medium text-gray-700">Photo d'identité</label>
                            <input type="file"
                                   id="photo"
                                   name="photo"
                                   accept=".jpg,.png"
                                   class="w-full file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100"
                            />
                            <p class="text-sm text-gray-500">Format: JPG, PNG (max 5MB)</p>
                        </div>

                        <div class="space-y-2">
                            <label for="piece_identite" class="block text-sm font-medium text-gray-700">Pièce d'identité</label>
                            <input type="file"
                                   id="piece_identite"
                                   name="piece_identite"
                                   accept=".jpg,.png,.pdf"
                                   class="w-full file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100"
                            />
                            <p class="text-sm text-gray-500">Format: JPG, PNG, PDF (max 5MB)</p>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded-full font-semibold transition duration-150">
                        Mettre à jour
                    </button>
                </form>
                    </div>
            </div>
        </div>

        <?php
        require_once "./views/includes/footer.php";
    }
}