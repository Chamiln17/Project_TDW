<?php
use Controllers\AuthController;
class LoginView
{
    private $controller;
    function __construct()
    {   if ($this->controller == null)
        $this->controller = new AuthController();
    }
    public function afficherLogin()
    {
require_once "./views/includes/header.php"?>

<?php require_once "./views/includes/footer.php";
    }
}