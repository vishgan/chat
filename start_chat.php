<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("HTTP/1.0 404 Not Found");
    exit;
}

session_start();

if (!($_SESSION['is_logged_in'] ?? false)) {
    header('Location: index.php');
    exit;
}

$target_user_id = (int) ($_POST['target-user-id'] ?? 0);

if ($target_user_id === $_SESSION['user']['id']) {
    header('Location: welcome.php?problem=incorrect_user_id');
    exit;
}

include 'users.php';

$target_user = array_filter($users, function($user) use ($target_user_id) {
    return $user['id'] === $target_user_id;
});

$target_user = reset($target_user);

if (!$target_user) {
    header('Location: welcome.php?problem=incorrect_user_id');
    exit;
}

$_SESSION['chat_heads'] = $_SESSION['chat_heads'] ?? [];
$_SESSION['chat_heads'][] = $target_user;

header('Location: chat.php?target-user-id=' . $target_user_id);
