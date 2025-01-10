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

        require_once "./views/includes/header.php";

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        ?>
        <div class="container mx-auto mt-5 p-4">
            <div class="flex justify-center">
                <div class="w-full max-w-md">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                            <h2 class="text-xl font-semibold text-gray-800">Register</h2>
                        </div>
                        <div class="p-6">
                            <?php
                            if (isset($_SESSION['register_error'])) {
                                echo "<div class='bg-red-50 text-red-600 px-4 py-3 rounded-md' role='alert'>" .
                                    htmlspecialchars($_SESSION['register_error']) .
                                    "</div>";
                                unset($_SESSION['register_error']);
                            }
                            ?>
                            <form action="/Project_TDW/register" method="POST" class="space-y-6">
                                <div class="space-y-2">
                                    <label for="input" class="block text-sm font-medium text-gray-700">
                                        Username
                                    </label>
                                    <label for="username"></label><input
                                        type="text"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        id="username"
                                        name="username"
                                        required
                                    />
                                </div>
                                <div class="space-y-2">
                                    <label for="input" class="block text-sm font-medium text-gray-700">
                                        Email
                                    </label>
                                    <label for="email"></label><input
                                        type="text"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        id="email"
                                        name="email"
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
                                    Register
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