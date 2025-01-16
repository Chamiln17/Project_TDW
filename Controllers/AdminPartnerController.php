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
    public function displayPartners(): void
    {
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

    public function addPartner(): void
    {
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

    public function updatePartner($id): void
    {
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

    public function deletePartner($id): void
    {
        $result = $this->model->deletePartner($id);
        if ($result) {
            header('Location: /partners?success=deleted');
        } else {
            header('Location: /partners?error=delete_failed');
        }
    }

    private function handleLogoUpload() {
        if (!isset($_FILES['logo']) || $_FILES['logo']['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        $uploadDir = '/uploads/logos/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '_' . basename($_FILES['logo']['name']);
        $uploadFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadFile)) {
            return $uploadFile;
        }

        return null;
    }

    public function getAllPartners(): void
    {
        $this->model->getAllPartners();
    }
    public function add() {
        $this->view=new \AdminPartnerView();
        $this->view->displayPartnerManagement(
            $this->model->getAllPartners(),
            $this->model->getPartnerStats(),
            null,
            'new'
        );
    }

    public function edit($id) {
        $partner = $this->model->getPartnerById($id);
        if ($partner) {
            $this->view=new \AdminPartnerView();
            $this->view->displayPartnerManagement(
                $this->model->getAllPartners(),
                $this->model->getPartnerStats(),
                $partner[0],
                'edit'
            );
        } else {
            header('Location: /Project_TDW/admin/partners');
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $logoPath = $this->handleLogoUpload();

            $data = [
                'email' => $_POST['email'],
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'name' => $_POST['name'],
                'category_id' => $_POST['category'],
                'city' => $_POST['city'],
                'offer' => $_POST['offer'],
                'logo' => $logoPath
            ];

            try {
                if ($this->model->addPartner($data)) {
                    $_SESSION['success'] = "Partenaire ajouté avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de l'ajout du partenaire.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage(); // Set the error message from the exception
            }

            header('Location: /Project_TDW/admin/partners');
            exit();
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $logoPath = $this->handleLogoUpload();

            $data = [
                'email' => $_POST['email'],
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'name' => $_POST['name'],
                'category_id' => $_POST['category'],
                'city' => $_POST['city'],
                'offer' => $_POST['offer'],
                'logo' => $logoPath
            ];

            try {
                if ($this->model->updatePartner($id, $data)) {
                    $_SESSION['success'] = "Partenaire mis à jour avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la mise à jour du partenaire.";
                }
            } catch (\Exception $e) {
                $_SESSION['error'] = $e->getMessage(); // Set the error message from the exception

            }

            header('Location: /Project_TDW/admin/partners');
            exit();
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model->deletePartner($id)) {
                $_SESSION['success'] = "Partenaire supprimé avec succès";
            } else {
                $_SESSION['error'] = "Erreur lors de la suppression du partenaire. Veuillez vérifier les logs pour plus de détails.";
            }

            header('Location: /Project_TDW/admin/partners');
            exit();
        }
    }

    public function getCities()
    {
       return $this->model->getCities();
    }
}