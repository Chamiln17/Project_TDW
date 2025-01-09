<?php

namespace Controllers;
use Models\HomeModel;

require_once "Views/public/CatalogueView.php";
require_once "models/HomeModel.php";

class CatalogueController
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

    public function  display()
    {
        $view = new \CatalogueView();
        $view->afficherCatalogue();
    }
}