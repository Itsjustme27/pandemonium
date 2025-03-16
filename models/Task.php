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
            error_log("Table creation failed" . $this->db->error, 0);
        }
    }

    public function insertTask($task) {
        $sql = 'INSERT INTO task (item) VALUES (?)';

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $task);
        if($stmt->execute()) {
            return true;
        } else {
            error_log("error: " . $this->db->error, 0);
            return false;
        }
    }

    public function updateTask($task) {
        $sql = 'UPDATE task SET item = ? WHERE id = ?';

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('si', $task, $_GET["id"]);
        if($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function deleteTask() {
        $sql = "DELETE FROM task WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $_GET["id"]);

        if($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }
}
?>