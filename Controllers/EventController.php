<?php

namespace Controllers;
use Models\EventModel;

require_once "Models/EventModel.php";
require_once "Views/public/EventsView.php";
require_once "Views/public/EventDetailsView.php";

class EventController {
    private $model;

    public function __construct() {
        $this->model = new EventModel();
    }

    public function displayEvents() {
        $view = new \EventsView();
        $view->displayEventsList();
    }

    public function displayEventDetails($event_id) {
        $event = $this->getEventById($event_id);
        if ($event) {
            $view = new \EventDetailsView();
            $view->displayEventDetails($event[0]);
        } else {
            // Handle event not found
            // Redirect to events list
            header('Location: /events');
        }
    }
    public function handleVolunteerRegistration($eventId) {
        if (!isset($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode([
                "success" => false,
                "message" => "User not authenticated"
            ]);
            return;
        }

        $memberId = $_SESSION['user_id'];
        $action = $_POST['action'] ?? 'register';

        if ($action === 'register') {
            $result = $this->registerVolunteer($memberId, $eventId);
        } else {
            $result = $this->deregisterVolunteer($memberId, $eventId);
        }

        header('Content-Type: application/json');
        echo json_encode($result);
    }
    public function registerVolunteer($memberId, $eventId) {
        if (!$this->model->getVolunteerStatus($memberId, $eventId)) {
            $result = $this->model->registerVolunteer($memberId, $eventId);
            if ($result) {
                return ["success" => true, "message" => "Successfully registered as volunteer"];
            }
        }
        return ["success" => false, "message" => "Already registered or registration failed"];
    }

    public function getEvents()
    {
        return $this->model->getAllEvents();
    }

    private function getEventById($eventId)
    {
        return $this->model->getEvent($eventId);
    }

    public function getVolunteerStatus(mixed $user_id, mixed $event_id)
    {
        return $this->model->getVolunteerStatus($user_id, $event_id);
    }


}