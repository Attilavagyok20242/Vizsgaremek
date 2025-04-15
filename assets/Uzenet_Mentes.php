<?php
session_start();
header("Content-Type: application/json");
require_once "../connection/connection.php";

if (!isset($_SESSION['id'])) {
    http_response_code(403);
    echo json_encode(["siker" => false, "hiba" => "Nincs bejelentkezve."]);
    exit;
}

$felhasznaloId = $_SESSION['id'];
$uzenet = trim($_POST['uzenet'] ?? '');

if (empty($uzenet)) {
    echo json_encode(["siker" => false, "hiba" => "Az üzenet nem lehet üres."]);
    exit;
}

// 1. Megnézzük, van-e meglévő beszélgetése
$stmt = $conn->prepare("SELECT id FROM beszelgetesek WHERE felhasznalo_id = ? LIMIT 1");
$stmt->bind_param("i", $felhasznaloId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $beszelgetesId = $row['id'];
} else {
    // Ha nincs, akkor most létrehozzuk
    $stmt = $conn->prepare("INSERT INTO beszelgetesek (felhasznalo_id) VALUES (?)");
    $stmt->bind_param("i", $felhasznaloId);
    $stmt->execute();
    $beszelgetesId = $stmt->insert_id;
}

// 2. Beszúrás az üzenetek közé
$stmt = $conn->prepare("INSERT INTO uzenetek (beszelgetes_id, felhasznalo_id, szoveg) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $beszelgetesId, $felhasznaloId, $uzenet);
$stmt->execute();

echo json_encode(["siker" => true]);
?>
