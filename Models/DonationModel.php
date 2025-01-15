<?php

namespace Models;
require_once "core/Database.php";

class DonationModel
{
    private $db;

    public function __construct()
    {
        $this->db = new \Database();
    }

    public function createDonation($member_id, $amount, $recu_paiement): false
    {
        try {
            $this->db->connect();

            $query = "INSERT INTO donations (member_id, amount, recu_paiement, donation_date) 
                     VALUES (:member_id, :amount, :recu_paiement, NOW())";

            $params = [
                ':member_id' => $member_id,
                ':amount' => $amount,
                ':recu_paiement' => $recu_paiement
            ];

            // Execute the query and get the result
            $success = $this->db->query($query, $params);

            // For INSERT queries, we should check if the execution was successful
            // and optionally get the last inserted ID
            if ($success) {
                $lastInsertId = $this->db->lastInsertId();
                $this->db->disconnect();
                return $lastInsertId; // This will be truthy if successful
            }

            $this->db->disconnect();
            return false;

        } catch (\Exception $e) {
            error_log("Database error in createDonation: " . $e->getMessage());
            $this->db->disconnect();
            return false;
        }
    }

    public function getUserDonations($member_id)
    {
        $this->db->connect();
        $query = "SELECT * FROM donations WHERE member_id = :member_id ORDER BY donation_date DESC";
        $donations = $this->db->query($query, [':member_id' => $member_id]);
        $this->db->disconnect();
        return $donations;
    }

    public function getDonationStats($member_id)
    {
        $this->db->connect();
        $query = "SELECT 
                COUNT(*) as total_donations,
                SUM(amount) as total_amount,
                COUNT(CASE WHEN is_delivered = 1 THEN 1 END) as delivered_donations,
                MAX(amount) as highest_donation,
                MIN(amount) as lowest_donation,
                AVG(amount) as average_donation,
                COUNT(CASE WHEN MONTH(donation_date) = MONTH(CURRENT_DATE) THEN 1 END) as donations_this_month
             FROM donations 
             WHERE member_id = :member_id";

        $stats = $this->db->query($query, [':member_id' => $member_id]);
        $this->db->disconnect();
        return $stats[0];
    }

    public function getMemberId($userID)
    {
        $this->db->connect();
        $query = "SELECT member_id FROM members WHERE user_id = :user_id";
        $memberId = $this->db->query($query, [':user_id' => $userID]);
        $this->db->disconnect();
        return $memberId[0]['member_id'] ?? null;
    }

}