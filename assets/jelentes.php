<?php
require "../connection/connection.php";

// Kizárjuk az admin felhasználók jelentéseit
$sql = "SELECT *, nev FROM jelentesek INNER JOIN felhasznalo ON jelentesek.felhasznalo_id=felhasznalo.id";  
$result = $conn->query($sql);

$tomb = array(); 

while($row = $result->fetch_assoc()) {
    $tomb[] = array(
        "nev" => $row["nev"],
        "cim" => $row["jelentes_cime"],
        "datum" => $row["datum"]
    );
}

$json = json_encode($tomb);
echo $json;
?>
