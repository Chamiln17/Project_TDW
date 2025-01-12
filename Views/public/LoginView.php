<?php
use Controllers\AuthController;

class LoginView
{
    private $controller;

    function __construct()
    {
        if ($this->controller == null) {
            $this->controller = new AuthController();
        }
    }


    public function afficherLogin()
    {
        require_once "./views/includes/header.php";
        ?>
        <div class="min-h-screen  py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md mx-auto">
                <div class="text-center mb-8">
                    <h2 class="text-4xl font-bold text-gray-900 mb-2">Connexion</h2>
                    <p class="text-lg text-gray-600">Accédez à votre compte Coeur espoir</p>
                </div>

                <form action="/Project_TDW/login" method="POST" class="bg-white shadow-lg rounded-lg p-8 space-y-6">
                    <?php
                    if (isset($_SESSION['login_error'])) {
                        echo "<div class='bg-red-50 text-red-600 px-4 py-3 rounded-md mb-4' role='alert'>" .
                            htmlspecialchars($_SESSION['login_error']) .
                            "</div>";
                        unset($_SESSION['login_error']);
                    }
                    ?>

                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label for="input" class="block text-sm font-medium text-gray-700">
                                Nom d'utilisateur ou Email
                            </label>
                            <input
                                    type="text"
                                    id="input"
                                    name="input"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                            />
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Mot de passe
                            </label>
                            <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                            />
                        </div>
                    </div>

                    <button
                            type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded-full font-semibold transition duration-150"
                    >
                        Se connecter
                    </button>

                    <div class="text-center text-sm text-gray-600">
                        <a href="#" class="hover:text-red-600">Mot de passe oublié ?</a>
                    </div>

                    <div class="text-center text-sm text-gray-600">
                        Pas encore membre ?
                        <a href="/Project_TDW/register" class="text-red-600 hover:text-red-700 font-semibold">
                            S'inscrire
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
}