<?php
class Users{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS users(
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )";

        if($this->db->query($sql) === TRUE) {
            error_log("Table created successfully", 0);
        } else {    
            echo "Table creation failed: " . $this->db->error;
        }
    }
    
    public function register($username, $email, $password) {
        $sql = "INSERT INTO users (username, email, password) VALUES (?,?,?)";

        $hashed_password  = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);           // this method prevent sqli attacks

        if($stmt->execute()) {
            return true;
        } else {
            error_log("errors: ". $stmt->error . "", 0);
            return false;
        }
        
    }
}
?>