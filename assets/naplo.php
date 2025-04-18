<?php
require "../connection/connection.php";
session_start();

$id=$_SESSION["id"];
$felhasznalo=$conn->query("SELECT * FROM nev_elozmenyek WHERE felhasznalo_id=$id ORDER BY datum DESC");
$email=$conn->query("SELECT * FROM email_elozmenyek WHERE felhasznalo_id=$id ORDER BY datum DESC");
$jelszo=$conn->query("SELECT * FROM jelszo_elozmenyek WHERE felhasznalo_id=$id ORDER BY datum DESC");
$tomb = [
    'nev' => [],
    'email' => [],
    'jelszo' => []
];
if ($felhasznalo) {
    while ($row = $felhasznalo->fetch_assoc()) {
        $tomb['nev'][] = $row;
    }
}

if ($email) {
    while ($row = $email->fetch_assoc()) {
        $tomb['email'][] = $row;
    }
}

if ($jelszo) {
    while ($row = $jelszo->fetch_assoc()) {
        $tomb['jelszo'][] = $row;
    }
}

header('Content-Type: application/json');
$json=json_encode($tomb);
print($json);