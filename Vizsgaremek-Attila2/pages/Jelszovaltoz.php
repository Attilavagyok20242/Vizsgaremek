<?php
    include("connection/connection.php");
    if(isset($_POST['jelszo1']))
    {
        $jelszo = $_POST['jelszo1'];
        $sql = "UPDATE felhasznalo SET felhasznalo_jel = '$jelszo' WHERE felhasznalo_nev Like 'Attila'";
        $result = mysqli_query($con, $sql);
        print"Sikeresen megváltoztattad a jelszavadat!";
        
    }
    else {
        
        print("NO NO NO!");
    }

 







