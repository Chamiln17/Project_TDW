<?php

namespace Controllers;

use Models\PartnerModel;
use Models\DiscountModel;
use Models\AdvantageModel;
require_once "Models/PartnerModel.php";
require_once "Models/DiscountModel.php";
require_once "Models/AdvantageModel.php";
require_once "Views\admin\AdminRemisePartenaireView.php";


class AdminRemisePartenaireController
{
    public function displayRemises($id): void
    {
        // Fetch partner details
        $partnerModel = new PartnerModel();
        $partner = $partnerModel->getPartnerById($id);

        // Fetch discounts and advantages for the partner
        $discountModel = new DiscountModel();
        $discounts = $discountModel->getDiscountsByPartnerId($id);

        $advantageModel = new AdvantageModel();
        $advantages = $advantageModel->getAdvantagesByPartnerId($id);

        // Load the view
        $view = new \AdminRemisePartenaireView;
        $view->displayRemisePartenaire($partner, $discounts, $advantages);
    }

    public function addDiscount($id): void
    {
        // Get form data from $_POST
        $data = [
            'description' => $_POST['description'],
            'discount_percentage' => $_POST['discount_percentage'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'membership_type_id' => $_POST['membership_type_id']
        ];

        // Validate the data
        if (empty($data['description']) || empty($data['discount_percentage']) || empty($data['start_date']) || empty($data['end_date'])) {
            $_SESSION['error'] = "Tous les champs sont obligatoires.";
            header("Location: /Project_TDW/admin/partners/remises/$id");
            exit;
        }

        // Add the discount
        $discountModel = new DiscountModel();
        $discountModel->addDiscount($id, $data);
        header("Location: /Project_TDW/admin/partners/remises/$id");
        exit;
    }

    public function addAdvantage($id): void
    {
        // Get form data from $_POST
        $data = [
            'description' => $_POST['description'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'membership_type_id' => $_POST['membership_type_id']
        ];

        // Validate the data
        if (empty($data['description']) || empty($data['start_date']) || empty($data['end_date'])) {
            $_SESSION['error'] = "Tous les champs sont obligatoires.";
            header("Location: /Project_TDW/admin/partners/remises/$id");
            exit;
        }

        // Add the advantage
        $advantageModel = new AdvantageModel();
        $advantageModel->addAdvantage($id, $data);
        header("Location: /Project_TDW/admin/partners/remises/$id");
        exit;
    }

    public function editDiscount($id, $discountId): void
    {
        // Fetch the discount details
        $discountModel = new DiscountModel();
        $discount = $discountModel->getDiscountById($discountId);

        if (!$discount) {
            $_SESSION['error'] = "Discount introuvable.";
            header("Location: /Project_TDW/admin/partners/remises/$id");
            exit;
        }

        // Load the edit form view
        $view = new \AdminRemisePartenaireView;
        $view->displayEditDiscountForm($id, $discount);
    }

    public function updateDiscount($id, $discountId): void
    {
        // Fetch the discount ID from the URL

        if (!$discountId) {
            $_SESSION['error'] = "Discount ID manquant.";
            header("Location: /Project_TDW/admin/partners/remises/$id");
            exit;
        }

        // Get form data from $_POST
        $data = [
            'description' => $_POST['description'],
            'discount_percentage' => $_POST['discount_percentage'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'membership_type_id' => $_POST['membership_type_id']
        ];

        // Validate the data
        if (empty($data['description']) || empty($data['discount_percentage']) || empty($data['start_date']) || empty($data['end_date'])) {
            $_SESSION['error'] = "Tous les champs sont obligatoires.";
            header("Location: /Project_TDW/admin/partners/remises/$id");
            exit;
        }

        // Update the discount
        $discountModel = new DiscountModel();
        $discountModel->updateDiscount($discountId, $data);
        header("Location: /Project_TDW/admin/partners/remises/$id");
        exit;
    }

    public function editAdvantage($id, $advantageId): void
    {
        // Fetch the advantage ID from the URL

        if (!$advantageId) {
            $_SESSION['error'] = "Avantage ID manquant.";
            header("Location: /Project_TDW/admin/partners/remises/$id");
            exit;
        }

        // Fetch the advantage details
        $advantageModel = new AdvantageModel();
        $advantage = $advantageModel->getAdvantageById($advantageId);

        // Load the edit form view
        $view = new \AdminRemisePartenaireView;
        $view->displayEditAdvantageForm($id, $advantage);
    }

    public function updateAdvantage($id,$advantageId): void
    {
        // Fetch the advantage ID from the URL
        if (!$advantageId) {
            $_SESSION['error'] = "Avantage ID manquant.";
            header("Location: /Project_TDW/admin/partners/remises/$id");
            exit;
        }

        // Get form data from $_POST
        $data = [
            'description' => $_POST['description'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'membership_type_id' => $_POST['membership_type_id']
        ];

        // Validate the data
        if (empty($data['description']) || empty($data['start_date']) || empty($data['end_date'])) {
            $_SESSION['error'] = "Tous les champs sont obligatoires.";
            header("Location: /Project_TDW/admin/partners/remises/$id");
            exit;
        }

        // Update the advantage
        $advantageModel = new AdvantageModel();
        $advantageModel->updateAdvantage($advantageId, $data);
        header("Location: /Project_TDW/admin/partners/remises/$id");
        exit;
    }

    public function deleteDiscount($id,$discountId): void
    {
        // Fetch the discount ID from the URL

        if (!$discountId) {
            $_SESSION['error'] = "Discount ID manquant.";
            header("Location: /Project_TDW/admin/partners/remises/$id");
            exit;
        }

        // Delete the discount
        $discountModel = new DiscountModel();
        $discountModel->deleteDiscount($discountId);
        header("Location: /Project_TDW/admin/partners/remises/$id");
        exit;
    }

    public function deleteAdvantage($id,$advantageId): void
    {
        // Fetch the advantage ID from the URL

        if (!$advantageId) {
            $_SESSION['error'] = "Avantage ID manquant.";
            header("Location: /Project_TDW/admin/partners/remises/$id");
            exit;
        }

        // Delete the advantage
        $advantageModel = new AdvantageModel();
        $advantageModel->deleteAdvantage($advantageId);
        header("Location: /Project_TDW/admin/partners/remises/$id");
        exit;
    }
}