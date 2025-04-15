<?php
session_start();
require_once "../connection/connection.php";

header('Content-Type: application/json'); 

if (!isset($_SESSION['id'])) {
    echo json_encode(["siker" => false, "hiba" => "Nincs bejelentkezve."]);
    exit;
}

$felhasznaloId = $_SESSION['id'];
$szerep = $_SESSION['Szerep'];

$beszelgetesId = intval($_POST['beszelgetes_id'] ?? 0); 

// Ha nincs beszelgetes_id, akkor új beszélgetést indítunk
if ($beszelgetesId == 0) {
    $stmt = $conn->prepare("INSERT INTO beszelgetesek (felhasznalo_id, admin_id) VALUES (?, ?)");

    if ($szerep == 1) {
        // Ha admin a felhasználó, akkor őt rendeljük az admin_id-hez
        $stmt->bind_param("ii", $felhasznaloId, $felhasznaloId);
    } else {
        // Ha nem admin, akkor null-t helyettesítünk az admin_id-vel
        $null = NULL;
        $stmt->bind_param("ii", $felhasznaloId, $null);
    }

    $stmt->execute();
    $beszelgetesId = $stmt->insert_id;
}

// Üzenet szöveg beolvasása
$valasz = trim($_POST['valasz'] ?? '');

if (!empty($valasz)) {
    // Üzenet mentése az uzenetek táblába
    $stmt = $conn->prepare("INSERT INTO uzenetek (beszelgetes_id, felhasznalo_id, szoveg) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $beszelgetesId, $felhasznaloId, $valasz);
    $stmt->execute();

    echo json_encode(["siker" => true, "uzenet" => "Válasz elküldve."]);
    exit;
} else {
    echo json_encode(["siker" => false, "hiba" => "Hiányzó válasz."]);
    exit;
}
?>
