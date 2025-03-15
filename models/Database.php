<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once '../models/config.php';

class Database {
    private $host = DB_HOST;
    private $user = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $dbname = DB_NAME;
    private $conn;
    
    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);

        // Checking the connection
        if($this->conn->connect_error) {
            die("Error connecting to the database: " . $this->conn->connect_error . "\n");
        } else {
            error_log("Database connection established successfully.");
        }
    }
    
    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}

// $db = new Database();
// $db->getConnection();
// $db->createUsersTable();
// $db->closeConnection();

?>