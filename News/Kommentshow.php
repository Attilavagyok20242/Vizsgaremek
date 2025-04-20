<?php
session_start();
require("../connection/connection.php");
if (isset($_GET['id'])) {
    $id=$_GET['id'];
    $_SESSION['hirid']=$id;
    $sql="SELECT kommentek.id,nev,szoveg,kommentek.datum FROM kommentek INNER JOIN felhasznalo 
    ON kommentek.felhasznalo_id=felhasznalo.id INNER JOIN hirek ON kommentek.hir_id=hirek.id WHERE hir_id=$id ORDER BY kommentek.datum";
    $result=$conn->query($sql);
    if (mysqli_num_rows($result)>0) {
        while($row=$result->fetch_assoc())
        {
           $tomb[]=array(
                "id"=>$row["id"],
                "nev"=>$row["nev"],
                "szoveg"=>$row["szoveg"],
                "datum"=>$row["datum"],
                "helyese"=>true
           );
        }
        $json=json_encode($tomb);
        print($json);
    }
    else{
        $tomb[]=array(
            "helyese"=>false
        );
        $json=json_encode($tomb);
        print($json);
    }
}

?>