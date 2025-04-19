<?php
// SESSION KEZELÉS
session_start();

// Database connection
$servername = "localhost";  // Update this if needed
$username = "root";         // Update with your MySQL username
$password = "";             // Update with your MySQL password
$dbname = "game";        // Update with your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// FELHASZNÁLÓNÉV ELLENŐRZÉS
if (!isset($_SESSION['nev'])) {
    echo "Hiba: Nem vagy bejelentkezve!";
    exit;
}

$username = $_SESSION['nev']; // Use $_SESSION['nev'] consistently
$user_id = $_SESSION['id']; // Assuming the user ID is stored in session
$room = $_SESSION["chatroom"] ?? "general";  // Default to 'general' room if not set

// ÜZENET KÜLDÉSE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = htmlspecialchars($_POST['message']);
    if (!empty($message)) {
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO chat_messages (felhasznalo_id, uzenet, room) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $message, $room); // 'i' for integer (user_id), 's' for string (message and room)

        if ($stmt->execute()) {
            echo "Message sent!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Hiba: Az üzenet nem lehet üres!";
    }
    exit;
}
if (isset($_GET['get_messages'])) {
    $stmt = $conn->prepare("SELECT *, u.nev  FROM chat_messages m JOIN felhasznalo u ON m.felhasznalo_id = u.id WHERE m.room = ? ORDER BY m.time ASC");
    $stmt->bind_param("s", $room); 
    $stmt->execute();
    $result = $stmt->get_result();

    while ($data = $result->fetch_assoc()) {
        echo "<p class='message' data-user='" . $data['username'] . "'><strong>" . $data['username'] . "</strong> [" . $data['time'] . "]: " . $data['uzenet'] . "</p>";
    }

    $stmt->close();
}
if (isset($_GET['get_users'])) {
    $users = isset($_SESSION['users']) ? $_SESSION['users'] : [];
    $users[$username] = time();
    $_SESSION['users'] = $users;

    foreach ($users as $user => $last_active) {
        if (time() - $last_active < 60) {
            echo "<p>✅ $user</p>";
        }
    }
    exit;
}
if (isset($_POST['delete']) && $username === 'admin') {
    $stmt = $conn->prepare("DELETE FROM chat_messages WHERE room = ?");
    $stmt->bind_param("s", $room);  
    if ($stmt->execute()) {
        echo "Messages have been deleted.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    exit;
}

if (isset($_POST['private_message']) && isset($_POST['recipient'])) {
    $message = htmlspecialchars($_POST['private_message']);
    $recipient = htmlspecialchars($_POST['recipient']);

    if (!empty($message)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE nev = ?");
        $stmt->bind_param("s", $recipient);
        $stmt->execute();
        $result = $stmt->get_result();
        $recipient_data = $result->fetch_assoc();

        if ($recipient_data) {
            $recipient_id = $recipient_data['id'];

            $stmt = $conn->prepare("INSERT INTO chat_messages (felhasznalo_id, uzenet, room) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user_id, "(privát) " . $message, $room);

            if ($stmt->execute()) {
                echo "Private message sent!";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error: Recipient not found.";
        }
    } else {
        echo "Hiba: A privát üzenet nem lehet üres!";
    }
    exit;
}

$conn->close(); // Close the database connection
?>
