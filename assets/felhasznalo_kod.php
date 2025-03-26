<?php
session_start();
header('Content-Type: application/json');
require_once("../connection/connection.php");

$response = ["megerosites" => false];

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    echo json_encode(["error" => "Felhasználó nincs bejelentkezve"]);
    exit;
}

if ($conn->connect_error) {
    echo json_encode(["error" => "Adatbázis kapcsolat sikertelen"]);
    exit;
}

$id = $_SESSION['id'];

$stmt = $conn->prepare("SELECT megerositve FROM felhasznalo WHERE megerositve = 1 AND id = ?");
if (!$stmt) {
    echo json_encode(["error" => "Lekérdezés előkészítése sikertelen"]);
    exit;
}

$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $response["megerosites"] = true;
}

$stmt->close();
$conn->close();

echo json_encode($response);
exit;
?>

