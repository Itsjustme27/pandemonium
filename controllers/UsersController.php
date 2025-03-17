<?php
include_once '../models/Users.php';
include_once '../models/Database.php';

class UsersController {
    private $db;
    private $conn;
    private $users;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
        $this->users = new Users($this->conn);
    }

    public function handleLogin($email, $password) {
        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if(password_verify($password, $user['password'])) {
                $_SESSION["username"] = $user['username'];
                header("Location: dashboard.php");
                exit;
            } else {
                return "Invalid Password";
            }
        } else {
            return "Email is not registered";
        }
    }

    public function handleRegister($username, $email, $password) {
        $result = $this->users->register($username, $email, $password);
        return $result;
    }
}
?>