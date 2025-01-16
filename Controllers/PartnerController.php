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
    public function handleFavorite($partner_id): void
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Please log in to register for events";
            header("Location: /Project_TDW/catalogue/$partner_id");
            exit();
        }
        $memberData = $this->getMemberByID($_SESSION['user_id']);
        if (!$memberData || !isset($memberData[0]['member_id'])) {
            $_SESSION['error'] = "Invalid member account";
            header("Location: /Project_TDW/catalogue/$partner_id");
            exit();
        }
        $memberId = $memberData[0]['member_id'];
        $action = $_POST['action'] ?? 'register';
        try {
            if ($action === 'register') {
                $result = $this->addFavorite($memberId, $partner_id);
                if ($result['success']) {
                    $_SESSION['success'] = $result['message'];
                } else {
                    $_SESSION['error'] = $result['message'];
                }
            } else {
                $result = $this->removeFavorite($memberId, $partner_id);
                if ($result['success']) {
                    $_SESSION['success'] = $result['message'];
                } else {
                    $_SESSION['error'] = $result['message'];
                }
            }
        } catch (\Exception $e) {
            if ($e->getCode() == '23000') {
                $_SESSION['error'] = "Unable to register: Invalid member or partner";
            } else {
                $_SESSION['error'] = "An error occurred while processing your request";
            }
        }
        header("Location: /Project_TDW/catalogue/$partner_id");
        exit();
    }
    public function getMemberByID($user_id) {
        return $this->model->getMember($user_id);
    }

    public function removeFavorite($member_id, $partner_id): array
    {
        return $this->model->removeFavorite($member_id,$partner_id);
    }

    public function addFavorite($member_id, $partner_id): array
    {
        return $this->model->addFavorite($member_id,$partner_id);

    }

    public function getFavoriteStatus(mixed $user_id, mixed $partner_id): bool
    {
        return $this->model->getFavoriteStatus($user_id, $partner_id);
    }
}