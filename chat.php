<?php

session_start();

if (!($_SESSION['is_logged_in'] ?? false)) {
    header('Location: index.php');
    exit;
}

$target_user_id = (int) ($_GET['target-user-id'] ?? 0);

$target_user = array_filter($_SESSION['chat_heads'] ?? [], function($user) use ($target_user_id) {
    return $user['id'] === $target_user_id;
});

$target_user = reset($target_user);

if (!$target_user) {
    header('Location: welcome.php?problem=incorrect_user_id');
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Chat Page</title>
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        <script>

            Pusher.logToConsole = true

            var pusher = new Pusher('0817360eae432fb285a8', {
                cluster: 'ap2'
            })

            var channel = pusher.subscribe('incoming-messages-<?php echo $_SESSION['user']['id']; ?>')
            channel.bind('message', function(data) {
                // alert(JSON.stringify(data));

                messages_container = document.getElementById('messages')
                messages_container.innerHTML += '<p>user id ' + data.user_id + ' at ' + data.time + ' - ' + data.message + '</p>'
            })

            function sendBEApiCall(target_user_id, message)
            {
                var data = JSON.stringify({
                    target_user_id: target_user_id,
                    message: message
                });

                var xhr = new XMLHttpRequest();
                xhr.withCredentials = true;

                xhr.addEventListener('readystatechange', function() {
                if(this.readyState === 4) {
                    console.log(this.responseText);
                }
                });

                xhr.open('POST', '/send_message.php');
                xhr.setRequestHeader('Content-Type', 'application/json');

                xhr.send(data);
            }

            function sendMessage() {
                message = document.forms['send-message'].message.value
                if (!message) {
                    return false
                }

                date = new Date()
                time = date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds()

                messages_container = document.getElementById('messages')
                messages_container.innerHTML += '<p><?php echo 'user id ' . $_SESSION['user']['id']; ?> at ' + time + ' - ' + message + '</p>'

                document.getElementById('send-message').value = '';

                sendBEApiCall(<?php echo $target_user_id; ?>, message)

                return false
            }
        </script>

    </head>
    <body>
        <h1>Chatting with user id <?php echo $target_user_id; ?></h1>

        <form name="send-message" onsubmit="event.preventDefault(); sendMessage();">
            <label for="send-message">Message</label>
            <input type="text" name="message" id="send-message">
            <input type="submit" value="Send">
        </form>

        <h3>Messages</h3>
        <div id="messages"></div>

        <form action="check_logout.php" method="post">
            <p>
                <input type="submit" name="logoutButton" value="logout">
            </p>
        </form>
    </body>
</html>
