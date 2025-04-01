<?php 
// SESSION KEZELÉS
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// NÉV ELLENŐRZÉS
if (!isset($_SESSION['username']) && !isset($_SESSION["username"])) {
    die("Hiba: Nincs beállítva a felhasználónév.");
}

// CHATSZOBA KIVÁLASZTÁS
$room = $_SESSION["chatroom"] ?? "general";
$chatFile = "chat_{$room}.txt";

// CHAT FÁJL LÉTREHOZÁSA, HA NEM LÉTEZIK
if (!file_exists($chatFile)) {
    file_put_contents($chatFile, ""); 
}

// FELHASZNÁLÓ NEVÉNEK MENTÉSE
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["username"])) {
    $_SESSION['username'] = htmlspecialchars($_POST["username"]);
    setcookie("username", $_SESSION['username'], time() + 3600, "/");
    echo json_encode(["username" => $_SESSION['username']]);
    exit();
}

// ÜZENET KÜLDÉSE
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["message"]) && isset($_SESSION["username"])) {
    $message = htmlspecialchars($_POST["message"]);
    $data = [
        "username" => $_SESSION["username"],
        "message" => $message,
        "time" => date("H:i:s")
    ];
    file_put_contents($chatFile, json_encode($data) . "\n", FILE_APPEND);
    exit();
}

// GÉPELÉSI ÁLLAPOT MENTÉSE
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['typing'])) {
    $username = $_SESSION["username"] ?? "ismeretlen";
    $typingData = file_exists("typing_status.json") ? json_decode(file_get_contents("typing_status.json"), true) : [];
    $typingData[$username] = $_POST['typing'] == 1 ? time() : 0;
    file_put_contents("typing_status.json", json_encode($typingData));
    exit();
}

// GÉPELÉSI ÁLLAPOT LEKÉRÉSE
if (isset($_GET['get_typing'])) {
    $typingData = file_exists("typing_status.json") ? json_decode(file_get_contents("typing_status.json"), true) : [];
    $activeUsers = [];
    foreach ($typingData as $user => $lastTypingTime) {
        if (time() - $lastTypingTime < 3) {
            $activeUsers[] = $user;
        }
    }
    echo json_encode($activeUsers);
    exit();
}

// PRIVÁT ÜZENET KÜLDÉSE
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['private_message']) && isset($_POST['recipient'])) {
    $privateMessage = htmlspecialchars($_POST['private_message']);
    $recipient = htmlspecialchars($_POST['recipient']);
    file_put_contents("private_messages.txt", "Privát üzenet: $recipient - $privateMessage\n", FILE_APPEND);
    exit();
}

// ÜZENET JELENTÉSE
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['report_message'])) {
    $reportedMessage = htmlspecialchars($_POST['report_message']);
    file_put_contents("reported_messages.txt", "Jelentett üzenet: $reportedMessage\n", FILE_APPEND);
    exit();
}

// ÜZENETEK LEKÉRÉSE
if (isset($_GET["get_messages"])) {
    $messages = file_exists($chatFile) ? file($chatFile) : [];
    foreach ($messages as $msg) {
        $data = json_decode($msg, true);
        echo "<div class='message " . ($data['username'] == $_SESSION['username'] ? "my-message" : "other-message") . "'>";
        echo "<strong>" . $data['username'] . "</strong> [" . $data['time'] . "]: " . $data['message'];
        echo "</div>";
    }
    exit();
}

// FELHASZNÁLÓK AKTIVITÁSÁNAK KEZELÉSE
if (isset($_GET['get_users'])) {
    $users = file_exists("users.json") ? json_decode(file_get_contents("users.json"), true) : [];
    $users[$_COOKIE['username']] = time();
    file_put_contents("users.json", json_encode($users));

    foreach ($users as $user => $last_active) {
        if (time() - $last_active < 60) { // Aktív státusz
            echo "<p>✅ $user</p>";
        }
    }
    exit();
}

// ADMIN: ÜZENETEK TÖRLÉSE
if (isset($_POST['delete']) && $_COOKIE['username'] === 'admin') {
    file_put_contents($chatFile, "");
    exit();
}
?>
