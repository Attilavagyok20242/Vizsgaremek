<?php
// SESSION KEZELÉS
session_start();

// FELHASZNÁLÓNÉV ELLENŐRZÉS 
if (!isset($_SESSION['username'])) {
    if (isset($_POST['username'])) {
        $_SESSION['username'] = htmlspecialchars($_POST['username']); 
        $_SESSION['last_active'] = time();
    } else {
        die("<script>window.location.href='index.html';</script>");
    }
}

// SZOBAVÁLASZTÁS
$room = $_SESSION["chatroom"] ?? "general"; 
$chatFile = "chat_{$room}.txt";

// ÜZENET KÜLDÉSE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = htmlspecialchars($_POST['message']);
    if (!empty($message)) {
        $data = [
            "username" => $_SESSION['username'],
            "message" => $message,
            "time" => date("H:i:s") 
        ];
        file_put_contents($chatFile, json_encode($data) . "\n", FILE_APPEND);
    }
    exit;
}

// ÜZENETEK LEKÉRÉSE
if (isset($_GET['get_messages'])) {
    if (!file_exists($chatFile)) file_put_contents($chatFile, ""); 
    $messages = file($chatFile); 
    foreach ($messages as $msg) {
        $data = json_decode($msg, true);
        echo "<p><strong>" . $data['username'] . "</strong> [" . $data['time'] . "]: " . $data['message'] . "</p>";
    }
    exit;
}

// FELHASZNÁLÓK LEKÉRÉSE 
if (isset($_GET['get_users'])) {
    $users = isset($_SESSION['users']) ? $_SESSION['users'] : []; 
    $users[$_SESSION['username']] = time(); 
    $_SESSION['users'] = $users;

    foreach ($users as $user => $last_active) {
        if (time() - $last_active < 60) { 
            echo "<p>✅ $user</p>";
        }
    }
    exit;
}

// ÜZENETEK TÖRLÉSE
if (isset($_POST['delete']) && $_SESSION['username'] === 'admin') {
    file_put_contents("chat.txt", ""); 
    exit;
}
?>
