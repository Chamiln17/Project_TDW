<?php

namespace Models;
require_once "core/Database.php";

class AidRequestModel {
    private $db;

    public function __construct() {
        $this->db = new \Database();
    }

    public function createAidRequest($data) {
        $this->db->connect();
        $result = $this->db->query("
            INSERT INTO aid_requests 
            (member_id, requester_name, requester_email, aid_type_id, description, status, submission_date)
            VALUES (?, ?, ?, ?, ?, 'Pending', CURRENT_DATE)
        ", [$data['member_id'], $data['name'], $data['email'], $data['aid_type_id'], $data['description']]);
        $this->db->disconnect();
        return $result;
    }

    public function getAidTypes() {
        $this->db->connect();
        $types = $this->db->query("SELECT * FROM aid_types");
        $this->db->disconnect();
        return $types;
    }

    public function getAidRequests($memberId = null) {
        $this->db->connect();
        $query = "
            SELECT 
                ar.*,
                at.aid_type_name
            FROM aid_requests ar
            JOIN aid_types at ON ar.aid_type_id = at.aid_type_id
        ";

        if ($memberId) {
            $query .= " WHERE ar.member_id = ?";
            $requests = $this->db->query($query, [$memberId]);
        } else {
            $requests = $this->db->query($query);
        }

        $this->db->disconnect();
        return $requests;
    }
}