<?php

namespace Controllers;
use Models\HomeModel;

require_once "views/public/HomeView.php";
require_once "models/HomeModel.php";

class HomeController
{
    private  $home;

    public function __construct()
    {
        if ($this->home == null)
        $this->home = new HomeModel();

    }
    public function getPartners(): array
    {
        return $this->home->get_partners();

    }
    public function getTotalPartners()
    {
        return $this->home->getTotalPartners();
    }
    public function getNews()
    {
        return $this->home->get_news();
    }
    public function  display()
    {
        $view = new \HomeView();
        $view->afficherHome();
    }
}