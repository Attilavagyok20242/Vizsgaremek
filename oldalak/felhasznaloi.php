<?php
    if (isset($_SESSION['id'])) {
        $sql="SELECT nev, email,datum,profilkep FROM felhasznalo WHERE id=".$_SESSION["id"];
        $result=$conn->query($sql);
        $row=$result->fetch_assoc();
        if (isset($_POST["kuld"])) {

            if(isset($_FILES["image"])){
                $fileName=$row['nev'].'_'.$_FILES["image"]["name"];
                $tmpName=$_FILES["image"]["tmp_name"];
                if($_FILES['image']['name']!=""){
                    $conn->query("UPDATE felhasznalo SET profilkep='$fileName' WHERE id=".$_SESSION["id"]);
                }
            }
            header("Location:http://arenaklub.loc/?page=Profil");
        }
        
    }    
if(!isset($_SESSION['id']))
{
    header("Location: /fooldal");
    exit();
}
?>
<link rel="stylesheet" href="css/style2.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<section class="egesz">
    <div id="cim">
        <h1>Felhasználói fiókod adatai<span class="fekete">:</span></h1>
    </div>
<section id ="pkeret">
    <div class="kepkeret">
        <img src="<?php print "../profilkepek/".$row["profilkep"];?>" id="felhasznalokep" class="profil">
    </div>
    <div id="adatok">
        <p id="fnev">Felhasználó név:<span class="adatok2"><?php if(isset($row['nev'])){print $row['nev'];} ?></span><p>
        <p id="email">E-mail:<span class="adatok2"><?php if(isset($row['email'])){print $row['email'];} ?></span></p>
        <p id="elozmenyek">Kommentjeid száma:<span class="adatok2"></span></p>
        <p id="regdate">Regisztráció dátuma:<span class="adatok2"><?php if(isset($row['nev'])){print $row['datum'];} ?></span></p>
    </div>
</section>
<section class="megerositesfel">
    <button class="megerosites-gombs" onclick="megerosites()">Felhaszalo megerősítő kód kérése</button>
    <form action="" method="post">
        <input type="number" name="megerosites" class="number"  required>
        <button type="submit" class="kuldes">Küldés</button>
    </form>
</section>
    <div id="menusor">
        <div class="belsokeret">
            <button class="adatok" id="profilkep">Profilkép</button>
            <button class="adatok" id="adatvaltoz">Adatatváltoztatás</button>
            <button class="adatok" id="naplo">Naplód</button>
        </div>
    </div>
    <div id="kartya1" class="kartyak">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="kepkeret">
                <input type="file" id="kepfeltolt" onchange="Kepvaltoztat()" name="image" accept=".jpg,.jpeg,.png">
                <img src="ikon/feltoltes.png" id="profil" class="profil">
            </div>
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
        <p>Változtasd meg az e-mail címedet</p>
        <button id="emailchan" class="valtozz">V</button>
        <div id="box2">
            <div class="bemenetek">
                <p class="visszajelzes" id="visszajelzesemail"></p>
                <input type="text" class="bemenet" id="ujemail" placeholder="Az új E-mail címed...">
                <button onclick="EmailModosit()">Küld</button>
                <br>
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
        </div>
    </div>
    <div id="kartya3" class="kartyak">
        <div class="naplod">
        </div>
    </div>
</section>