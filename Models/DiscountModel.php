<?php

namespace Models;

use Database;

class DiscountModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->db->connect();
    }

    public function getDiscountsByPartnerId($partnerId)
    {
        $query = "SELECT * FROM discounts WHERE partner_id = :partner_id";
        $params = [':partner_id' => $partnerId];
        return $this->db->query($query, $params);
    }

    public function getDiscountById($discountId)
    {
        $query = "SELECT * FROM discounts WHERE discount_id = :discount_id";
        $params = [':discount_id' => $discountId];
        return $this->db->query($query, $params)[0];
    }

    public function addDiscount($partnerId, $data)
    {
        $query = "INSERT INTO discounts (partner_id, membership_type_id, description, discount_percentage, start_date, end_date) 
                  VALUES (:partner_id, :membership_type_id, :description, :discount_percentage, :start_date, :end_date)";
        $params = [
            ':partner_id' => $partnerId,
            ':membership_type_id' => $data['membership_type_id'],
            ':description' => $data['description'],
            ':discount_percentage' => $data['discount_percentage'],
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date']
        ];
        $this->db->execute($query, $params);
    }

    public function updateDiscount($discountId, $data)
    {
        $query = "UPDATE discounts 
                  SET description = :description, discount_percentage = :discount_percentage, 
                      start_date = :start_date, end_date = :end_date, membership_type_id = :membership_type_id
                  WHERE discount_id = :discount_id";
        $params = [
            ':discount_id' => $discountId,
            ':description' => $data['description'],
            ':discount_percentage' => $data['discount_percentage'],
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date'],
            ':membership_type_id' => $data['membership_type_id']
        ];
        $this->db->execute($query, $params);
    }

    public function deleteDiscount($discountId)
    {
        $query = "DELETE FROM discounts WHERE discount_id = :discount_id";
        $params = [':discount_id' => $discountId];
        $this->db->execute($query, $params);
    }
}