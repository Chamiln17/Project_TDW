<?php

namespace Models;
require_once "core/Database.php";

class EventModel {
    private $db;
    private $events;
    private $volunteers;

    public function __construct() {
        $this->db = new \Database();
    }

    public function getAllEvents() {
        $this->db->connect();
        $this->events = $this->db->query("
            SELECT 
                e.event_id,
                e.event_name,
                e.event_date,
                e.description,
                COUNT(v.volunteer_id) as volunteer_count,
                CASE 
                    WHEN e.event_date > CURRENT_DATE THEN 'open'
                    ELSE 'closed'
                END as status
            FROM events e
            LEFT JOIN volunteers v ON e.event_id = v.event_id
            GROUP BY e.event_id
            ORDER BY e.event_date DESC
        ");
        $this->db->disconnect();
        return $this->events;
    }

    public function getEventById($eventId) {
        $this->db->connect();
        $event = $this->db->query("
            SELECT 
                e.*,
                COUNT(v.volunteer_id) as volunteer_count,
                CASE 
                    WHEN e.event_date > CURRENT_DATE THEN 'open'
                    ELSE 'closed'
                END as status
            FROM events e
            LEFT JOIN volunteers v ON e.event_id = v.event_id
            WHERE e.event_id = ?
            GROUP BY e.event_id
        ", [$eventId]);
        $this->db->disconnect();
        return $event[0] ?? null;
    }

    public function registerVolunteer($memberId, $eventId) {
        $this->db->connect();
        $result = $this->db->query(
            "INSERT INTO volunteers (member_id, event_id) VALUES (?, ?)",
            [$memberId, $eventId]
        );
        $this->db->disconnect();
        return $result;
    }

    public function getVolunteerStatus($memberId, $eventId) {
        $this->db->connect();
        $status = $this->db->query(
            "SELECT * FROM volunteers WHERE member_id = ? AND event_id = ?",
            [$memberId, $eventId]
        );
        $this->db->disconnect();
        return !empty($status);
    }

    public function getEvent($event_id)
    {
        $this->db->connect();
        $query = "SELECT e.*,
            COUNT(v.volunteer_id) as volunteer_count,
            CASE 
                WHEN e.event_date > CURRENT_DATE THEN 'open'
                ELSE 'closed'
            END as status
        FROM events e
        LEFT JOIN volunteers v ON e.event_id = v.event_id
        WHERE e.event_id = ?
        GROUP BY e.event_id";
        $event = $this->db->query($query, [$event_id]);
        $this->db->disconnect();
        return $event;
    }
    // In EventModel.php, add these methods:

    public function isVolunteerRegistered($memberId, $eventId): bool
    {
        $this->db->connect();
        $result = $this->db->query(
            "SELECT * FROM volunteers WHERE member_id = ? AND event_id = ? LIMIT 1",
            [$memberId, $eventId]
        );
        $this->db->disconnect();
        return !empty($result);
    }

    public function deregisterVolunteer($memberId, $eventId) {
        $this->db->connect();
        $result = $this->db->query(
            "DELETE FROM volunteers WHERE member_id = ? AND event_id = ?",
            [$memberId, $eventId]
        );
        $this->db->disconnect();
        return $result;
    }

}