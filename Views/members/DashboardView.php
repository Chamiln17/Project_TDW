<?php
use Controllers\UserDashboardController;
class DashboardView
{
    private $controller;

    function __construct()
    {
        if ($this->controller == null) {
            $this->controller = new UserDashboardController();
        }
    }

    public function afficherDashboard()
    {
        $member=$this->controller->get_member($_SESSION["user_id"]);
        $prenom=$member[0]['first_name'];
        $nom=$member[0]['last_name'];
        $id=$member[0]['member_id'];

        require_once "./views/includes/header.php";
        ?>

        <div class="container mx-auto mt-8 p-4">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Bienvenue, <?php echo htmlspecialchars($prenom); ?></h1>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Votre carte de membre</h2>

                <!-- Updated Card Design -->
                <div class="relative w-full max-w-md mx-auto h-56 rounded-xl overflow-hidden bg-white shadow-lg">
                    <!-- Curved Background -->
                    <div class="absolute inset-0">
                        <div class="absolute inset-0 bg-gradient-to-r from-white via-white to-transparent z-10"></div>
                        <div class="absolute top-0 right-0 w-2/3 h-full bg-red-600 rounded-l-full transform translate-x-1/3"></div>
                    </div>

                    <!-- Logo -->
                    <div class="absolute top-4 right-4 z-20">
                        <img src="./assets/shapes/logo.svg" alt="Coeur espoir" class="h-8">
                    </div>

                    <!-- Member Information -->
                    <div class="relative z-20 p-6 flex flex-col h-full justify-between">
                        <div class="space-y-4">
                            <!-- Profile Section -->
                            <div class="flex items-start space-x-3">
                                <div class="w-16 h-16 rounded-lg overflow-hidden">
                                    <img
                                            src="<?php echo htmlspecialchars($member['photo_url']); ?>"
                                            alt="Photo de profil"
                                            class="w-full h-full object-cover"
                                    >
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">
                                        <?php echo htmlspecialchars($member["first_name"] . ' ' . $member['last_name']); ?>
                                    </h3>
                                    <p class="text-sm text-gray-600">Membre</p>
                                </div>
                            </div>

                            <!-- Member Details -->
                            <div class="space-y-1">
                                <p class="text-sm text-gray-600">
                                    ID: <?php echo htmlspecialchars($member['member_id']); ?>
                                </p>
                                <p class="text-sm text-gray-600">
                                    Type carte: <?php echo htmlspecialchars(ucfirst($member['type_adhesion'])); ?>
                                </p>
                            </div>
                        </div>

                        <!-- QR Code -->
                        <div class="absolute bottom-4 right-4 z-20">
                            <img
                                    src="<?php  ?>"
                                    alt="QR Code"
                                    class="w-20 h-20 bg-white p-1 rounded-lg"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
        require_once "./views/includes/footer.php";
    }



}