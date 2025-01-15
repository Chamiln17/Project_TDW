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

    public function registerVolunteer($memberId, $eventId): bool
    {
        try {
            $this->db->connect();

            // First check if the member is already registered
            $existingRegistration = $this->db->query(
                "SELECT * FROM volunteers WHERE member_id = ? AND event_id = ?",
                [$memberId, $eventId]
            );

            if (!empty($existingRegistration)) {
                $this->db->disconnect();
                return false;
            }

            // Check if the event exists and is open
            $event = $this->db->query(
                "SELECT * FROM events WHERE event_id = ? AND event_date > CURRENT_DATE",
                [$eventId]
            );

            if (empty($event)) {
                $this->db->disconnect();
                return false;
            }

            // Proceed with registration
            $result = $this->db->query(
                "INSERT INTO volunteers (member_id, event_id) VALUES (?, ?)",
                [$memberId, $eventId]
            );

            $this->db->disconnect();
            return true;

        } catch (\Exception $e) {
            $this->db->disconnect();
            return false;
        }
    }

    public function getVolunteerStatus($user_id, $eventId)
    {
        $this->db->connect();
        $status = $this->db->query(
            "SELECT COUNT(*) as is_registered 
         FROM volunteers v
         JOIN members m ON v.member_id = m.member_id
         JOIN users u ON m.user_id = u.user_id
         WHERE u.user_id = ? AND v.event_id = ?",
            [$user_id, $eventId]
        );
        $this->db->disconnect();
        return !empty($status) && $status[0]['is_registered'] > 0;
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
    public function memberExists($memberId) {
        $this->db->connect();
        $query = "SELECT COUNT(*) FROM members WHERE member_id = ?";
        $result = $this->db->query($query, [$memberId]);
        $this->db->disconnect();
        return (int)$result[0]['COUNT(*)'] > 0;
    }
    public function getMember($userID) {
        $this->db->connect();
        $query = "SELECT member_id From members m 
                JOIN users u ON m.user_id = u.user_id
              WHERE m.user_id = :user_id";
        $params = ["user_id" => $userID];
        $result = $this->db->query($query, $params);
        $this->db->disconnect();
        return $result;
    }

}