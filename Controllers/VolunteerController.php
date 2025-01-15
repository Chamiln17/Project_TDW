<?php

namespace Controllers;
require_once "models/VolunteerModel.php";

class VolunteerController {
    private $model;

    public function __construct() {
        $this->model = new \Models\VolunteerModel();
    }

    public function displayRegistrationForm() {
        $events = $this->model->getAvailableEvents();
        require_once "views/members/VolunteerRegistrationView.php";
        $view = new \VolunteerRegistrationView();
        $view->display($events);
    }

    public function displayHistory($memberId) {
        $history = $this->model->getVolunteerHistory($memberId);
        require_once "views/members/VolunteerHistoryView.php";
        $view = new \VolunteerHistoryView();
        $view->display($history);
    }
}