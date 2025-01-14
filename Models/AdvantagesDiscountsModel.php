<?php
namespace Models;
require_once "core/Database.php";

class AdvantagesDiscountsModel {
    private $db;

    public function __construct() {
        $this->db = new \Database();
    }

    public function getDiscountsByMembershipType($membershipTypeId) {
        $this->db->connect();
        $discounts = $this->db->query("
            SELECT 
                d.discount_percentage,
                d.description as discount_description,
                d.start_date,
                d.end_date,
                p.name as partner_name,
                p.logo as partner_logo,
                p.city,
                c.category_name
            FROM discounts d
            JOIN partners p ON d.partner_id = p.partner_id
            JOIN categories c ON p.category_id = c.category_id
            WHERE d.membership_type_id = ? 
            AND d.start_date <= CURRENT_DATE 
            AND d.end_date >= CURRENT_DATE
            ORDER BY d.discount_percentage DESC
        ", [$membershipTypeId]);
        $this->db->disconnect();
        return $discounts;
    }

    public function getAdvantagesByMembershipType($membershipTypeId) {
        $this->db->connect();
        $advantages = $this->db->query("
            SELECT 
                a.description as advantage_description,
                a.start_date,
                a.end_date,
                p.name as partner_name,
                p.logo as partner_logo,
                p.city,
                c.category_name
            FROM advantages a
            JOIN partners p ON a.partner_id = p.partner_id
            JOIN categories c ON p.category_id = c.category_id
            WHERE a.membership_type_id = ?
            AND a.start_date <= CURRENT_DATE 
            AND a.end_date >= CURRENT_DATE
        ", [$membershipTypeId]);
        $this->db->disconnect();
        return $advantages;
    }

    public function getMembershipType($memberId) {
        $this->db->connect();
        $result = $this->db->query("
            SELECT 
                mt.type_id,
                mt.type_name,
                mt.benefits_description
            FROM members m
            JOIN membership_types mt ON m.membership_type_id = mt.type_id
            WHERE m.member_id = ?
        ", [$memberId]);
        $this->db->disconnect();
        return $result[0] ?? null;
    }

    public function getMemberId(mixed $user_id)
    {
        $this->db->connect();
        $result = $this->db->query("
            SELECT 
                member_id
            FROM members
            WHERE user_id = ?
        ", [$user_id]);
        $this->db->disconnect();
        return $result[0] ?? null;
    }
}
