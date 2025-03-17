<?php
    session_start();
    require("../connection.php");
    $_SESSION['id']=196;
    if (isset($_SESSION['id'])) {
        $sql="SELECT nev, email,datum,profilkep FROM felhasznalo WHERE id=".$_SESSION["id"];
        $result=$con->query($sql);
        $row=$result->fetch_assoc();
        if (isset($_POST["kuld"])) {

            if(isset($_FILES["image"])){
                $fileName=$row['nev'].'_'.$_FILES["image"]["name"];
                $tmpName=$_FILES["image"]["tmp_name"];
                $con->query("UPDATE felhasznalo SET profilkep='$fileName' WHERE id=".$_SESSION["id"]);
            }
            header("location:felhasznaloi.php");
        }
        
    }
    
?>
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
<h1>Felhasználói fiókod adatai<span class="fekete">:</span></h1>
</div>
    
    <div id="pkeret">
        <img src="<?php print "profilkepek/".$row["profilkep"];?>" id="felhasznalokep" class="profil">
        <div id="adatok">
        <p id="fnev">Felhasználó név:<span class="adatok2"><?php if(isset($row['nev'])){print $row['nev'];} ?></span><p>
        <p id="email">E-mail:<span class="adatok2"><?php if(isset($row['email'])){print $row['email'];} ?></span></p>
        <p id="elozmenyek">Kommentjeid száma:<span class="adatok2"></span></p>
        <p id="regdate">Regisztráció dátuma:<span class="adatok2"><?php if(isset($row['nev'])){print $row['datum'];} ?></span></p>
        </div>
    </div>
    <div id="menusor"><div class="belsokeret"><button class="adatok" id="profilkep">Profilkép</button>
    <button class="adatok" id="adatvaltoz">Adatatváltoztatás</button><button class="adatok">Naplód</button>
    <button class="adatok">Hibajelentéseid</button></div></div>
    
    <div id="kartya1" class="kartyak">
        <form action="" method="post" enctype="multipart/form-data">
        <input type="file" id="kepfeltolt" onchange="Kepvaltoztat()" name="image" accept=".jpg,.jpeg,.png">
        <img src="ikon/feltoltes.png" id="profil" class="profil">
        <input type="submit" value="Kép feltöltés" name="kuld" id="feltolt">
        </form>
    </div>

    



<div id="kartya2" class="kartyak">
    <p>Változtasd meg felhasználói neved!</p>
    <button id="nevchan" class="valtozz">V</button>
<div id="box1">
    <p class="visszajelzes" id="visszajelzesnev"></p>
    <div class="bemenetek"><input type="text" class="bemenet" id="ujfelnev" placeholder="Az új felhasználó neved...">
    <button class="bemenet" onclick="FelhNevModosit()">Küld</button></div>
</div>

    <p>Változtasd meg az e-mail címedet/Erősítsd meg azt!</p>
    <button id="emailchan" class="valtozz">V</button>
<div id="box2">
    <div class="bemenetek">
        <p class="visszajelzes" id="visszajelzesemail"></p>
        <input type="text" class="bemenet" id="ujemail" placeholder="Az új E-mail címed...">
        <button onclick="EmailModosit()">Küld</button>
        <br>
        <input type="email" class="bemenet" id="megerosit" placeholder="E-mail címed!">
        <button class="bemenet" onclick="JelszoMegerosit()">Megerősítés</button>
</div>
</div>



    <p>Változtasd meg jelszavadat!</p>
    <button id="jelchan" class="valtozz">V</button>

<div id="box3">
    
<div class="bemenetek">
<p id="visszajelzesjelszo" class="visszajelzes"></p>
<input type="text" class="bemenet" name="ujjelszo" id="ujjelszo" placeholder="Az új jelszavad..." required>
<br>
<input type="text" class="bemenet" name="ujujjelszo" id="ujujjelszo" placeholder="Az új jelszavad újra..." required>
<button onclick="JelVizsgal()">Küld</button>
</div>


<div id="kartya3">





</div>

    
</div>
<script src="felhasznaloi.js"></script>
</body>
</html>