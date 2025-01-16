<?php

namespace Models;

require_once "core/Database.php";

class AdminMemberModel
{
    private $db;

    public function __construct()
    {
        $this->db = new \Database();
    }

    // Fetch all members with optional filters
    public function getMembers($filters = [])
    {
        $this->db->connect();
        $sql = "SELECT m.*, u.email, u.username, mt.type_name AS membership_type,
                       m.registration_date, m.is_validated, m.is_blocked,
                       m.photo, m.telephone
                FROM members m
                JOIN users u ON m.user_id = u.user_id
                JOIN membership_types mt ON m.membership_type_id = mt.type_id";

        $whereClauses = [];
        $params = [];

        if (!empty($filters['registration_date'])) {
            $whereClauses[] = "DATE(m.registration_date) = ?";
            $params[] = $filters['registration_date'];
        }

        if (!empty($filters['membership_type'])) {
            $whereClauses[] = "mt.type_name = ?";
            $params[] = $filters['membership_type'];
        }

        if (!empty($filters['status'])) {
            $whereClauses[] = "m.is_validated = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['search'])) {
            $whereClauses[] = "(m.first_name LIKE ? OR m.last_name LIKE ? OR u.email LIKE ?)";
            $searchTerm = "%{$filters['search']}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        if (!empty($whereClauses)) {
            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        }

        $sql .= " ORDER BY m.registration_date DESC";

        $members = $this->db->query($sql, $params);
        $this->db->disconnect();
        return $members;
    }

    // Get member details including all related information
    public function getMemberDetails($memberId)
    {
        $this->db->connect();
        $sql = "SELECT m.*, u.email, u.username, mt.type_name AS membership_type
                FROM members m
                JOIN users u ON m.user_id = u.user_id
                JOIN membership_types mt ON m.membership_type_id = mt.type_id
                WHERE m.member_id = ?";

        $member = $this->db->query($sql, [$memberId]);
        $this->db->disconnect();
        return $member[0] ?? null;
    }

    // Update member validation status
    public function updateMemberStatus($memberId, $status)
    {
        $this->db->connect();

        $sql = "UPDATE members SET is_validated = ?, expiration_date = DATE_ADD(NOW(), INTERVAL 1 YEAR) WHERE member_id = ?";

        $result = $this->db->execute($sql, [$status, $memberId]);

        $this->db->disconnect();
        return $result;
    }

    // Block/Unblock member
    public function toggleBlockStatus($memberId)
    {
        $this->db->connect();
        $sql = "UPDATE members SET is_blocked = NOT is_blocked WHERE member_id = ?";
        $result = $this->db->execute($sql, [$memberId]);
        $this->db->disconnect();
        return $result;
    }

    // Delete member
    public function deleteMember($memberId)
    {
        // Connect to the database
        $this->db->connect();

        try {
            // Start a transaction
            $this->db->beginTransaction();

            // Delete related records in the aid_requests table
            $sql1 = "DELETE FROM aid_requests WHERE member_id = ?";
            $this->db->execute($sql1, [$memberId]);

            // Delete related records in the donations table
            $sql2 = "DELETE FROM donations WHERE member_id = ?";
            $this->db->execute($sql2, [$memberId]);

            // Delete related records in the notifications table
            $sql3 = "DELETE FROM notifications WHERE member_id = ?";
            $this->db->execute($sql3, [$memberId]);

            // Delete related records in the favorite_partners table
            $sql4 = "DELETE FROM favorite_partners WHERE member_id = ?";
            $this->db->execute($sql4, [$memberId]);

            // Delete related records in the volunteers table
            $sql5 = "DELETE FROM volunteers WHERE member_id = ?";
            $this->db->execute($sql5, [$memberId]);

            // Now, delete the member from the members table
            $sql6 = "DELETE FROM members WHERE member_id = ?";
            $this->db->execute($sql6, [$memberId]);

            // Commit the transaction if all deletions succeed
            $this->db->commit();
            $result = true; // Indicate success
        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            $this->db->rollBack();
            $result = false; // Indicate failure
            // Optionally, log the error or handle it as needed
            error_log("Error deleting member: " . $e->getMessage());
        } finally {
            // Disconnect from the database
            $this->db->disconnect();
        }

        return $result;
    }

    // Get membership types for filter
    public function getMembershipTypes()
    {
        $this->db->connect();
        $sql = "SELECT type_id, type_name FROM membership_types";
        $types = $this->db->query($sql);
        $this->db->disconnect();
        return $types;
    }
}