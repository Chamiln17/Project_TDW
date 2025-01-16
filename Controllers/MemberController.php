<?php

namespace Controllers;

use Models\AdminMemberModel;

require_once "views/admin/AdminMemberView.php";
require_once "views/admin/AdminMemberDetails.php";
require_once "models/AdminMemberModel.php";

class MemberController
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new AdminMemberModel();
    }

    // Afficher la liste des membres
    public function displayMembers()
    {
        $this->view = new \AdminMemberView();
        $filters = [
            'search' => $_GET['search'] ?? null,
            'registration_date' => $_GET['date'] ?? null,
            'membership_type' => $_GET['membership'] ?? null,
            'status' => $_GET['status'] ?? null,
        ];

        $members = $this->model->getMembers($filters);
        $this->view->displayMemberList($members);
    }

    // Afficher les détails d'un membre spécifique
    public function displayMemberDetails($memberId)
    {
        $member = $this->model->getMemberDetails($memberId);
        if (!$member) {
            header("Location: /Project_TDW/admin/members");
            exit;
        }
        $this->view = new \AdminMemberDetails();
        $this->view->displayMemberDetails($member);
    }

    // Approuver un membre
    public function approveMember($memberId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $success = $this->model->updateMemberStatus($memberId, 1); // 1 = approuvé
            header('Location: /Project_TDW/admin/members');
            return $success;
            exit;
        }
        header("Location: /Project_TDW/admin/members");
    }

    // Rejeter un membre
    public function rejectMember($memberId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $success = $this->model->updateMemberStatus($memberId, 0); // 0 = rejeté
            header('Content-Type: application/json');
            echo json_encode(['success' => $success]);
            exit;
        }
        header("Location: /Project_TDW/admin/members");
    }

    // Basculer le statut de blocage d'un membre
    public function toggleBlockStatus($memberId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $success = $this->model->toggleBlockStatus($memberId);
            header('Location: /Project_TDW/admin/members');
            echo json_encode(['success' => $success]);
            exit;
        }
        header("Location: /Project_TDW/admin/members");
    }

    // Supprimer un membre
    public function deleteMember($memberId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $success = $this->model->deleteMember($memberId);
            header('Location: /Project_TDW/admin/members');
            return json_encode(['success' => $success]);
            exit;
        }
        header("Location: /Project_TDW/admin/members");
    }

    // Récupérer les types de carte
    public function getMembershipsType()
    {
        return $this->model->getMembershipTypes();
    }
}