<?php
include_once './Users.php';
include_once './Task.php';
include_once 'Database.php';

$db = new Database();
$conn = $db->getConnection();

$users = new Users($conn);
$users->createTable();

$task = new Task($conn);
$task->createTaskTable();

$db->closeConnection();
?>