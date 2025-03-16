<?php
include '../models/Task.php';
include '../models/Database.php';

$db = new Database();
$conn = $db->getConnection();

$task = new Task($conn);

if($task->deleteTask()) {
    header("Location : views/dashboard.php");
    exit;
} else {
    error_log("somthing went wrong lol", 0);
}
?>