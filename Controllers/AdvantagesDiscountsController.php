<?php
namespace Controllers;
require_once "models/AdvantagesDiscountsModel.php";
require_once "views/members/AdvantagesDiscountsView.php";

class AdvantagesDiscountsController {
    public \Models\AdvantagesDiscountsModel $model;

    public function __construct() {
        $this->model = new \Models\AdvantagesDiscountsModel();
    }

    public function display(): void
    {
        // Get member's membership type
        $user_id = $_SESSION['user_id'];
        $memberId = $this->getMemberId($user_id)["member_id"];
        $membershipType = $this->getMembershipType($memberId);

        if (!$membershipType) {
            // Handle error - member not found or no membership type
            header("Location: login");
            exit;
        }

        // Get discounts and advantages
        $discounts = $this->getDiscountsByMembershipType($membershipType['type_id']);
        $advantages = $this->getAdvantagesByMembershipType($membershipType['type_id']);

        // Display the view
        $view = new \AdvantagesDiscountsView();
        $view->display();
    }
    public function getMemberId($user_id) {
        return $this->model->getMemberId($user_id);
    }
    public function getMembershipType($memberId) {
        return $this->model->getMembershipType($memberId);
    }
    public function getDiscountsByMembershipType($membershipTypeId) {
        return $this->model->getDiscountsByMembershipType($membershipTypeId);
    }
    public function getAdvantagesByMembershipType($membershipTypeId) {
        return $this->model->getAdvantagesByMembershipType($membershipTypeId);
    }

}
