<?php

namespace Models;
use Database;

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
        // Hash the password
        //$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        // Connect to the database
        $this->db->connect();

        // Prepare the query
        $query = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $params = [
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
            ':role' => $role
        ];

        // Execute the query
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
            ':photo' => $this->uploadFile('photo'),
            ':id_document' => $this->uploadFile('piece_identite'),
            ':recu_paiement' => $this->uploadFile('recu_paiement')
        ];

        // Execute the query
        $result = $this->db->execute($query, $params);

        // Disconnect from the database
        $this->db->disconnect();

        return $result;
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



    private function uploadFile($field): ?string
    {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true); // Create directory if it doesn't exist
            }
            $fileName = basename($_FILES[$field]['name']);
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
}