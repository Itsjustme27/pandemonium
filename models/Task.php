<?php
include './Database.php';

class Task {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    
    public function createTaskTable() {
        $sql = "CREATE TABLE task(
                id INT AUTO_INCREMENT PRIMARY KEY,
                item VARCHAR(255) NOT NULL,
                date DATETIME DEFAULT CURRENT_TIMESTAMP
                )";
        
        if($this->db->query($sql) === TRUE) {
            error_log("Table created successfully", 0);
        } else {
            error_log("Table creation failed" . $this->db->error,0);
        }
    }
}
?>