<?php
    require "../connection/connection.php";
    session_start();
    if(isset($_POST['jelszo1']))
    {
        $jelszo = password_hash($_POST['jelszo1'],PASSWORD_DEFAULT);
        $sql = "UPDATE felhasznalo SET jelszo = '$jelszo' WHERE id=".$_SESSION['id'];
        try{
            $result = mysqli_query($conn, $sql);
            print"Sikeresen megváltoztattad a jelszavadat!";
        }
        catch(Exception){
            print"24";
        }
        
        
    }
    if(isset($_POST['ujfelnev']))
    {
        $ujfelnev=$_POST['ujfelnev'];
        if ($ujfelnev!="") {
            $sql = "SELECT nev FROM felhasznalo WHERE nev='$ujfelnev'";
            $result=$conn->query($sql);
            if (mysqli_num_rows($result)<1) {
                $sql = "UPDATE felhasznalo SET nev = '$ujfelnev' WHERE id=".$_SESSION['id'];
                $conn->query($sql);
                print "Sikeres név változtatás!";
            }
            else{
                print "foglalt";
            }
        }
        else{
            print "nincs";
        }
        
    }
    if(isset($_POST['ujemail']))
    {
        $ujemail=$_POST['ujemail'];
        if (filter_var($ujemail, FILTER_VALIDATE_EMAIL)) {
            $sql = "SELECT email FROM felhasznalo WHERE email='$ujemail'";
            $result=$conn->query($sql);
            if (mysqli_num_rows($result)<1) {
                $sql = "UPDATE felhasznalo SET email = '$ujemail' WHERE id=".$_SESSION['id'];
                $conn->query($sql);
                print "Sikeres email változtatás!";
            }
            else{
                print "foglalt";
            }
        }
        else{
            print "formatum_hiba";
        }
    }