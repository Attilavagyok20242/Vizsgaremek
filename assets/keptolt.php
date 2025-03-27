<?php
session_start();
require_once "../connection/connection.php";
if ($_SESSION["id"]) {
        $sql="SELECT nev FROM felhasznalo WHERE id=".$_SESSION["id"];
        $result=$conn->query($sql);
        $row=$result->fetch_assoc();
        if(isset($_FILES["image"])){
            $fileName=$row['nev']."_".$_FILES["image"]["name"];
            $tmpName=$_FILES["image"]["tmp_name"];
            move_uploaded_file($tmpName, '../profilkepek/'.$fileName);
            print "../profilkepek/".$fileName;
    }
}