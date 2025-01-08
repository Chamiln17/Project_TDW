<?php

namespace Controllers;

use Models\UserModel;

require_once "views/public/LoginView.php";
require_once "models/UserModel.php";

class AuthController
{
    private $data;
    private $view;
    public function __construct()
    {
        if ($this->data == null)
            $this->data = new UserModel();

    }

    public function  display_Login()
    {
        $this->view = new \LoginView();
        $this->view->afficherLogin();
    }
    public function  display_Register()
    {
        $this->view = new \RegisterView();
        $this->view->afficherRegister();


    }
}