<?php
session_start();
require_once "../connection/connection.php";

// if (!isset($_SESSION['id'])) {
//     http_response_code(403);
//     exit("Nincs jogosultság.");
// }

$felhasznaloId = $_SESSION['id'];
$adminE = $_SESSION['Szerep'] ?? 0;

// Ha admin vagy, az összes beszélgetést betöltheted
if ($adminE) {
    $query = "SELECT u.szoveg, u.letrehozva, f.nev AS felhasznalo, f.Szerep, u.beszelgetes_id FROM uzenetek u 
    JOIN felhasznalo f ON u.felhasznalo_id = f.id ORDER BY u.letrehozva ASC;";
    $stmt = $conn->prepare($query);
} else {
    // Ha a felhasználó nem admin, csak a saját beszélgetéseit töltheti be
    $query = "SELECT u.szoveg, u.letrehozva, f.nev AS felhasznalo, f.Szerep, u.beszelgetes_id FROM uzenetek u
     JOIN beszelgetesek b ON u.beszelgetes_id = b.id JOIN felhasznalo f ON u.felhasznalo_id = f.id 
     WHERE b.felhasznalo_id =$felhasznaloId ORDER BY u.letrehozva ASC";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();
$uzenetek = [];

while ($row = $result->fetch_assoc()) {
    $uzenetek[] =array(
    "felhasznalo"=>$row["felhasznalo"],
    "szoveg" => $row["szoveg"],
    "letrehozva" => $row["letrehozva"]

    );   
}

header("Content-Type: application/json");
$json=json_encode($uzenetek);
echo $json;
?>
