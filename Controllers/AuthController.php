<?php

namespace Controllers;

use LoginView;
use Models\UserModel;
use RegisterView;

require_once "views/public/LoginView.php";
require_once "views/public/RegisterView.php";
require_once "models/UserModel.php";

class AuthController
{
    private UserModel $data;
    private $view;

    public function __construct()
    {
        $this->data = new UserModel();
    }

    public function display_Login()
    {
        $this->view = new LoginView();
        $this->view->afficherLogin();
    }

    public function display_Register()
    {
        $this->view = new RegisterView();
        $this->view->afficherRegister();
    }

    public function login()
    {   if (session_status() == PHP_SESSION_NONE) {
        session_start();
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: login");
            exit();
        }
        // Get form input
        $input = $_POST['input'];
        $password = $_POST['password'];
        $user = $this->data->login($input, $password);
        if ($user) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];
            // Redirect to a protected page based on role
            switch ($user['role']) {
                case 'admin':
                    header("Location: admin_dashboard.php");
                    break;
                case 'partner':
                    header("Location: partner_dashboard.php");
                    break;
                default:
                    header("Location: /Project_TDW/");
                    break;
            }
        } else {
            // Set error message for login failure
            $_SESSION['login_error'] = "Invalid username/email or password.";
            // Redirect back to login page
            header("Location: login");
        }
        exit();
    }

    public function register()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: register");
            exit();
        }
        // Get form input
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        // Validate inputs (basic example)
        if (empty($username) || empty($email) || empty($password)) {
            $_SESSION['register_error'] = "All fields are required.";
            header("Location: register");
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['register_error'] = "Invalid email format.";
            header("Location: register");
            exit();
        }

        // Check if username or email already exists
        $existingUser = $this->data->getUserByUsernameOrEmail($username, $email);
        if ($existingUser) {
            $_SESSION['register_error'] = "Username or email already exists.";
            header("Location: register");
            exit();
        }

        // Register the user
        $result = $this->data->register($username, $email, $password);

        if ($result) {
            $_SESSION['register_success'] = "Registration successful! You can now log in.";
            header("Location: login");
        } else {
            $_SESSION['register_error'] = "Registration failed. Please try again.";
            header("Location: register");
        }
        exit();
    }
}