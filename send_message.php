<?php

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'error' => 'only POST allowed'
    ]);
    exit;
}

session_start();

if (!($_SESSION['is_logged_in'] ?? false)) {
    echo json_encode([
        'error' => 'unauthorized - user not logged in'
    ]);
    exit;
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$target_user_id = (int) ($data['target_user_id'] ?? 0);

$target_user = array_filter($_SESSION['chat_heads'] ?? [], function($user) use ($target_user_id) {
    return $user['id'] === $target_user_id;
});

$target_user = reset($target_user);

if (!$target_user) {
    echo json_encode([
        'error' => 'no chat thread with this user'
    ]);
    exit;
}

require __DIR__ . '/vendor/autoload.php';

$options = [
    'cluster' => 'ap2',
    'useTLS' => true
];
$pusher = new Pusher\Pusher(
  '0817360eae432fb285a8',
  'd90369bc341d522efad2',
  '1185050',
  $options
);

$pusher->trigger('incoming-messages-' . $target_user_id, 'message', [
    'user_id' => $_SESSION['user']['id'],
    'message' => $data['message'],
    'time' => (new DateTime('now', new DateTimeZone('Asia/Kolkata')))->format('H:i:s'),
]);
