<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Application</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <div class="row">
            <nav class="menu">
                <ul class="items">
                    <li class="item"><i class="fa fa-home" aria-hidden="true"></i></li>
                    <li class="item"><i class="fa fa-user" aria-hidden="true"></i></li>
                    <li class="item"><i class="fa fa-pencil" aria-hidden="true"></i></li>
                    <li class="item item-active"><i class="fa fa-commenting" aria-hidden="true"></i></li>
                    <li class="item"><i class="fa fa-file" aria-hidden="true"></i></li>
                    <li class="item"><i class="fa fa-cog" aria-hidden="true"></i></li>
                </ul>
            </nav>

            <section class="discussions">
                <div class="discussion search">
                    <div class="searchbar">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <input type="text" placeholder="Search..."></input>
                    </div>
                </div>
                <div class="discussion" id="discussion-list">
                    <!-- Discussions will be populated here -->
                </div>
            </section>

            <section class="chat">
                <div class="header-chat">
                    <i class="icon fa fa-user-o" aria-hidden="true"></i>
                    <p class="name">Megan Leib</p>
                    <i class="icon clickable fa fa-ellipsis-h right" aria-hidden="true"></i>
                </div>
                <div class="messages-chat" id="messages-chat">
                    <!-- Messages will be populated here -->
                </div>
                <div class="footer-chat">
                    <i class="icon fa fa-smile-o clickable" style="font-size:25pt;" aria-hidden="true"></i>
                    <input type="text" class="write-message" id="message-input" placeholder="Type your message here"></input>
                    <button type="button" class="btn btn-secondary" id="send-button" style="border: 2px solid black;">Enter</button>
                    <i class="icon send fa fa-paper-plane-o clickable" id="send-icon" aria-hidden="true"></i>
                </div>
            </section>
        </div>
    </div>

    <script src="https://cdn.socket.io/4.8.1/socket.io.min.js"></script>
    <script>
        const socket = io.connect('http://localhost:3000/');
        const messageInput = document.getElementById('message-input'); // Fixed the ID
        const sendButton = document.getElementById('send-button'); 

        const messagesChat = document.getElementById('messages-chat');

        // Send message on button click
        sendButton.addEventListener('click', () => {
            const message = messageInput.value;
            if (message) {
                socket.emit("code", message); // Emit the message to the server
                messageInput.value = ''; // Clear the input field
            }
        });
// Listen for incoming messages
socket.on("message", (message) => {
    const messageElement = document.createElement('div'); // Corrected: use 'div' as a string
    messageElement.classList.add('message'); // Corrected: add class in a separate line
    messageElement.innerHTML = `<p class="text">${message}</p>`;
    messagesChat.appendChild(messageElement); // Append the new message to the chat
});
        // Optional: Send message on pressing Enter key
        messageInput.addEventListener('keypress', (event) => {
            if (event.key === 'Enter') {
                sendButton.click(); // Trigger the send button click
            }
        });
    </script>