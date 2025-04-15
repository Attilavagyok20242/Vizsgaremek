<?php
 include "../connection/connection.php";
 header("Content-Type: application/json");
$query = "SELECT nev, szoveg FROM felhasznalo inner join uzenetek on felhasznalo.id=uzenetek.felhasznalo_id ";
 $result = mysqli_query($conn, $query);
 $uzenetek = [];
 while ($row = $result->fetch_assoc()) {
  $uzenetek[] =array(
  "felhasznalo"=>$row["nev"],
  "szoveg" => $row["szoveg"],
  );   
$json=json_encode($uzenetek);
echo $json;
}