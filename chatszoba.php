<?php
// SESSION KEZELÉS - A SESSION elindítása
session_start();

// FELHASZNÁLÓNÉV ELLENŐRZÉS - Ha nincs beállítva a felhasználónév a SESSION-ben, próbáljuk meg a POST-ból
if (!isset($_SESSION['username'])) {
    if (isset($_POST['username'])) {
        $_SESSION['username'] = htmlspecialchars($_POST['username']); // Ha POST kérés jött, beállítjuk a SESSION-ben
        $_SESSION['last_active'] = time(); // Mentjük az utolsó aktivitást
    } else {
        // Ha egyik sem történt meg, átirányítjuk a felhasználót a kezdőlapra
        die("<script>window.location.href='index.html';</script>");
    }
}

// SZOBAVÁLASZTÁS - A szobát most már a SESSION-ből olvassuk
$room = $_SESSION["chatroom"] ?? "general"; // Alapértelmezett szoba "general"
$chatFile = "chat_{$room}.txt"; // A fájl neve a szoba alapján

// ÜZENET KÜLDÉSE - Ha POST kérést kapunk üzenet küldésére
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = htmlspecialchars($_POST['message']); // Az üzenetet biztonságosan mentjük
    if (!empty($message)) {
        $data = [
            "username" => $_SESSION['username'],
            "message" => $message,
            "time" => date("H:i:s") // Időbélyeg hozzáadása
        ];
        // Az üzenet hozzáadása a fájlhoz
        file_put_contents($chatFile, json_encode($data) . "\n", FILE_APPEND);
    }
    exit;
}

// ÜZENETEK LEKÉRÉSE - Ha GET kérést kapunk üzenetek lekérésére
if (isset($_GET['get_messages'])) {
    if (!file_exists($chatFile)) file_put_contents($chatFile, ""); // Ha nincs fájl, hozzuk létre
    $messages = file($chatFile); // Az üzenetek beolvasása a fájlból
    foreach ($messages as $msg) {
        $data = json_decode($msg, true); // Üzenetek dekódolása JSON formátumból
        echo "<p><strong>" . $data['username'] . "</strong> [" . $data['time'] . "]: " . $data['message'] . "</p>";
    }
    exit;
}

// FELHASZNÁLÓK LEKÉRÉSE - Ha GET kérés érkezik a felhasználók lekérésére
if (isset($_GET['get_users'])) {
    $users = isset($_SESSION['users']) ? $_SESSION['users'] : []; // Ha van felhasználói lista, használjuk
    $users[$_SESSION['username']] = time(); // A felhasználó aktivitási idejének beállítása
    $_SESSION['users'] = $users; // Mentsük el a SESSION-ben

    foreach ($users as $user => $last_active) {
        if (time() - $last_active < 60) { // Ha a felhasználó 1 percen belül aktív, mutassuk
            echo "<p>✅ $user</p>";
        }
    }
    exit;
}

// ÜZENETEK TÖRLÉSE - Admin felhasználók számára, ha POST kérés érkezik a törléshez
if (isset($_POST['delete']) && $_SESSION['username'] === 'admin') {
    file_put_contents("chat.txt", ""); // Az összes üzenet törlése
    exit;
}
?>
