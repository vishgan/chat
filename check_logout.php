<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("HTTP/1.0 404 Not Found");
    exit;
}

session_start();

if ($_SESSION['is_logged_in'] ?? false) {
    session_destroy();
}

header('Location: index.php');
