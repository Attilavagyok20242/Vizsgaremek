<?php
session_start();

if (isset($_POST['username'])) {
    $_SESSION['nev'] = $_POST['username'];
}

$username = isset($_SESSION['nev']) ? $_SESSION['nev'] : 'Vendég';
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatszoba</title>
    <link rel="stylesheet" href="../css/ChatszobaStyle.css">
    <script  src="../Javascripts/Chatszobajs.js"></script>
</head>
<body>

    <!-- Bejelentkezési rész, ha még nincs session -->
    <?php if (!isset($_SESSION['nev'])): ?>
        <div id="login-section" class="login-container">
            <h2>Írd be a neved a belépéshez:</h2>
            <form action="index.php" method="POST">
                <input type="text" id="username" name="username" placeholder="Neved" required>
                <button type="submit">Belépés</button>
            </form>
        </div>
    <?php endif; ?>
<section class="egybe">    <!-- Szobaválasztás -->
    <div id="room-selection" class="room-container" style="display: <?php echo isset($_SESSION['nev']) ? 'block' : 'none'; ?>;">
        <h2>Válassz egy chatszobát!</h2>
        <button onclick="joinChat('Általános')">Általános</button>
      
    </div>

    <!-- Chatszoba -->
    <div id="chat-section" class="chat-container" style="display: none;">
        <h2>Üdvözlünk, <?php echo htmlspecialchars($username); ?> a chatszobában!</h2>
        <button id="dark-mode-toggle">🌙 Sötét mód</button>
        <div id="chatbox"></div>
        <div id="typing-indicator"></div>
        <div class="input-container">
            <input type="text" id="message" placeholder="Írj egy üzenetet..." onkeypress="if(event.keyCode==13) sendMessage();">
            <button onclick="sendMessage()">Küldés</button>
        </div>
    </div>

    <!-- Jobb klikkes menü -->
    <div id="context-menu" class="context-menu">
        <ul>
            <li id="private-message"><i class="fas fa-envelope"></i>Privát üzenet küldése ✉️</li>
            <li id="report-message"><i class="fas fa-exclamation-triangle"></i> Üzenet jelentése 🚨</li>
        </ul>
    </div>
    </section>

    <!-- JS kezelők -->
    <script>
        function joinChat(room) {
            sessionStorage.setItem("chatroom", room); // Szoba mentése sessionStorage-ba
            document.getElementById("room-selection").style.display = "none";
            document.getElementById("chat-section").style.display = "block";
        }
    </script>

</body>
</html>
