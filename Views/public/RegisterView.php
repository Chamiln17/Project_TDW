<?php
use Controllers\AuthController;

class RegisterView
{
    private  $controller;

    function __construct()
    {
        if ($this->controller == null) {
            $this->controller = new AuthController();
        }
    }



    public function afficherRegister()
    {
        $membershipTypes = $this->controller->getMembershipTypes();
        $cities = $this->controller->getCities();
        require_once "./views/includes/header.php";

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        ?>

        <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-8">
                    <h2 class="text-4xl font-bold text-gray-900 mb-2">Devenir Membre</h2>
                    <p class="text-lg text-gray-600">Rejoignez notre communauté Coeur espoir</p>
                </div>

                <form action="/Project_TDW/register" method="POST" enctype="multipart/form-data" class="bg-white shadow-lg rounded-lg p-8 space-y-6">
                    <!--  -->
                    <?php
                    if (isset($_SESSION['register_error'])) {
                        echo "<div class='bg-red-50 text-red-600 px-4 py-3 rounded-md' role='alert'>" .
                            htmlspecialchars($_SESSION['register_error']) .
                            "</div>";
                        unset($_SESSION['register_error']);
                    }

                    ?>
                    <!-- Informations Personnelles -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-gray-900">Informations Personnelles</h3>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="space-y-2">
                                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                                <input type="text" id="prenom" name="prenom" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>
                            <div class="space-y-2">
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                                <input type="text" id="nom" name="nom" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="date_naissance" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                            <input type="date" id="date_naissance" name="date_naissance" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>

                        <div class="space-y-2">
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" id="username" name="username" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" id="password" name="password" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>

                        <div class="space-y-2">
                            <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="tel" id="telephone" name="telephone" pattern="[0-9]{10}" required
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
                        <div class="space-y-2">
                            <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                            <textarea id="adresse" name="adresse" rows="3" required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
                        </div>
                    </div>

                    <!-- Documents Requis -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-gray-900">Documents Requis</h3>

                        <div class="space-y-2">
                            <label for="photo" class="block text-sm font-medium text-gray-700">Photo d'identité</label>
                            <input type="file" id="photo" name="photo" accept=".jpg,.png" required
                                   class="w-full file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                            <p class="text-sm text-gray-500">Format: JPG, PNG (max 5MB)</p>
                        </div>

                        <div class="space-y-2">
                            <label for="piece_identite" class="block text-sm font-medium text-gray-700">Pièce d'identité</label>
                            <input type="file" id="piece_identite" name="piece_identite" accept=".jpg,.png,.pdf" required
                                   class="w-full file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                        </div>
                    <!-- Type d'adhésion -->
                        <div class="space-y-4">
                            <h3 class="text-xl font-semibold text-gray-900">Type d'adhésion</h3>

                            <div class="space-y-2">
                                <label for="type_adhesion" class="block text-sm font-medium text-gray-700">Choisissez votre type d'adhésion</label>
                                <select id="type_adhesion" name="type_adhesion" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                                        onchange="updateMembershipDetails(this.value)">
                                    <option value="">Sélectionnez un type</option>
                                    <?php foreach ($membershipTypes as $type): ?>
                                        <option value="<?php echo htmlspecialchars($type['type_name']); ?>"><?php echo htmlspecialchars($type['type_name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div id="membership_details" class="hidden p-4 bg-gray-50 rounded-lg">
                                <p id="membership_price" class="font-semibold text-gray-900"></p>
                                <p id="membership_benefits" class="text-gray-600"></p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label for="recu_paiement" class="block text-sm font-medium text-gray-700">Reçu de paiement</label>
                            <input type="file" id="recu_paiement" name="recu_paiement" accept=".pdf" required
                                   class="w-full file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                            <p class="text-sm text-gray-500">Format: PDF uniquement (max 10MB)</p>
                        </div>
                    </div>



                    <!-- Terms and Conditions -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="terms" name="terms" required
                                   class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                            <label for="terms" class="text-sm text-gray-700">
                                J'accepte <a href="/Project_TDW/Termes" class="text-red-600 hover:text-red-700 font-semibold"> les termes et conditions de l'association </a>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded-full font-semibold transition duration-150">
                        Devenir membre
                    </button>
                </form>
            </div>
        </div>

        <script>
            // Create a JavaScript object with membership details
            const membershipDetails = {
                <?php foreach ($membershipTypes as $type): ?>
                '<?php echo htmlspecialchars($type['type_name']); ?>': {
                    price: '<?php echo htmlspecialchars($type['price']); ?>',
                    benefits: '<?php echo nl2br(htmlspecialchars($type['benefits_description'])); ?>'
                },
                <?php endforeach; ?>
            };

            function updateMembershipDetails(type) {
                const detailsDiv = document.getElementById('membership_details');
                const priceElement = document.getElementById('membership_price');
                const benefitsElement = document.getElementById('membership_benefits');

                if (membershipDetails[type]) {
                    priceElement.textContent = 'Prix: ' + membershipDetails[type].price + ' DZD';
                    benefitsElement.textContent = membershipDetails[type].benefits;
                    detailsDiv.classList.remove('hidden');
                } else {
                    detailsDiv.classList.add('hidden');
                }
            }
        </script>
        <?php
    }
}