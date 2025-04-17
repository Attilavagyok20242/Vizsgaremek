<?php
require "../connection/connection.php";
session_start();

$felhasznalo=$conn->query("SELECT * FROM nev_elozmenyek");
$email=$conn->query("SELECT * FROM email_elozmenyek");
$jelszo=$conn->query("SELECT * FROM jelszo_elozmenyek");
$tomb = [
    'nev' => [],
    'email' => [],
    'jelszo' => []
];
if ($felhasznalo) {
    while ($row = $usernames->fetch_assoc()) {
        $tomb['nev'][] = $row;
    }
}

if ($email) {
    while ($row = $emails->fetch_assoc()) {
        $tomb['email'][] = $row;
    }
}

if ($jelszo) {
    while ($row = $passwords->fetch_assoc()) {
        $tomb['password'][] = $row;
    }
}

header('Content-Type: application/json');
$json=json_encode($tomb);
print($json);