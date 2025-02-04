<?php

namespace Controllers;
use DonationView;
use Models\DonationModel;

require_once "Models/DonationModel.php";
require_once "Views/public/DonationView.php";
require_once "Views/members/DonationHistoryView.php";

class DonationController
{
    private $model;

    public function __construct()
    {
        $this->model = new DonationModel();
    }

    public function displayDonationForm()
    {
        $view = new DonationView();
        $view->afficherDonation();
    }

    public function displayDonationHistory()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id']) && $_SESSION['role'] != "member") {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $member_id = $this->getMemberId($userId);
        $donations = $this->getUserDonations($member_id);
        $stats = $this->getDonationStats($member_id);

        $view = new \members\DonationHistoryView();
        $view->display();
    }

    public function handleDonation()
    {
        var_dump($_SESSION);
        $userId = $_SESSION['user_id'];
        $result = $this->donate($userId);

        if ($result['success']) {
            $_SESSION['success'] = "Donation processed successfully";
            header('Location: /Project_TDW/donation');
            exit();
        } else {
            $_SESSION['error'] = $result['message'];
            header('Location: /Project_TDW/donation');
            exit();
        }
    }

    public function donate($userId): array
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Invalid request method'];
        }

        if (!isset($_SESSION['user_id'])) {
            return ['success' => false, 'message' => 'User must be logged in'];
        }

        $member_id = $this->getMemberId($userId);
        if (!$member_id) {
            return ['success' => false, 'message' => 'Member not found'];
        }

        // Get amount
        $amount = $_POST['amount'] ?? '';
        if (empty($amount)) {
            return ['success' => false, 'message' => 'Amount is required'];
        }

        // Handle file uploads if present
        $recu_paiement = null;
        if (isset($_FILES['recu_paiement']) && $_FILES['recu_paiement']['error'] === UPLOAD_ERR_OK) {
            try {
                $recu_paiement = $this->handleFileUpload('recu_paiement', $member_id);
            } catch (\RuntimeException $e) {
                return ['success' => false, 'message' => $e->getMessage()];
            }
        }

        $result = $this->createDonation($member_id, $amount, $recu_paiement);

        if ($result) {
            $this->sendConfirmationEmail($member_id, $amount);
            return ['success' => true, 'message' => 'Donation processed successfully'];
        }

        return ['success' => false, 'message' => 'Error processing donation'];
    }

    private function handleFileUpload($fieldName, $member_id): ?string
    {
        if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $uploadDir = 'uploads/recu_donations/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION);
        $fileName = sprintf('%s_%s_%s.%s', $member_id, $fieldName, time(), $extension);
        $filePath = $uploadDir . $fileName;

        if (!move_uploaded_file($_FILES[$fieldName]['tmp_name'], $filePath)) {
            throw new \RuntimeException("Failed to upload file: " . $fieldName);
        }

        return $filePath;
    }


    private function sendConfirmationEmail($member_id, $amount)
    {
        // Send email to user
        $to = ''; // User's email
        $subject = 'Donation Confirmation';
        $message = "Thank you for your donation of $amount. We appreciate your support!";
        $headers = 'From:';
        mail($to, $subject, $message, $headers);
    }

    private function createDonation(mixed $member_id, mixed $amount, ?string $recu_paiement)
    {
        return $this->model->createDonation($member_id, $amount, $recu_paiement);
    }
    public function getMemberId($user_id) {
        return $this->model->getMemberId($user_id);
    }

    public function getUserDonations(mixed $user_id)
    {
        $member_id=$this->getMemberId($user_id);
        return $this->model->getUserDonations($member_id);
    }

    public function getDonationStats(mixed $user_id)
    {
        $member_id=$this->getMemberId($user_id);
        return $this->model->getDonationStats($member_id);
    }


}