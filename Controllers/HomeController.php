<?php

namespace Controllers;
use Models\HomeModel;

require_once "views/public/HomeView.php";
require_once "models/HomeModel.php";

class HomeController
{
    private $data;
    private $view;
    public function __construct()
    {
        $this->data = new HomeModel();
        $this->view = new \HomeView();
    }
    public function  display()
    {
        $this->view->afficherHome();
    }
}