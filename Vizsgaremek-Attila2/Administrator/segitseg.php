<?php
include 'connection/connection.php';
header('Content-Type: application/json;charset=UTF-8');

$sql = "SELECT cim AS cim, 
               leiras AS leiras, 
               datum AS Datum 
        FROM bejelentesek";

$result = $con->query($sql);

$tomb = []; 

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tomb[] = [
            "cim" => $row["cim"],
            "leiras" => $row["leiras"],
            "datum"  => $row["Datum"]
        ];
    }
}
echo json_encode($tomb, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
