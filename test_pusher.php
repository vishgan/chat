<!DOCTYPE html>
<html>
    <head>Pusher Test</head>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <script>
        Pusher.logToConsole = true

        pusher = new Pusher('0817360eae432fb285a8', {
            cluster: 'ap2'
        })

        channel = pusher.subscribe('test-channel')
        channel.bind('test-event', function(data) {
            alert(JSON.stringify(data))
        })

    </script>
</html>
