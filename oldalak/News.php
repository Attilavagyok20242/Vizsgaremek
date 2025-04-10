<?php

session_start();
$sql="SELECT id,hir_szoveg, hir_cim,datum FROM hirek ORDER BY datum ASC LIMIT 3";
$result=$conn->query($sql);

while($row=$result->fetch_assoc())
{
    $tomb[]=array
    (
        "id" => $row["id"],
        "hir_szoveg" => $row["hir_szoveg"],
        "hir_cim" => $row["hir_cim"],
        "datum" => $row["datum"]
    );
}
$elso_id=$tomb[0]["id"];
$elso_hir=$tomb[0]["hir_szoveg"];
$elso_hir_cim=$tomb[0]["hir_cim"];
$elso_datum=$tomb[0]["datum"];

$masodik_id=$tomb[1]['id'];
$masodik_hir=$tomb[1]["hir_szoveg"];
$masodik_hir_cim=$tomb[1]["hir_cim"];
$masodik_datum=$tomb[1]["datum"];

$harmadik_id=$tomb[2]['id'];
$harmadik_hir=$tomb[2]["hir_szoveg"];
$harmadik_hir_cim=$tomb[2]["hir_cim"];
$harmadik_datum=$tomb[2]["datum"];


?>

    <link rel="stylesheet" href="../css/News.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<body>
    <div class="kulso" id="eltuntet">
    </div>
        <div class="kommentkeret" id="komm">
            <div class="kommentek" id="k">
            </div>
            <div class="uzenet">
            <textarea class="uzenetir" id="uzenetkuld" maxlength="200"></textarea>
            <input type="button" value="Küld!"  onclick="UziKuld()" class="gomb">
            </div>
        </div>
    
    <img src="NewsImg/Title.png" class="oldalcim">
    <div class="keret">
        <div class="belsokeret">
            <div class="scrollrolled" id="rolled1">
                <img src="NewsImg/rolledupscroll2.png" class="rolledkep">
            </div>
            <div class="scroll" id="scroll1">
                <div class="szovegkeret">
                    <h1 class="cim"><?php print $elso_hir_cim?></h1>
                    <p class="szoveg"><?php print $elso_hir?></p>
                    <p id="datum"><?php print $elso_datum?></p>
                    <img class="stamp" src="NewsImg/stamp.png">
                </div>
                <?php if(isset($_SESSION["id"])){print"<img src='NewsImg/Comment2.png' id='kommentgomb' class='komment' onclick='KommentSec(".$elso_id.")'>";}?>  
            </div>
        </div>
        <div class="belsokeret">
            <div class="scrollrolled" id="rolled2">
                <img src="NewsImg/rolledupscroll2.png" class="rolledkep"></div>
            <div class="scroll" id="scroll2">
                <div class="szovegkeret">
                <h1 class="cim"><?php print $masodik_hir_cim?></h1>
                <p class="szoveg"><?php print $masodik_hir?></p>
                <p id="datum"><?php print $masodik_datum?></p><img class="stamp" src="../NewsImg/stamp.png">
                </div>
                <?php if(isset($_SESSION["id"])){print"<img src='NewsImg/Comment2.png' id='kommentgomb' class='komment' onclick='KommentSec(".$masodik_id.")'>";}?>   
            </div>
        </div>
        <div class="belsokeret">
            <div class="scrollrolled" id="rolled3">
                <img src="NewsImg/rolledupscroll2.png" class="rolledkep"></div>
            <div class="scroll" id="scroll3">
            <div class="szovegkeret">
                <h1 class="cim"><?php print $harmadik_hir_cim?></h1>
                <p class="szoveg"><?php print $harmadik_hir?></p>
                <p id="datum"><?php print $harmadik_datum?></p><img class="stamp" src="../NewsImg/stamp.png"></div>
                <?php if(isset($_SESSION["id"])){print"<img src='NewsImg/Comment2.png' id='kommentgomb' class='komment' onclick='KommentSec(".$harmadik_id.")'>";}?> 
        </div> 
    </div>
    
    
    

    <script src="Javascripts/News.js"></script>
    
</body>
</html>