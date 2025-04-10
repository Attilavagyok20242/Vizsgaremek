<?php
session_start();

if (!isset($_SESSION['username'])) {
    if (isset($_COOKIE['username'])) {
        $_SESSION['username'] = $_COOKIE['username'];
    } elseif (isset($_POST['username'])) {
        $_SESSION['username'] = htmlspecialchars($_POST['username']);
        $_SESSION['last_active'] = time();
    } else {
        die("<script>window.location.href='szoba';</script>");
    }
}

$room = $_COOKIE["chatroom"] ?? "general"; 
$chatFile = "chat_{$room}.txt"; 

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

if (isset($_GET['get_messages'])) {
    if (!file_exists($chatFile)) file_put_contents($chatFile, ""); // Ha nincs fájl, hozzuk létre
    $messages = file($chatFile);
    foreach ($messages as $msg) {
        $data = json_decode($msg, true);
        echo "<p><strong>" . $data['username'] . "</strong> [" . $data['time'] . "]: " . $data['message'] . "</p>";
    }
    exit;
}

if (isset($_GET['get_messages'])) {
    $messages = file("chat.txt");
    foreach ($messages as $msg) {
        $data = json_decode($msg, true);
        echo "<p><strong>" . $data['username'] . "</strong> [" . $data['time'] . "]: " . $data['message'] . "</p>";
    }
    exit;
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

// Üzenetek törlése
if (isset($_POST['delete']) && $_SESSION['username'] === 'admin') {
    file_put_contents("uzenetek/chat.txt", "");
    exit;
}
?>
