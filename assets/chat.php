<?php
session_start();
require "../connection/connection.php";
// FELHASZNÁLÓNÉV ELLENŐRZÉS
if (!isset($_SESSION['nev'])) {
    echo "Hiba: Nem vagy bejelentkezve!";
    exit;
}

$username = $_SESSION['nev'];
$user_id = $_SESSION['id'];
$room = $_SESSION["chatroom"] ?? "general";

// ÜZENET KÜLDÉSE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = htmlspecialchars($_POST['message']);
    if (!empty($message)) {
        $stmt = $conn->prepare("INSERT INTO chat_messages (felhasznalo_id, uzenet, room) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $message, $room);

        if ($stmt->execute()) {
            echo "Üzenet elküldve!";
        } else {
            echo "Hiba: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Hiba: Az üzenet nem lehet üres!";
    }
    exit;
}

// ÜZENETEK LEKÉRÉSE
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
$szerep = $_SESSION["Szerep"] ?? 0;
if (isset($_POST['delete']) && $szerep === 1) {
    $stmt = $conn->prepare("DELETE FROM chat_messages WHERE room = ?");
    $stmt->bind_param("s", $room);
    if ($stmt->execute()) {
        echo "Üzenetek törölve.";
    } else {
        echo "Hiba: " . $stmt->error;
    }
    $stmt->close();
    exit;
}
if (isset($_POST['private_message']) && isset($_POST['recipient'])) {
    $message = htmlspecialchars($_POST['private_message']);
    $recipient = htmlspecialchars($_POST['recipient']);

    if (!empty($message)) {
        $stmt = $conn->prepare("SELECT id FROM felhasznalo WHERE nev = ?");
        $stmt->bind_param("s", $recipient);
        $stmt->execute();
        $result = $stmt->get_result();
        $recipient_data = $result->fetch_assoc();

        if ($recipient_data) {
            $recipient_id = $recipient_data['id'];
            $full_message = "(privát üzenet) {$username} → {$recipient}: {$message}";

            $stmt = $conn->prepare("INSERT INTO chat_messages (felhasznalo_id, uzenet, room) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user_id, $full_message, $room);

            if ($stmt->execute()) {
                echo "Privát üzenet elküldve!";
            } else {
                echo "Hiba: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Hiba: Címzett nem található.";
        }
    } else {
        echo "Hiba: A privát üzenet nem lehet üres!";
    }
    exit;
}

$conn->close();
?>
