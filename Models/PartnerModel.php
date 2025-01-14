<?php
namespace Models;
use Database;
require_once "core/Database.php";

class PartnerModel {
    private Database $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getPartnerDetails($partnerId) {
        $this->db->connect();
        $query = "SELECT p.*, c.category_name as categoryName,
                  CASE WHEN fp.favorite_id IS NOT NULL THEN 1 ELSE 0 END as isFavorite
                  FROM partners p
                  JOIN categories c ON p.category_id = c.category_id
                  LEFT JOIN favorite_partners fp ON p.partner_id = fp.partner_id 
                    AND fp.member_id = (SELECT member_id FROM members WHERE user_id = :user_id)
                  WHERE p.partner_id = :partner_id";

        $params = [
            ':partner_id' => $partnerId,
            ':user_id' => $_SESSION['user_id'] ?? null
        ];

        $result = $this->db->query($query, $params);
        $this->db->disconnect();
        return $result[0] ?? null;
    }

    public function getPartnerAdvantages($partnerId) {
        $this->db->connect();
        $query = "SELECT a.*, mt.type_name as membershipType
                 FROM advantages a
                 JOIN membership_types mt ON a.membership_type_id = mt.type_id
                 WHERE a.partner_id = :partner_id
                 AND CURRENT_DATE BETWEEN a.start_date AND a.end_date
                 ORDER BY a.start_date DESC";

        $params = [':partner_id' => $partnerId];
        $result = $this->db->query($query, $params);
        $this->db->disconnect();
        return $result;
    }

    public function getPartnerDiscounts($partnerId) {
        $this->db->connect();
        $query = "SELECT d.*, mt.type_name as membershipType
                 FROM discounts d
                 JOIN membership_types mt ON d.membership_type_id = mt.type_id
                 WHERE d.partner_id = :partner_id
                 AND CURRENT_DATE BETWEEN d.start_date AND d.end_date
                 ORDER BY d.discount_percentage DESC";

        $params = [':partner_id' => $partnerId];
        $result = $this->db->query($query, $params);
        $this->db->disconnect();
        return $result;
    }
}