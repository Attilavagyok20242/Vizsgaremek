<?php
session_start();
require_once "../connection/connection.php";

if (!isset($_SESSION['id'])) {
    http_response_code(403);
    exit("Nincs jogosultság.");
}
$felhasznaloId = $_SESSION['id'];
$uzenetek = [];
    $query = "SELECT u.szoveg, u.datum, f.nev AS felhasznalo, f.Szerep, j.felhasznalo_id, u.jelentesek_id
              FROM uzenetek u
              JOIN jelentesek j ON u.jelentesek_id = j.id
              JOIN felhasznalo f ON j.felhasznalo_id = f.id
              ORDER BY u.datum ASC"; 

    $stmt = $conn->prepare($query);

    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $uzenetek[] = [
            "felhasznalo" => $row["felhasznalo"], 
            "szoveg" => $row["szoveg"],           
            "letrehozva" => $row["datum"]         
        ];
    }
    header("Content-Type: application/json");
    echo json_encode($uzenetek);
?>
