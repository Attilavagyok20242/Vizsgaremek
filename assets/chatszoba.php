<?php
session_start();

if (!isset($_SESSION['nev'])) {
    if (isset($_COOKIE['nev'])) {
        $_SESSION['nev'] = $_COOKIE['nev'];
    } elseif (isset($_POST['nev'])) {
        $_SESSION['nev'] = htmlspecialchars($_POST['nev']);
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
            "nev" => $_SESSION['nev'],
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
        echo "<p><strong>" . $data['nev'] . "</strong> [" . $data['time'] . "]: " . $data['message'] . "</p>";
    }
    exit;
}

if (isset($_GET['get_messages'])) {
    $messages = file("chat.txt");
    foreach ($messages as $msg) {
        $data = json_decode($msg, true);
        echo "<p><strong>" . $data['nev'] . "</strong> [" . $data['time'] . "]: " . $data['message'] . "</p>";
    }
    exit;
}
if (isset($_GET['get_users'])) {
    $users = isset($_SESSION['users']) ? $_SESSION['users'] : [];
    $users[$nev] = time();
    $_SESSION['users'] = $users;

    foreach ($users as $user => $last_active) {
        if (time() - $last_active < 60) {
            echo "<p>✅ $user</p>";
        }
    }
    exit;
}

// Üzenetek törlése
if (isset($_POST['delete']) && $_SESSION['nev'] === 'admin') {
    file_put_contents("uzenetek/chat.txt", "");
    exit;
}
?>
