<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Application</title>
    <script src="<?php echo base_url('/public/assets/js/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url("/public/assets/js/socket.io.js") ?>"></script>
   <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
        }
        .chat-app {
            display: flex;
            height: 80vh;
            width: 60%;
            margin: 60px auto;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: #ffffff;
        }
        .people-list {
            width: 300px;
            background-color: #f8f9fa;
            border-right: 1px solid #ddd;
            padding: 20px;
            overflow-y: auto;
        }
        .people-list .loggedUser {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }
        .people-list .chat-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .people-list .chat-list li {
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }
        .people-list .chat-list li:hover {
            background-color: #e9ecef;
            transform: scale(1.05);
        }
        .chat {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .chat-header {
            padding: 20px;
            border-bottom: 1px solid #ddd;
            background-color: #343a40;
            color: white;
        }
        .chat-header h6 {
            margin: 0;
            font-size: 20px;
        }
        .chat-history {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #e9ecef;
            border-bottom: 1px solid #ddd;
        }
        .message {
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            max-width: 60%;
            clear: both;
            position: relative;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .sender-message {
            background-color:rgba(5, 23, 48, 0.44);
            color: white;
            float: right;
            margin-left: 30%;
        }
        .receiver-message {
            background-color: #f1f0f0;
            color: #333;
            float: left;
            margin-right: 30%;
        }
        .chat-input {
            padding: 20px;
            border-top: 1px solid #ddd;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
        }
        .chat-input input {
            flex: 1;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            margin-right: 15px;
            transition: border-color 0.3s;
        }
        .chat-input input:focus {
            border-color:rgb(11, 44, 80);
            outline: none;
        }
        .chat-input button {
            padding: 12px 20px;
            background-color:rgba(28, 15, 43, 0.83);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .chat-input button:hover {
            background-color:rgb(2, 8, 14);
        }
   </style>

</head>
<body>
    <div class="chat-app">
        <div id="plist" class="people-list">
            <div class="loggedUser ">Chat Application</div>
            <ul class="chat-list">
                <?php foreach ($users as $user) { ?>
                    <?php if ($user['name'] !== session('name')) { ?>
                        <li class="users" data-username="<?= $user['name'] ?>">
                            <div class="name"><?= $user['name'] ?></div>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>

        <div class="chat">
            <div class="chat-header">
                <h6 class="receiver">Select a user to chat</h6>
            </div>
            <div class="chat-history" id="messages">
                <!-- Messages shown here -->
            </div>
            <!-- //timer -->
            <div id="time"></div>
            <div class="chat-input">
                <input type="text" id="chat-input" placeholder="Enter message...">
                <button id="send-button" type="button">Send</button>
            </div>
        </div>
    </div>
    <script>
    const socket = io('http://localhost:3000');
    let username = '<?php echo session()->get('user')['name']; ?>'; // Ensure this is set correctly
    let currentReceiver = null;
    console.log(username)
    socket.emit('username', username);

    document.querySelectorAll('.users').forEach(user => {
        user.addEventListener('click', () => {
            currentReceiver = user.dataset.username;
            document.querySelector('.receiver').textContent = currentReceiver;

            document.getElementById('messages').innerHTML = '';
            socket.emit('joinRoom', {
                sender: username,
                receiver: currentReceiver
            });
        });
    });

    function sendMessage() {
        const input = document.getElementById('chat-input');
        const message = input.value.trim();

        if (message && currentReceiver) {
            socket.emit('send-message', {
                sender: username,
                receiver: currentReceiver,
                message: message,
                timestamp: new Date()
            });
            input.value = '';
        }
    }

    document.getElementById('send-button').addEventListener('click', sendMessage);

    document.getElementById('chat-input').addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    socket.on('previousMessages', (messages) => {
    const chatHistory = document.getElementById('messages');
    chatHistory.innerHTML = '';

    messages.forEach(msg => {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${msg.sender === username ? 'sender-message' : 'receiver-message'}`;
        const timestamp = new Date(msg.timestamp).toLocaleString();
        messageDiv.innerHTML = `<div>${msg.message}</div><div style="font-size: 0.8em; ">${timestamp}</div>`;
        chatHistory.appendChild(messageDiv);
    });
   
    chatHistory.scrollTop = chatHistory.scrollHeight;
});

    socket.on('new-message', (message) => {
        const chatHistory = document.getElementById('messages');
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${message.sender === username ? 'sender-message' : 'receiver-message'}`;
        messageDiv.innerHTML = `${message.message} <span class="timestamp">${new Date(message.timestamp).toLocaleTimeString()}</span>`;
        chatHistory.appendChild(messageDiv);
        chatHistory.scrollTop = chatHistory.scrollHeight;
    });
 </script>

</body>
</html>