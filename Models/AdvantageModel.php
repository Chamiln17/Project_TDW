<?php

namespace Models;

use Database;

class AdvantageModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->db->connect();
    }

    public function getAdvantagesByPartnerId($partnerId)
    {
        $query = "SELECT * FROM advantages WHERE partner_id = :partner_id";
        $params = [':partner_id' => $partnerId];
        return $this->db->query($query, $params);
    }

    public function getAdvantageById($advantageId)
    {
        $query = "SELECT * FROM advantages WHERE advantage_id = :advantage_id";
        $params = [':advantage_id' => $advantageId];
        return $this->db->query($query, $params)[0];
    }

    public function addAdvantage($partnerId, $data)
    {
        $query = "INSERT INTO advantages (partner_id, membership_type_id, description, start_date, end_date) 
                  VALUES (:partner_id, :membership_type_id, :description, :start_date, :end_date)";
        $params = [
            ':partner_id' => $partnerId,
            ':membership_type_id' => $data['membership_type_id'],
            ':description' => $data['description'],
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date']
        ];
        $this->db->execute($query, $params);
    }

    public function updateAdvantage($advantageId, $data)
    {
        $query = "UPDATE advantages 
                  SET description = :description, start_date = :start_date, end_date = :end_date, membership_type_id = :membership_type_id
                  WHERE advantage_id = :advantage_id";
        $params = [
            ':advantage_id' => $advantageId,
            ':description' => $data['description'],
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date'],
            ':membership_type_id' => $data['membership_type_id']
        ];
        $this->db->execute($query, $params);
    }

    public function deleteAdvantage($advantageId)
    {
        $query = "DELETE FROM advantages WHERE advantage_id = :advantage_id";
        $params = [':advantage_id' => $advantageId];
        $this->db->execute($query, $params);
    }
}