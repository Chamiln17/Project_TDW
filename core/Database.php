<?php

class Database

{
    // Database parameters
    private $connection = null;
private $host = '127.0.0.1'; // or 'localhost'
private $dbname = 'project'; // Replace with your database name
private $username = 'root'; // Default XAMPP username
private $password = ''; // Default XAMPP password is empty
    public function connect()
    {
        try {
            // Create a PDO instance (PHP Data Object)
            $this->connection = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);

            // Set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        return $this->connection;

    }
    public function disconnect()
    {
        $this->connection = null;
    }
    public function query($query)
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}



