<?php
namespace Controllers;
require_once "models/AdvantagesDiscountsModel.php";
require_once "views/members/AdvantagesDiscountsView.php";

class AdvantagesDiscountsController {
    private \Models\AdvantagesDiscountsModel $model;

    public function __construct() {
        $this->model = new \Models\AdvantagesDiscountsModel();
    }

    public function display(): void
    {
        // Get member's membership type
        $user_id = $_SESSION['user_id'];
        $memberId = $this->model->getMemberId($user_id)["member_id"];
        $membershipType = $this->model->getMembershipType($memberId);

        if (!$membershipType) {
            // Handle error - member not found or no membership type
            header("Location: login");
            exit;
        }

        // Get discounts and advantages
        $discounts = $this->model->getDiscountsByMembershipType($membershipType['type_id']);
        $advantages = $this->model->getAdvantagesByMembershipType($membershipType['type_id']);

        // Display the view
        $view = new \AdvantagesDiscountsView();
        $view->display($membershipType, $discounts, $advantages);
    }
}
