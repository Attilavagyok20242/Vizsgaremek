<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Chat</title>
    <style>
#chat-container {
    width: 260px;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;  /* A pozicionálás biztosítása */
    height: 350px; /* Fix magasság a chat doboznak */
    overflow: hidden; /* Ne engedje a chat doboz túllépését */
}

/* Üzenetek doboza */
#messages {
    height: 200px;
    overflow-y: auto;
    border: 1px solid #ccc;
    margin-bottom: 15px;
    padding: 10px;
    background-color: #fff;
    border-radius: 8px;
    font-size: 14px;
}

/* Üzenet input mező */
#messageInput {
    width: calc(100% - 80px);
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-right: 10px;
}

/* Küldés gomb */
#sendButton {
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    width: 70px;
}

/* Küldés gomb hover effektus */
#sendButton:hover {
    background-color: #45a049;
}

/* Köszöntő üzenet */
#welcome {
    text-align: center;
    margin-bottom: 10px;
}

/* Admin üzenet */
.admin {
    color: red;
    font-weight: bold;
}


    </style>
</head>
<body>

<?php
// Start PHP session (replace values dynamically in your PHP server environment)
session_start();
$_SESSION['nev'] = $_SESSION['nev'] ?? 'Guest'; // Username fallback
?>

<div id="chat-container">
    <div id="welcome">
        <h3>Szia, <span id="username"><?php echo htmlspecialchars($_SESSION['nev'], ENT_QUOTES, 'UTF-8'); ?></span>!</h3>
    </div>
    <div id="messages"></div>
    <div style="display: flex;">
        <input type="text" id="messageInput" placeholder="Type a message..." />
        <button id="sendButton">Send</button>
    </div>
</div>

<script>
    const session = {
        username: "<?php echo htmlspecialchars($_SESSION['nev'], ENT_QUOTES, 'UTF-8'); ?>",
         room : "Room_" + Math.floor(Math.random() * 10000) 
    };

    const sendButton = document.getElementById('sendButton');
    const messageInput = document.getElementById('messageInput');
    const messagesDiv = document.getElementById('messages');

    // Poll for new messages every 3 seconds
    setInterval(fetchMessages, 3000);

    // Send a new message
    sendButton.onclick = function () {
        const message = messageInput.value.trim();

        if (message) {
            fetch('database.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `room=${encodeURIComponent(session.room)}&text=${encodeURIComponent(message)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    messageInput.value = ''; // Clear the message input field
                    fetchMessages(); // Fetch the updated messages
                } else {
                    console.error(data.message);
                }
            });
        }
    };

    // Fetch messages from the server for the current room
    function fetchMessages() {
        fetch(`database.php?room=${encodeURIComponent(session.room)}`, { method: 'GET' })
            .then(response => response.json())
            .then(messages => {
                messagesDiv.innerHTML = ''; // Clear the chat container
                messages.forEach(msg => {
                    const messageElement = document.createElement('div');
                    const isAdmin = msg.role === 1; // Highlight admin users
                    messageElement.innerHTML = `
                        <span class="${isAdmin ? 'admin' : ''}">${msg.name}</span>: ${msg.text} <small>(${msg.date})</small>
                    `;
                    messagesDiv.appendChild(messageElement);
                });
                messagesDiv.scrollTop = messagesDiv.scrollHeight; // Scroll to the bottom
            });
    }
</script>

</body>
</html>
