<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("HTTP/1.0 404 Not Found");
    exit;
}

include 'users.php';

$entered_email = $_POST['email'] ?? '';
$entered_password = $_POST['password'] ?? '';

if (isset($users[$entered_email])
    && ($users[$entered_email]['password'] === $entered_password)
) {
    session_start();
    $_SESSION['is_logged_in'] = true;
    $_SESSION['user'] = $users[$entered_email];
    header('Location: welcome.php');
    exit;
}

$problem = '';
if (!isset($users[$entered_email])) {
    $problem = 'incorrect_email';
} else {
    $problem = 'incorrect_password';
}

header('Location: index.php?problem=' . $problem);
