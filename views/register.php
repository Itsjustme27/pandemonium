<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Pandemonium</title>
</head>
<body>
    <?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    include_once '../models/Database.php';
    include_once '../models/Users.php';

    $db = new Database();
    $conn = $db->getConnection();

    $users = new Users($conn);


    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $result = $users->register($username, $email, $password);

        if($result){ 
            echo "<script>alert('Registered Successfully')</script>";
            header('Location: login.php');
        } else {
            error_log($conn->error);
        }

    }
    ?>
    <div class="container">
        <h1>Sign Up</h1>
        <form action="register.php" method="post">
            <label for="username">Username</label><br>
            <input type="text" name="username" id="username" required><br>
            <label for="email">Email</label><br>
            <input type="email" name="email" id="email" required><br>
            <label for="password">Password</label> <br>
            <input type="password" name="password" id="password" required><br>
            <button type="submit">Sign Up</button>
        </form> 
    </div>
</body>
</html>