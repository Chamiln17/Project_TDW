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
        <div class="container mx-auto mt-5 p-4">
            <div class="flex justify-center">
                <div class="w-full max-w-md">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                            <h2 class="text-xl font-semibold text-gray-800">Login</h2>
                        </div>
                        <div class="p-6">
                            <?php
                            if (isset($_SESSION['login_error'])) {
                                echo "<div class='bg-red-50 text-red-600 px-4 py-3 rounded-md' role='alert'>" .
                                    htmlspecialchars($_SESSION['login_error']) .
                                    "</div>";
                                unset($_SESSION['login_error']);
                            }
                            ?>
                            <form action="/Project_TDW/login" method="POST" class="space-y-6">
                                <div class="space-y-2">
                                    <label for="input" class="block text-sm font-medium text-gray-700">
                                        Username or Email
                                    </label>
                                    <input
                                            type="text"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            id="input"
                                            name="input"
                                            required
                                    />
                                </div>

                                <div class="space-y-2">
                                    <label for="password" class="block text-sm font-medium text-gray-700">
                                        Password
                                    </label>
                                    <input
                                            type="password"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            id="password"
                                            name="password"
                                            required
                                    />
                                </div>

                                <button
                                        type="submit"
                                        class="w-full bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200"
                                >
                                    Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}