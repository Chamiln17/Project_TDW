<?php

namespace Controllers;

use Models\MemberModel;

require_once "views/admin/MemberView.php";
require_once "models/MemberModel.php";

class MemberController
{
    private $model;

    public function __construct()
    {
        $this->model = new MemberModel();
    }

    // Display the list of members
    public function displayMembers()
    {
        $filters = [
            'registration_date' => $_GET['registration_date'] ?? null,
            'membership_type' => $_GET['membership_type'] ?? null,
            'preferred_sector' => $_GET['preferred_sector'] ?? null,
        ];

        $members = $this->model->getMembers($filters);
        $view = new \MemberView();
        $view->displayMemberList($members);
    }

    // Display member details
    public function displayMemberDetails($memberId)
    {
        $member = $this->model->getMemberDetails($memberId);
        $donations = $this->model->getMemberDonations($memberId);
        $volunteers = $this->model->getMemberVolunteers($memberId);

        $view = new \MemberView();
        $view->displayMemberDetails($member, $donations, $volunteers);
    }

    // Approve or reject a member
    public function updateMemberStatus($memberId, $status)
    {
        $this->model->updateMemberStatus($memberId, $status);
        header("Location: /Project_TDW/admin/members");
    }

    // Delete a member
    public function deleteMember($memberId)
    {
        $this->model->deleteMember($memberId);
        header("Location: /Project_TDW/admin/members");
    }
}