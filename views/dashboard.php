<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <?php
    require '../nav/header.php';
    include_once '../models/Task.php';
    include_once '../models/Database.php';

    session_start();

    if(!isset($_SESSION["username"])) {
        header("Location: views/login.php");
        exit;
    }

    echo "<h2>Welcome ". $_SESSION['username']. "</h2>";

    $db = new Database();
    $conn = $db->getConnection();

    $task = new Task($conn);

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $taskDescription = htmlspecialchars($_POST['task']);

        $result = $task->insertTask($taskDescription);

        if($result) {
            error_log("task added successfully", 0);
        } else {
            error_log("couldnt add task", 0);
        }
    }
    ?>
    <div class="container">
        <h2>Todo List : Plan your day</h2>
        <form action="dashboard.php" method="post">
            <input type="text" name="task" id="task">
            <button type="submit">Add Task</button>
        </form>
        <div class="table-container">
            <table class="table">
                <thead>
                    <th>Completed?</th>
                    <th>Your Tasks</th>
                </thead>
                <tbody>
                    <?php
                        include_once '../models/Task.php';
                        include_once '../models/Database.php'; 
                        
                        $sql = "SELECT * FROM task";

                        $db = new Database();
                        $conn = $db->getConnection();

                        // preparing the query for fetching
                        $result = $conn->query($sql);
                        

                        // fetching the data from the database : very important
                        while($row = mysqli_fetch_assoc($result)) {
                            $Id = $row['id'];
                            $Task = $row['item'];
                        
                            echo "
                            <tr class='trow'>
                                <td id='tick'><input type='checkbox' id='completed' />
                                <td class='taskDesc'>{$Task}</td>
                                <td><a href='update.php?id={$Id} class='btn btn-success'>EDIT</a></td>
                                <td><a href='delete.php?id={$Id} class='btn btn-success'>DELETE</a></td>
                            </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        let checkBox = document.getElementById('completed');
        let crossTask = document.querySelector('.taskDesc');

        checkBox.addEventListener("click", () => {
            if(checkBox.checked == true) {
                crossTask.style.textDecoration = "line-through";
            } else {
                crossTask.style.textDecoration = "none";
            }
        })
    </script>
</body>
</html>