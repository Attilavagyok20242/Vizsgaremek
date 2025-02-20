<?php
require("../Kapcsolat.php");
$sql = "SELECT  Szoveg, Datum, felhasznalok.Felhasz_nev FROM felhasznalok INNER JOIN kommentek ON felhasznalok.id=kommentek.felhasznalo_id";
$result = $con->query($sql);
while($adatok = $result->fetch_assoc())
{
    $szoveg=$adatok['Szoveg'];
    $datum=$adatok['Datum'];
    $felhasz_nev=$adatok['Felhasz_nev'];
    $adatokS[]=[
        'szoveg'=>$szoveg,
        'datum'=>$datum,
        'felhasz_nev'=>$felhasz_nev
    ];
}
$json=json_encode($adatokS);
print($json);