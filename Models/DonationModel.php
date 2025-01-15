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

    public function createDonation($member_id, $amount, $recu_paiement)
    {
        $this->db->connect();
        $query = "INSERT INTO donations (member_id, amount, recu_paiement, donation_date) 
              VALUES (:member_id, :amount, :recu_paiement, NOW())";

        $params = [
            ':member_id' => $member_id ?? null,
            ':amount' => $amount,
            ':recu_paiement' => $recu_paiement ?? null
        ];

        $result = $this->db->query($query, $params);
        $this->db->disconnect();
        return $result;
    }

    public function getUserDonations($userId)
    {
        $this->db->connect();
        $query = "SELECT * FROM donations WHERE user_id = :user_id ORDER BY created_at DESC";
        $donations = $this->db->query($query, [':user_id' => $userId]);
        $this->db->disconnect();
        return $donations;
    }

    public function getDonationStats($userId)
    {
        $this->db->connect();
        $query = "SELECT 
                    COUNT(*) as total_donations,
                    SUM(amount) as total_amount,
                    MAX(amount) as highest_donation
                 FROM donations 
                 WHERE user_id = :user_id";

        $stats = $this->db->query($query, [':user_id' => $userId]);
        $this->db->disconnect();
        return $stats[0];
    }

    public function getMemberId($user_id)
    {
        $this->db->connect();
        $query = "SELECT member_id FROM members WHERE user_id = :user_id";
        $memberId = $this->db->query($query, [':user_id' => $user_id]);
        $this->db->disconnect();
        return $memberId[0]['member_id'] ?? null;
    }

}