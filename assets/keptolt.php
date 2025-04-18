<?php
session_start();
require_once "../connection/connection.php";
if ($_SESSION["id"]) {
        $sql="SELECT nev FROM felhasznalo WHERE id=".$_SESSION["id"];
        $result=$conn->query($sql);
        $row=$result->fetch_assoc();
        if(isset($_FILES["image"])){
            $tipusok = ['image/jpeg', 'image/png', 'image/jpg'];
            $kiterjesztesek = ['jpg', 'jpeg', 'png'];
            $fileName=$row['nev']."_".$_FILES["image"]["name"];
            $tmpName=$_FILES["image"]["tmp_name"];
            $mimetipus = mime_content_type($tmpName); // Checks actual MIME type
            $fajlkiterjesztes = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (in_array($mimetipus, $tipusok) && in_array($fajlkiterjesztes, $kiterjesztesek)) {
                $meret=2 * 1024 * 1024;
                if ($_FILES["image"]["size"] < $meret) {
                    move_uploaded_file($tmpName, '../profilkepek/'.$fileName);
                    print "../profilkepek/".$fileName;
                }
                else
                {
                    print "tul_nagy";
                }
            }
            else 
            {
                print "rossz_formatum";
            }
            
    }
}