<?php
namespace Controllers;

use Models\PartnerModel;
require_once "Models/PartnerModel.php";
require_once "Views/public/PartnerView.php";

class PartnerController {
    private PartnerModel $model;

    public function display($partnerId): void
    {
        $view = new \PartnerView();
        $view->afficherPartner($partnerId);
    }

    public function __construct() {
        $this->model = new PartnerModel();
    }

    public function getPartnerDetails($partnerId) {
        return $this->model->getPartnerDetails($partnerId);
    }

    public function getPartnerAdvantages($partnerId) {
        return $this->model->getPartnerAdvantages($partnerId);
    }

    public function getPartnerDiscounts($partnerId) {
        return $this->model->getPartnerDiscounts($partnerId);
    }
}