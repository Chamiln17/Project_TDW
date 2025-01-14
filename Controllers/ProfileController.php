<?php
namespace Controllers;

use ProfileView;
use Models\MemberModel;
require_once "Views/members/ProfileView.php";
require_once "models/MemberModel.php";

class ProfileController {
    private MemberModel $data;
    private $view;

    public function __construct() {
        $this->data = new MemberModel();
    }

    public function display() {
        $this->view = new ProfileView();
        $this->view->afficherProfile();
    }

    public function get_member($user_id) {
        return $this->data->getMember($user_id);
    }

    public function update_member(): void
    {
        try {
            if (!isset($_SESSION['user_id'])) {
                throw new \RuntimeException("User not logged in");
            }

            $userID = $_SESSION['user_id'];

            // Get form data
            $firstName = $_POST['first_name'] ?? '';
            $lastName = $_POST['last_name'] ?? '';
            $address = $_POST['address'] ?? '';
            $city = $_POST['city'] ?? '';
            $dateOfBirth = $_POST['date_of_birth'] ?? '';

            // Handle file uploads if present
            $photo = null;
            $idDocument = null;

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $photo = $this->handleFileUpload('photo', $userID);
            }

            if (isset($_FILES['piece_identite']) && $_FILES['piece_identite']['error'] === UPLOAD_ERR_OK) {
                $idDocument = $this->handleFileUpload('piece_identite', $userID);
            }

            $memberModel = new MemberModel();
            $result = $memberModel->updateMember(
                $userID,
                $firstName,
                $lastName,
                $address,
                $city,
                $dateOfBirth,
                $photo,
                $idDocument
            );

            if ($result) {
                // Redirect with success message
                header('Location: /Project_TDW/profile');
                exit;
            }

        } catch (\InvalidArgumentException $e) {
            // Handle validation errors
            header('Location: /profile?error=' . urlencode($e->getMessage()));
            exit;
        } catch (\Exception $e) {
            // Handle other errors
            error_log("Profile update error: " . $e->getMessage());
            header('Location: /profile?error=update_failed');
            exit;
        }
    }

    private function handleFileUpload($fieldName, $userID) {
        if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION);
        $fileName = sprintf('%s_%s_%s.%s', $userID, $fieldName, time(), $extension);
        $filePath = $uploadDir . $fileName;

        if (!move_uploaded_file($_FILES[$fieldName]['tmp_name'], $filePath)) {
            throw new \RuntimeException("Failed to upload file: " . $fieldName);
        }

        return $filePath;
    }

    public function generate_member_qr($member_id) {
        return $this->data->generateQRCode($member_id);
    }

    public function getDiscounts($id) {
        return $this->data->getDiscounts($id);
    }

    public function uploadDocument($file, $member_id) {
        return $this->data->saveDocument($file, $member_id);
    }
    public function getCities()
    {
        return $this->data->getCities();
    }

}