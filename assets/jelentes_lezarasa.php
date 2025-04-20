<?php
session_start();
require "../connection/connection.php";

header("Content-Type: application/json");

if (!isset($_SESSION['id'])) {
    echo json_encode(["siker" => false, "hiba" => "Nincs bejelentkezve felhasználó."]);
    exit;
}

$felhasznaloId = $_SESSION['id'];

if ($conn->connect_error) {
    die(json_encode(["siker" => false, "hiba" => "Kapcsolódási hiba: " . $conn->connect_error]));
}

$sql = "SELECT jelentesek.id 
        FROM jelentesek 
        INNER JOIN felhasznalo 
        ON jelentesek.felhasznalo_id = felhasznalo.id 
        WHERE felhasznalo.Szerep = 0 Or felhasznalo.Szerep=1
        AND jelentesek.jovahagyva = 1 Or jelentesek.jovahagyva=0";

if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result($jelentesId);  
    
    if ($stmt->fetch()) {
    } else {
        echo json_encode(["siker" => false, "hiba" => "Nincsenek megfelelelő jelentések."]);
        exit;
    }
    $stmt->close();
} else {
    echo json_encode(["siker" => false, "hiba" => "Hiba történt a lekérdezés végrehajtása során."]);
    exit;
}

$sql = "UPDATE uzenet_szalk SET statusz = 'lezárva' WHERE felhasznalo_id = ? AND statusz != 'lezárva'";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $felhasznaloId);
    $stmt->execute();
    $stmt->close();
}

$sql = "DELETE FROM jelentesek WHERE id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $jelentesId);
    $stmt->execute();
    $stmt->close();
}

echo json_encode(["siker" => true, "message" => "Lezárva, üzenetek és jelentések törölve."]);

$conn->close();
?>
