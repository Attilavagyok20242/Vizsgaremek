<?php
session_start();
require_once('connection/connection.php');
$nev=$_SESSION['nev'];
$email=$_SESSION['email'];
$id=$_SESSION['id'];
$query = "SELECT datum FROM felhasznalo WHERE id = '$id'";
$query2="SELECT count(messages.text) as textdarabszam FROM messages inner join felhasznalo on messages.id=felhasznalo.id where felhasznalo.nev ='$nev'";
$result = mysqli_query($con, $query);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $regisztraciodatuma = $row['datum']; 
}
$result2=mysqli_query($con, $query2);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $textdarabszam = $row['textdarabszam']; 
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link rel="stylesheet" href="css/user-kinezet.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<div id="User">
    <button id="vissza" >Vissza a főoldalra!</button>
     <div id="cim">
     <h1>Felhasználói fiókod adatai<span>:</span></h1>
     </div>
    <div id="pkeret">
        <img src="ikon/felh_ikon.png" id="felhasznalokep" class="profil">
        <div id="adatok">
        <p id="fnev">Felhasználó név:<?php echo $nev?><p>
        <p id="email">E-mail:<?php echo $email?></p>
        <p id="elozmenyek">Kommentjeid száma:<?php echo $textdarabszam?></p>
        <p id="regdate">Regisztráció dátuma:<?php echo $regisztraciodatuma?></p>
        </div>
    </div>
    <div id="menusor"><div class="belsokeret">
        <button class="adatok" id="profilkep">Profilkép</button>
        <button class="adatok" id="adatvaltoz">Adatatváltoztatás</button>
        <button class="adatok">Naplód</button>
        <button class="adatok">Hibajelentéseid</button></div></div>
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
<script src="Javascripts/felhasznaloi.js"></script>
<script src="Javascripts/user-adats.js"></script>
</body>
</html>
