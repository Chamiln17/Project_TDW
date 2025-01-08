<?php
use Controllers\AuthController;
class RegisterView
{
    private $controller;
    function __construct()
    {   if ($this->controller == null)
        $this->controller = new AuthController();
    }
    public function afficherRegister()
    {
        require_once "./views/includes/header.php"?>

        <?php require_once "./views/includes/footer.php";
    }
}