<?php

namespace Models;
require_once "core/Database.php";

class VolunteerModel {
    private $db;

    public function __construct() {
        $this->db = new \Database();
    }

    public function getAvailableEvents() {
        $this->db->connect();
        $events = $this->db->query("
            SELECT * FROM events 
            WHERE event_date >= CURRENT_DATE
            ORDER BY event_date ASC
        ");
        $this->db->disconnect();
        return $events;
    }

    public function registerVolunteer($memberId, $eventId) {
        $this->db->connect();
        $result = $this->db->query("
            INSERT INTO volunteers (member_id, event_id)
            VALUES (?, ?)
        ", [$memberId, $eventId]);
        $this->db->disconnect();
        return $result;
    }

    public function getVolunteerHistory($memberId) {
        $this->db->connect();
        $history = $this->db->query("
            SELECT 
                e.event_name,
                e.event_date,
                e.description
            FROM volunteers v
            JOIN events e ON v.event_id = e.event_id
            WHERE v.member_id = ?
            ORDER BY e.event_date DESC
        ", [$memberId]);
        $this->db->disconnect();
        return $history;
    }
}