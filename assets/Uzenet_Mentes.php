<?php
session_start();
header("Content-Type: application/json");
require_once "../connection/connection.php";

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['id'])) {
    echo json_encode(["siker" => false, "hiba" => "Nincs bejelentkezve."]);
    http_response_code(403);
    exit;
}

$felhasznaloId = $_SESSION['id'];
$uzenet = trim($_POST['uzenet'] ?? '');  
$cim = trim($_POST['cim'] ?? '');  

if (empty($uzenet)) {
    echo json_encode(["siker" => false, "hiba" => "Az üzenet nem lehet üres."]);
    exit;
}

$stmt = $conn->prepare("SELECT id FROM jelentesek WHERE felhasznalo_id = ? AND jovahagyva = 1 ORDER BY datum DESC LIMIT 1");
$stmt->bind_param("i", $felhasznaloId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $jelentesId = $row['id'];  
} else {
    if (empty($cim)) {
        $cim = mb_substr($uzenet, 0, 50);  
    }

    $stmt = $conn->prepare("INSERT INTO jelentesek (felhasznalo_id, jelentes_cime, datum, jovahagyva) VALUES (?, ?, NOW(), 0)");
    $stmt->bind_param("is", $felhasznaloId, $cim);

    if (!$stmt->execute()) {
        echo json_encode(["siker" => false, "hiba" => "Nem sikerült új jelentést létrehozni."]);
        exit;
    }

    $jelentesId = $stmt->insert_id;  
}

$stmt = $conn->prepare("SELECT id FROM uzenet_szalk WHERE felhasznalo_id = ? AND admin_id IS NULL AND statusz = 'nyitott' LIMIT 1");
$stmt->bind_param("i", $felhasznaloId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $szalId = $row['id'];  
} else {
    $stmt = $conn->prepare("INSERT INTO uzenet_szalk (felhasznalo_id, statusz) VALUES (?, 'nyitott')");
    $stmt->bind_param("i", $felhasznaloId);

    if (!$stmt->execute()) {
        echo json_encode(["siker" => false, "hiba" => "Nem sikerült új beszélgetési szálat létrehozni."]);
        exit;
    }

    $szalId = $stmt->insert_id;  
}

$stmt = $conn->prepare("INSERT INTO uzenetek (szoveg, datum, felhasznalo_id, szal_id, jelentesek_id) VALUES (?, NOW(), ?, ?, ?)");
$stmt->bind_param("siii", $uzenet, $felhasznaloId, $szalId, $jelentesId);

if ($stmt->execute()) {
    echo json_encode(["siker" => true, "jelentes_id" => $jelentesId, "szal_id" => $szalId, "message" => "Üzenet sikeresen mentve."]);
} else {
    echo json_encode(["siker" => false, "hiba" => "Nem sikerült elmenteni az üzenetet."]);
}
?>
