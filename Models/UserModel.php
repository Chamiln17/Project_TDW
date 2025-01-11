<?php

namespace Models;
use Database;
use PDOException;

require_once "core/Database.php";


class UserModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function register_hashed($username, $email, $password, $role = 'member')
    {
        // Hash the password
        // Connect to the database
        $this->db->connect()
        ;

        // Prepare the query
        $query = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $params = [
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
            ':role' => $role
        ];

        // Execute the query
        $result = $this->db->execute($query, $params);

        // Disconnect from the database
        $this->db->disconnect();

        return $result; // Return the result of the execution

    }
    public function register($username, $email, $password, $prenom, $nom, $adresse, $date_naissance, $type_adhesion, $role = 'member')
    {
        // Hash the password (if needed)
        // $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Connect to the database
        $this->db->connect();

        try {
            // Start the transaction
            $this->db->beginTransaction();

            // Prepare the query for users table
            $query = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
            $params = [
                ':username' => $username,
                ':email' => $email,
                ':password' => $password, // Use $hashedPassword if hashing is enabled
                ':role' => $role
            ];

            // Execute the query for users table
            $this->db->execute($query, $params);

            // Get the user_id of the inserted user
            $user_id = $this->db->lastInsertId();

            // Prepare the query for members table
            $query = "INSERT INTO members (user_id, first_name, last_name, address, date_of_birth, membership_type_id, registration_date, photo, id_document, recu_paiement)
                  VALUES (:user_id, :first_name, :last_name, :address, :date_of_birth, :membership_type_id, NOW(), :photo, :id_document, :recu_paiement)";
            $params = [
                ':user_id' => $user_id,
                ':first_name' => $prenom,
                ':last_name' => $nom,
                ':address' => $adresse,
                ':date_of_birth' => $date_naissance,
                ':membership_type_id' => $this->getMembershipTypeId($type_adhesion),
                ':photo' => $this->uploadFile('photo' , $user_id),
                ':id_document' => $this->uploadFile('piece_identite', $user_id),
                ':recu_paiement' => $this->uploadFile('recu_paiement', $user_id)
            ];

            // Execute the query for members table
            $this->db->execute($query, $params);

            // Commit the transaction if both queries succeed
            $this->db->commit();

            // Disconnect from the database
            $this->db->disconnect();

            return true; // Registration successful
        } catch (PDOException $e) {
            // Rollback the transaction if any query fails
            $this->db->rollBack();

            // Log the error (optional)
            error_log("Registration failed: " . $e->getMessage());

            // Disconnect from the database
            $this->db->disconnect();

            return false; // Registration failed
        }
    }
    public function login($input, $password)
    {
        // Connect to the database
        $this->db->connect();

        // Determine if the input is an email or username
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } else {
            $field = 'username';
        }

        // Prepare the query
        $query = "SELECT * FROM users WHERE $field = :input";
        $params = [
            ':input' => $input
        ];

        // Execute the query
        $user = $this->db->query($query, $params);

        // Disconnect from the database
        $this->db->disconnect();

        if (!empty($user)) {
            // Verify the password
            if ($password == $user[0]['password']) {
                return $user[0]; // Return the user data if password is correct
            } else {
                return false; // Return false if password is incorrect
            }
        }
        return false; // Return false if user is not found

    }
    public function login_hashed($input, $password)
    {
        // Connect to the database
        $this->db->connect();

        // Determine if the input is an email or username
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } else {
            $field = 'username';
        }

        // Prepare the query
        $query = "SELECT * FROM users WHERE $field = :input";
        $params = [
            ':input' => $input
        ];

        // Execute the query
        $user = $this->db->query($query, $params);

        // Disconnect from the database
        $this->db->disconnect();

        if (!empty($user)) {
            // Verify the password
            if (password_verify($password, $user[0]['password'])) {
                return $user[0]; // Return the user data if password is correct
            } else {
                return false; // Return false if password is incorrect
            }
        } else {
            return false; // Return false if user is not found
        }
    }



    private function uploadFile($field , $userID): ?string
    {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true); // Create directory if it doesn't exist
            }
            if ($field == 'photo') {
                $fileName = $userID . '_photo_' . basename($_FILES[$field]['name']);
            } elseif ($field == 'piece_identite') {
                $fileName = $userID . '_id_' . basename($_FILES[$field]['name']);
            } elseif ($field == 'recu_paiement') {
                $fileName = $userID . '_recu_' . basename($_FILES[$field]['name']);
            }
            else {
            $fileName = basename($_FILES[$field]['name']);
            }
            $filePath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES[$field]['tmp_name'], $filePath)) {
                return $filePath;
            } else {
                // Handle upload error
                error_log("Failed to upload file: " . $field);
                return null;
            }
        }
        return null;
    }

    private function getMembershipTypeId($type)
    {
        // Assuming there's a membership_types table with type_name and type_id
        $query = "SELECT type_id FROM membership_types WHERE type_name = :type";
        $params = [':type' => $type];
        $result = $this->db->query($query, $params);
        return $result[0]['type_id'] ?? null;
    }

    public function isEmailTaken($email): bool
    {
        // Connect to the database
        $this->db->connect();

        // Prepare the query
        $query = "SELECT * FROM users WHERE email = :email";
        $params = [
            ':email' => $email
        ];

        // Execute the query
        $user = $this->db->query($query, $params);

        // Disconnect from the database
        $this->db->disconnect();

        return !empty($user); // Return true if email is taken, otherwise false
    }

    public function isUsernameTaken($username): bool
    {
        // Connect to the database
        $this->db->connect();

        // Prepare the query
        $query = "SELECT * FROM users WHERE username = :username";
        $params = [
            ':username' => $username
        ];

        // Execute the query
        $user = $this->db->query($query, $params);

        // Disconnect from the database
        $this->db->disconnect();

        return !empty($user); // Return true if username is taken, otherwise false
    }
    public function getMemberByUserId($userId)
    {
        $this->db->connect();
        $query = "SELECT * FROM members WHERE user_id = :user_id";
        $params = [':user_id' => $userId];
        $member = $this->db->query($query, $params);
        $this->db->disconnect();
        return $member ? $member[0] : null;
    }
    public function validateUser($memberId)
    {
        $query = "UPDATE members SET is_validated = 1 WHERE member_id = :member_id";
        $params = [':member_id' => $memberId];
        return $this->db->execute($query, $params);
    }

    public function blockUser($memberId)
    {
        $query = "UPDATE members SET is_blocked = 1 WHERE member_id = :member_id";
        $params = [':member_id' => $memberId];
        return $this->db->execute($query, $params);
    }
}