<?php
session_start();
header('Content-Type: application/json');
require_once "../connection/connection.php";

$uzenetId = intval($_POST['id'] ?? 0);

if (!$uzenetId) {
    echo json_encode(["siker" => false, "hiba" => "Érvénytelen ID."]);
    exit;
}

$stmt = $conn->prepare("UPDATE uzenetek SET jovahagyva = 1 WHERE id = ?");
$stmt->bind_param("i", $uzenetId);

if ($stmt->execute()) {
    echo json_encode(["siker" => true, "uzenet" => "Üzenet jóváhagyva."]);
} else {
    echo json_encode(["siker" => false, "hiba" => "Nem sikerült jóváhagyni."]);
}
?>
