<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In | Pandemonium</title>
</head>
<body>
    <?php
    session_start();
    include_once '../models/Database.php';

    $db = new Database();
    $conn = $db->getConnection();
    
    if($_SERVER['REQUEST_METHOD'] === "POST") {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = $conn->prepare($sql);
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
                echo "<script>alert('invalid password');</script>";
            }
        } else {
            echo "<script>alert('email is not registered')</script>";
        }
    }
    ?>
    <h1>Login</h1>
    <form action="login.php" method="post">
        <label for="email">Enter email:</label><br>
        <input type="email" name="email" id="email"><br>

        <label for="password">Password</label><br>
        <input type="password" name="password" id="password"><br>

        <input type="submit" value="Log in">
    </form>
</body>
</html>