<?php

namespace Controllers;
use Models\EventModel;
use Models\MemberModel;

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
            $_SESSION['error'] = "Event not found";
            header('Location: /Project_TDW/events');
            exit();
        }
    }

    public function handleVolunteerRegistration($eventId) {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Please log in to register for events";
            header("Location: /Project_TDW/events/$eventId");
            exit();
        }

        // Get member data and extract ID
        $memberData = $this->getMemberByID($_SESSION['user_id']);
        if (!$memberData || !isset($memberData[0]['member_id'])) {
            $_SESSION['error'] = "Invalid member account";
            header("Location: /Project_TDW/events/$eventId");
            exit();
        }

        $memberId = $memberData[0]['member_id'];
        $action = $_POST['action'] ?? 'register';

        try {
            if ($action === 'register') {
                $result = $this->registerVolunteer($memberId, $eventId);
                if ($result['success']) {
                    $_SESSION['success'] = $result['message'];
                } else {
                    $_SESSION['error'] = $result['message'];
                }
            } else {
                $result = $this->deregisterVolunteer($memberId, $eventId);
                if ($result['success']) {
                    $_SESSION['success'] = $result['message'];
                } else {
                    $_SESSION['error'] = $result['message'];
                }
            }
        } catch (\Exception $e) {
            // Handle database errors
            if ($e->getCode() == '23000') { // Foreign key constraint violation
                $_SESSION['error'] = "Unable to register: Invalid member or event";
            } else {
                $_SESSION['error'] = "An error occurred while processing your request";
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = "An unexpected error occurred";
        }

        // Redirect back to event page
        header("Location: /Project_TDW/events/$eventId");
        exit();
    }

    public function registerVolunteer($memberId, $eventId) {
        // Validate member exists
        if (!$this->model->memberExists($memberId)) {
            return ["success" => false, "message" => "Member account not found"];
        }

        // Check if already registered
        if ($this->model->getVolunteerStatus($memberId, $eventId)) {
            return ["success" => false, "message" => "You are already registered for this event"];
        }

        // Attempt registration
        $result = $this->model->registerVolunteer($memberId, $eventId);
        if ($result) {
            return ["success" => true, "message" => "Successfully registered as volunteer"];
        }

        return ["success" => false, "message" => "Unable to complete registration. Please try again later."];
    }

    public function getEvents() {
        return $this->model->getAllEvents();
    }

    private function getEventById($eventId) {
        return $this->model->getEvent($eventId);
    }

    public function getVolunteerStatus($user_id, $event_id) {
        return $this->model->getVolunteerStatus($user_id, $event_id);
    }

    public function deregisterVolunteer($memberId, $eventId) {
        return $this->model->deregisterVolunteer($memberId, $eventId);
    }

    public function getMemberByID($user_id) {
        return $this->model->getMember($user_id);
    }
}