<?php

namespace Controllers;



class AidRequestController {
    private $model;

    public function __construct() {
        $this->model = new \Models\AidRequestModel();
    }

    public function displayRequestForm() {
        $aidTypes = $this->model->getAidTypes();
        require_once "views/public/AidRequestFormView.php";
        $view = new \AidRequestFormView();
        $view->display($aidTypes);
    }

    public function processRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'member_id' => $_SESSION['member_id'] ?? null,
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'aid_type_id' => $_POST['aid_type'],
                'description' => $_POST['description']
            ];

            $result = $this->model->createAidRequest($data);

            if ($result) {
                header("Location: aid-request/success");
            }
        }
    }
}
