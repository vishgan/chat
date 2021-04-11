<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Welcome Page</title>
        <?php
            $problem = $_GET['problem'] ?? '';
            if ($problem === 'incorrect_user_id') {
                echo "<script>alert('incorrect user id')</script>";
            }
        ?>
    </head>
    <body>
        <h1>Welcome <?php echo $_SESSION['user']['name']; ?></h1>
        <h3>Email Id: <?php echo $_SESSION['user']['email']; ?></h3>
        <h3>User Id: <?php echo $_SESSION['user']['id']; ?></h3>


        <form action="start_chat.php" method="post">
            <label for="start-chat">Chat with user id</label>
            <input type="text" name="target-user-id" id="start-chat">
            <input type="submit" value="Start Chat">
        </form>

        <form action="check_logout.php" method="post">
            <p>
                <input type="submit" name="logoutButton" value="logout">
            </p>
        </form>
    </body>
</html>
