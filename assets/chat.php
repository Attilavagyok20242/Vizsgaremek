<?php 
// SESSION KEZELÉS
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// NÉV ELLENŐRZÉS
if (!isset($_SESSION['nev']) && !isset($_COOKIE["nev"])) {
    die("Hiba: Nincs beállítva a felhasználónév.");
}

// CHATSZOBA KIVÁLASZTÁS
$room = $_COOKIE["chatroom"] ?? "general";
$chatFile = "chat_{$room}.txt";

// CHAT FÁJL LÉTREHOZÁSA, HA NEM LÉTEZIK
if (!file_exists($chatFile)) {
    file_put_contents("uzenetek/".$chatFile, ""); 
}

// FELHASZNÁLÓ NEVÉNEK MENTÉSE
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nev"])) {
    $_SESSION['nev'] = htmlspecialchars($_POST["nev"]);
    setcookie("nev", $_SESSION['nev'], time() + 3600, "/");
    echo json_encode(["nev" => $_SESSION['nev']]);
    exit();
}

// ÜZENET KÜLDÉSE
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["message"]) && isset($_COOKIE["nev"])) {
    $message = htmlspecialchars($_POST["message"]);
    $data = [
        "nev" => $_COOKIE["nev"],
        "message" => $message,
        "time" => date("H:i:s")
    ];
    file_put_contents($chatFile, json_encode($data) . "\n", FILE_APPEND);
    exit();
}

// GÉPELÉSI ÁLLAPOT MENTÉSE
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['typing'])) {
    $nev = $_COOKIE["nev"] ?? "ismeretlen";
    $typingData = file_exists("typing_status.json") ? json_decode(file_get_contents("uzenetek/typing_status.json"), true) : [];
    $typingData[$nev] = $_POST['typing'] == 1 ? time() : 0;
    file_put_contents("uzenetek/typing_status.json", json_encode($typingData));
    exit();
}

// GÉPELÉSI ÁLLAPOT LEKÉRÉSE
if (isset($_GET['get_typing'])) {
    $typingData = file_exists("typing_status.json") ? json_decode(file_get_contents("uzenetek/typing_status.json"), true) : [];
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
    file_put_contents("uzenetek/private_messages.txt", "Privát üzenet: $recipient - $privateMessage\n", FILE_APPEND);
    exit();
}

// ÜZENET JELENTÉSE
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['report_message'])) {
    $reportedMessage = htmlspecialchars($_POST['report_message']);
    file_put_contents("uzenetek/reported_messages.txt", "Jelentett üzenet: $reportedMessage\n", FILE_APPEND);
    exit();
}

// ÜZENETEK LEKÉRÉSE
if (isset($_GET["get_messages"])) {
    $messages = file_exists($chatFile) ? file($chatFile) : [];
    foreach ($messages as $msg) {
        $data = json_decode($msg, true);
        echo "<div class='message " . ($data['nev'] == $_COOKIE['nev'] ? "my-message" : "other-message") . "'>";
        echo "<strong>" . $data['nev'] . "</strong> [" . $data['time'] . "]: " . $data['message'];
        echo "</div>";
    }
    exit();
}

// FELHASZNÁLÓK AKTIVITÁSÁNAK KEZELÉSE
if (isset($_GET['get_users'])) {
    $users = file_exists("users.json") ? json_decode(file_get_contents("uzenetek/users.json"), true) : [];
    $users[$_COOKIE['nev']] = time();
    file_put_contents("uzenetek/users.json", json_encode($users));

    foreach ($users as $user => $last_active) {
        if (time() - $last_active < 60) { // Aktív státusz
            echo "<p>✅ $user</p>";
        }
    }
    exit();
}

// ADMIN: ÜZENETEK TÖRLÉSE
if (isset($_POST['delete']) && $_COOKIE['nev'] === 'admin') {
    file_put_contents("uzenetek/".$chatFile, "");
    exit();
}
?>
