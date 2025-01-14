<?php

namespace Models;
use Database;
require_once __DIR__ . '/../vendor/autoload.php';
use PDOException;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
require_once "core/Database.php";


class MemberModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }
// models/MemberModel.php
    public function getMember($userID) {
        $this->db->connect();
        $query = "SELECT * , t.type_name as type_adhesion
              FROM members m
                JOIN users u ON m.user_id = u.user_id
              JOIN membership_types as t ON m.membership_type_id = t.type_id
              WHERE m.user_id = :user_id";
        $params = ["user_id" => $userID];
        $result = $this->db->query($query, $params);
        $this->db->disconnect();
        return $result;
    }
    public function getDiscounts($membershipTypeId) {
        $this->db->connect();
        $query = "SELECT 
                  p.name AS 'Partenaire', 
                  d.discount_percentage AS 'Remise (%)', 
                  t.type_name AS 'Type dadhésion', 
                  d.start_date AS 'Date début', 
                  d.end_date AS 'Date fin'
              FROM 
                  discounts d
              JOIN 
                  partners p ON d.partner_id = p.partner_id
              JOIN 
                  membership_types t ON d.membership_type_id = t.type_id
              WHERE 
                  d.membership_type_id = :membership_type_id
              AND 
                  d.start_date <= CURDATE()
              AND 
                  d.end_date >= CURDATE()";
        $params = ["membership_type_id" => $membershipTypeId];
        $result = $this->db->query($query, $params);
        $this->db->disconnect();
        return $result;
    }
    public function updateMember($userID, $first_name, $last_name, $address, $city, $date_of_birth, $photo = null, $id_document = null) {
        try {
            // Input validation
            if (empty($userID)) {
                throw new \InvalidArgumentException("User ID is required");
            }

            if (empty($first_name) || empty($last_name) || empty($address) || empty($city) || empty($date_of_birth)) {
                throw new \InvalidArgumentException("All required fields must be filled");
            }

            $this->db->connect();
            $this->db->beginTransaction();

            // First, get the member_id using user_id
            $getMemberQuery = "SELECT member_id FROM members WHERE user_id = :user_id";
            $memberResult = $this->db->query($getMemberQuery, ["user_id" => $userID]);

            if (empty($memberResult)) {
                throw new \RuntimeException("No member found for user ID: $userID");
            }

            $memberID = $memberResult[0]['member_id'];

            // Handle file uploads if provided
            $photoPath = null;
            $idDocumentPath = null;

            if ($photo !== null) {
                $photoPath = $this->uploadFile('photo', $memberID);
            }

            if ($id_document !== null) {
                $idDocumentPath = $this->uploadFile('id_document', $memberID);
            }

            // Build the update query
            $updateFields = [
                "first_name = :first_name",
                "last_name = :last_name",
                "address = :address",
                "city = :city",
                "date_of_birth = :date_of_birth"
            ];

            $params = [
                "first_name" => trim($first_name),
                "last_name" => trim($last_name),
                "address" => trim($address),
                "city" => trim($city),
                "date_of_birth" => $date_of_birth,
                "memberID" => $memberID
            ];

            if ($photoPath !== null) {
                $updateFields[] = "photo = :photo";
                $params["photo"] = $photoPath;
            }

            if ($idDocumentPath !== null) {
                $updateFields[] = "id_document = :id_document";
                $params["id_document"] = $idDocumentPath;
            }

            $query = "UPDATE members SET " .
                implode(", ", $updateFields) .
                " WHERE member_id = :memberID";

            // Execute update
            $this->db->execute($query, $params);


            $this->db->commit();
            return true;

        } catch (\Exception $e) {
            if (isset($this->db)) {
                $this->db->rollBack();
            }
            error_log("Error in updateMember: " . $e->getMessage());
            throw $e;

        } finally {
            if (isset($this->db)) {
                $this->db->disconnect();
            }
        }
    }
    public function generateQRCode($memberId): ?string

    {
        try {
            // Create QR code with just the member ID
            $qrCode = new \Endroid\QrCode\QrCode($memberId);



            // Create writer and write QR code
            $writer = new \Endroid\QrCode\Writer\PngWriter();
            $result = $writer->write($qrCode);

            // Return data URI
            return $result->getDataUri();
        } catch (\Exception $e) {
            error_log("Error generating QR code: " . $e->getMessage());
            return null;
        }
    }
    private function uploadFile($field , $userID): ?string
    {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true); // Create directory if it doesn't exist
            }
            if ($field == 'photo') {
                $fileName = $userID . '_photo_' . basename($_FILES[$field]['name']);
            } elseif ($field == 'piece_identite') {
                $fileName = $userID . '_id_' . basename($_FILES[$field]['name']);
            } elseif ($field == 'recu_paiement') {
                $fileName = $userID . '_recu_' . basename($_FILES[$field]['name']);
            }
            else {
                $fileName = basename($_FILES[$field]['name']);
            }
            $filePath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES[$field]['tmp_name'], $filePath)) {
                return $filePath;
            } else {
                // Handle upload error
                error_log("Failed to upload file: " . $field);
                return null;
            }
        }
        return null;
    }
    public function getCities()
    {
        $this->db->connect();
        $query = "SELECT * FROM cities";
        $cities = $this->db->query($query);
        $this->db->disconnect();
        return $cities;
    }
}