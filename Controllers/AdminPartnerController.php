<?php

namespace Controllers;
use Models\PartnerModel;

require_once "Models/PartnerModel.php";
require_once "Views/admin/AdminPartnerView.php";

class AdminPartnerController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new PartnerModel();
        $this->checkAdminAuthorization();
    }
    private function checkAdminAuthorization(): void {

        // Check if user is logged in and has admin role
        if (!isset($_SESSION['user_id']) ||
            !isset($_SESSION['role']) ||
            $_SESSION['role'] !== 'admin') {

            // Store intended destination for redirect after login
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];

            // Redirect to login page with error message
            header('Location: /Project_TDW/login' . urlencode($_SERVER['REQUEST_URI']));
            exit();
        }
    }
    public function displayPartners() {
        if(session_status()){

        }
        $filters = [
            'city' => $_GET['city'] ?? null,
            'category' => $_GET['category'] ?? null,
            'sort' => $_GET['sort'] ?? null,
            'order' => $_GET['order'] ?? null
        ];
        $this->view = new \AdminPartnerView();
        $partners = $this->model->getAllPartners($filters);
        $stats = $this->model->getPartnerStats();
        $this->view->displayPartnerManagement($partners, $stats);
    }

    public function addPartner() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'category_id' => $_POST['category_id'],
                'city' => $_POST['city'],
                'offer' => $_POST['offer'],
                'logo' => $this->handleLogoUpload()
            ];

            $result = $this->model->addPartner($data);
            if ($result) {
                header('Location: /partners?success=added');
            } else {
                header('Location: /partners?error=add_failed');
            }
        }
    }

    public function updatePartner($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'category_id' => $_POST['category_id'],
                'city' => $_POST['city'],
                'offer' => $_POST['offer'],
                'logo' => $_FILES['logo'] ? $this->handleLogoUpload() : $_POST['current_logo']
            ];

            $result = $this->model->updatePartner($id, $data);
            if ($result) {
                header('Location: /partners?success=updated');
            } else {
                header('Location: /partners?error=update_failed');
            }
        }
    }

    public function deletePartner($id) {
        $result = $this->model->deletePartner($id);
        if ($result) {
            header('Location: /partners?success=deleted');
        } else {
            header('Location: /partners?error=delete_failed');
        }
    }

    private function handleLogoUpload() {
        if (!isset($_FILES['logo'])) {
            return null;
        }

        $targetDir = "uploads/logos/";
        $fileName = uniqid() . "_" . basename($_FILES["logo"]["name"]);
        $targetPath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $targetPath)) {
            return $targetPath;
        }

        return null;
    }

    public function getAllPartners(): void
    {
        $this->model->getAllPartners();
    }
}