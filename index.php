<?php
    session_start();
    if ($_SESSION['is_logged_in'] ?? false) {
        header('Location: welcome.php');
        exit;
    }
?>
<!-- login page -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login Page</title>
    </head>
    <body>
        <h1>Login Page</h1>
        <?php
            $problem = $_GET['problem'] ?? '';
            if ($problem === 'incorrect_email') {
                echo "<script>alert('incorrect email')</script>";
            }
            if ($problem === 'incorrect_password') {
                echo "<script>alert('incorrect password')</script>";
            }
        ?>
        <form action="check_login.php" method="post">
            <p>
                <label for="email">Email</label>
                <input type="text" name="email" id="email">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
                <input type="submit" name="loginButton" value="login">
            </p>
        </form>
    </body>
</html>
