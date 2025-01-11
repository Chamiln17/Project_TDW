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
    public function register($username, $email, $password, $role = 'member')
    {
        // Hash the password
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
        $result = $this->db->execute($query, $params);

        // Disconnect from the database
        $this->db->disconnect();

        return $result; // Return the result of the execution

    }
    public function register_hashed($username, $email, $password, $role = 'member')
    {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        // Connect to the database
        $this->db->connect();

        // Prepare the query
        $query = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $params = [
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':role' => $role
        ];

        // Execute the query
        $result = $this->db->execute($query, $params);

        // Disconnect from the database
        $this->db->disconnect();

        return $result; // Return the result of the execution
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
    public function getUserByUsernameOrEmail($username, $email)
    {
        // Connect to the database
        $this->db->connect();

        // Prepare the query
        $query = "SELECT * FROM users WHERE username = :username OR email = :email";
        $params = [
            ':username' => $username,
            ':email' => $email
        ];

        // Execute the query
        $user = $this->db->query($query, $params);

        // Disconnect from the database
        $this->db->disconnect();

        return !empty($user) ? $user[0] : false; // Return the user data if found, otherwise false
    }
    public function getMemberships()
    {
       $this->db->connect();
       return $this->db->query("SELECT type_name FROM membership_types");
    }
}