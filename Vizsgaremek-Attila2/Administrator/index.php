<?php
session_start();
include "connection/connection.php";

// Initialize session variables
$views = $_SESSION['views'] ?? 0;
setcookie('views', $views, time() + (86400 * 30), "/"); // 30-day expiry

// Initialize user session
$id = $_SESSION['id'] ?? 0;
$nev = $_SESSION['nev'] ?? "";
$jelszo = $_SESSION['jelszo'] ?? "";

// Count Active Admins
$adminnumber = 0;
$query = "SELECT COUNT(*) as total FROM felhasznalo WHERE aktív = 1 AND Szerep = 1";
$result = mysqli_query($con, $query);
if ($row = mysqli_fetch_assoc($result)) {
    $adminnumber = $row['total'];
}

// Count Active Users
$felhasznalo = 0;
$query = "SELECT COUNT(*) as total FROM felhasznalo WHERE aktív = 1 AND Szerep = 0";
$result = mysqli_query($con, $query);
if ($row = mysqli_fetch_assoc($result)) {
    $felhasznalo = $row['total'];
}

// Count Comments
$comments = 0;
$query = "SELECT COUNT(*) as total FROM messages";
$result = mysqli_query($con, $query);
if ($row = mysqli_fetch_assoc($result)) {
    $comments = $row['total'];
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="css/administrator.css">
<link rel="stylesheet" href="css/script2.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
  <div class="container">
  <div class="navigation">
    <ul>
      <li>
        <a href="#">
          <span class="icon">
            <i class='bx bx-home'></i>
          </span>
          <span class="title">Gladiator Arena</span>
        </a>
      </li>
      <li>
        <a href="#" class="menupont" id="uzemfal">
          <span class="icon">
            <i class='bx bx-cog'></i>
          </span>
          <span class="title">Üzemfal</span>
        </a>
      </li>
      <li>
        <a href="#" class="menupont" id="uzenetek">
          <span class="icon">
            <i class='bx bx-book'></i>
          </span>
          <span class="title">Üzenetek</span>
        </a>
      </li>
      <li>
        <a href="#" class="menupont" id="segitseg">
          <span class="icon">
          
            <i class='bx bx-user-pin'></i>
          </span>
          <span class="title" onclick="Komm()">Segítség</span>
        </a>
      </li>
      <li>
        <a href="#" class="menupont" id="beállítások">
          <span class="icon">
            <i class='bx bx-user'></i>
          
          </span>
          <span class="title">Beállítások</span>
        </a>
      </li>
      <li>
        <a href="logout.php">
          <span class="icon">
            <i class='bx bx-power-off'></i>
          </span>
          <span class="title">
            Kilépés
        </a>
      </li>
    </ul>
  </div>

  <div class="main">
    <div class="topbar">
      <div class="toggle">
        <i class='bx bx-menu'></i>
      </div>
      <!--kereső-->
      <div class="search">
        <label >
          <input type="text" placeholder="Itt tudsz keresni!">
          <i class='bx bx-search'></i>
        </label>
      </div>
      <!--felhaználó kép-->
      <div class="user">
        <img src="kepek/g.png" alt="">
      </div>
    </div>
    <!--kártyák-->
      <div class="cardBox">
      <div class="card">
        <div>
          <div class="numbers"><?php echo $views; ?></div>
          <div class="cardName">Napi megtekintés</div>
        </div>
          <div class="iconBx">
          <i class='bx bxs-user'></i>
          </div>
      </div>
      <div class="card">
        <div>
          <div class="numbers"><?php echo  $comments;?></div>
          <div class="cardName">Kommentek</div>
        </div>
          <div class="iconBx">
          <i class='bx bxs-message-rounded'></i>
          </div>
      </div>
      <div class="card">
        <div>
          <div class="numbers"><?php echo $felhasznalo;?></div>
          <div class="cardName">Aktív Felhasznalók</div>
        </div>
          <div class="iconBx">
          <i class='bx bxs-user'></i>
          </div>
      </div>
      <div class="card">
        <div>
          <div class="numbers"><?php echo $adminnumber;?></div>
          <div class="cardName">Aktív Adminok</div>
        </div>
          <div class="iconBx">
          <i class='bx bxs-user'></i>
          </div>
      </div>
    
</div>
<div id="uzenettart">
    <table id="cucc">
        <thead>
            <tr>
                <th>Cím</th>
                <th>Leírás</th>
                <th>Mikor</th>
                <th id="helpContent">Elfogadás</th>
            </tr>

        </thead>
    </table>
    <div id="resultTable"></div>
    <div id="helpContents"></div>
    <div id="ide">asd</div>
</div>

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
<div id="poop-up">
  </div>
  <script src="javascript/segitseg.js"></script>
  <script src="javascript/adminja.js"></script>
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
  <script>
    let toggle=document.querySelector('.toggle');
    let navigation=document.querySelector('.navigation');
    let main=document.querySelector('.main');
    toggle.onclick=function(){
      navigation.classList.toggle('active');
      main.classList.toggle('active');
    }

  let list=document.querySelectorAll('.navigation li');
  function activeLink(){
    list.forEach((items)=>
      items.classList.remove('hovered'));
      this.classList.add('hovered');
  }
    list.forEach((item)=>
    item.addEventListener('mouseover',activeLink));
  </script>
</body>
</html> 