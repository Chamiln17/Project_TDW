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
        $query = "SELECT m.member_id, m.first_name, m.last_name, m.photo, t.type_name as type_adhesion, m.registration_date, m.expiration_date
              FROM members m
              JOIN membership_types as t ON m.membership_type_id = t.type_id
              WHERE m.user_id = :user_id";
        $params = ["user_id" => $userID];
        $result = $this->db->query($query, $params);
        $this->db->disconnect();
        return $result;
    }
    public function getDiscounts($membershipTypeId) {
        $this->db->connect();
        $query = "SELECT d.discount_percentage, d.start_date, d.end_date
              FROM discounts d
              WHERE d.membership_type_id = :membership_type_id
              AND d.start_date <= CURDATE()
              AND d.end_date >= CURDATE()";
        $params = ["membership_type_id" => $membershipTypeId];
        $result = $this->db->query($query, $params);
        $this->db->disconnect();
        return $result;
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

}