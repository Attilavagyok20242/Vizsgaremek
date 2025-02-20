<!DOCTYPE html>
<html lang="hu">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link rel="stylesheet" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<button id="vissza">Vissza a főoldalra!</button>
<div id="cim">
<h1>Felhasználói fiókod adatai<span>:</span></h1>
</div>
    
    <div id="pkeret">
        <img src="ikon/felh_ikon.png" id="felhasznalokep" class="profil">
        <div id="adatok">
        <p id="fnev">Felhasználó név:<p>
        <p id="email">E-mail:</p>
        <p id="elozmenyek">Kommentjeid száma:</p>
        <p id="regdate">Regisztráció dátuma:</p>
        </div>
    </div>
    <div id="menusor"><div class="belsokeret"><button class="adatok" id="profilkep">Profilkép</button><button class="adatok" id="adatvaltoz">Adatatváltoztatás</button><button class="adatok">Naplód</button><button class="adatok">Hibajelentéseid</button></div></div>




    <div id="kartya1" class="kartyak">
        <input type="file" id="kepfeltolt" onchange="Kepvaltoztat()" name="felh_ikon" accept=".jpg,.jpeg,.png">
        <img src="ikon/feltoltes.png" id="profil" class="profil">
        <input type="button" value="Kép feltöltés" id="feltolt" onclick="KepFeltot()">
    </div>

    



<div id="kartya2" class="kartyak">
    <p>Változtasd meg felhasználói neved!</p>
    <button id="nevchan" class="valtozz">Változz!</button>
<div id="box1">
    <p></p>
    <div class="bemenetek"><input type="text" class="bemenet" id="ujfelnev" placeholder="Az új felhasználó neved..."><input class="bemenet" type="submit" value="Küld!"></div>
</div>
    <p>Változtasd meg az e-mail címedet!</p>
    <button id="emailchan" class="valtozz">Változz!</button>




<div id="box2">
    <div class="bemenetek"><input type="text" class="bemenet" id="ujemail" placeholder="Az új E-mail címed..."><input class="bemenet" type="submit" value="Küld!"></div>
</div>



    <p>Változtasd meg jelszavadat!</p>
    <button id="jelchan" class="valtozz">Változz!</button>

<div id="box3">
    
<div class="bemenetek">
<p id="visszajelzes3" class="visszajelzes"></p>
<input type="text" class="bemenet" name="ujjelszo" id="ujjelszo" placeholder="Az új jelszavad..." required><div>
<input type="text" class="bemenet" name="ujujjelszo" id="ujujjelszo" placeholder="Az új jelszavad újra..." required>
<button onclick="JelVizsgal()">Küld</button>
</div>
</div>


<div id="kartya3">





</div>

    
</div>
<script src="felhasznaloi.js"></script>
</body>
</html>



<?php
    // require_once("../Kapcsolat.php");
    
    // if ($_FILES["felh_ikon"]["error"]===4) 
    // {
    //     echo
    //     "<script> alert('Kép nem létezik')</script>";
    // }
    // else{
    //     $fileName=$_FILES["felh_ikon"]["name"];
    //     $fileSize=$_FILES["felh_ikon"]["size"];
    //     $tmpName=$_FILES["felh_ikon"]["tmp_name"];

    //     $validImageExtension=['jpg','jpeg','png'];
    //     $imageExtension=explode('.',$fileName);
    //     $imageExtension=strtolower(end($imageExtension));
    //     if (!in_array($imageExtension,$validImageExtension)) {
    //         echo
    //         "<script>alert('Rossz képkiterjesztés!');</script>";
    //     }
    //     else if($fileSize>1000000){
    //         echo
    //         "<script>alert('Kép túl nagy!');</script>";
    //     }
    //     else
    //     {
    //         $newImageName=uniqid();
    //         $newImageName.='.'.$imageExtension;
    //         move_uploaded_file($tmpName, 'ikon/'.$newImageName);
    //         $query="UPDATE TABLE tb_upload VALUES ('','$name','$newImageName')";
    //         $sql = "UPDATE felhasznalo SET profil_kep='$newImageName' WHERE id=1";
    //         $conn->query($query);
    //         echo
    //         "<script>alert('Kép sikeresen feltöltve!'); document.location.href='data.php'</script>";

            
    //     }
    // }

?>