<?php
    session_start();
    include("../connection.php");
    if(isset($_POST['jelszo1']))
    {
        $jelszo = password_hash($_POST['jelszo1'],PASSWORD_DEFAULT);
        $sql = "UPDATE felhasznalo SET jelszo = '$jelszo' WHERE id=".$_SESSION['id'];
        $result = mysqli_query($con, $sql);
        print"Sikeresen megváltoztattad a jelszavadat!";
        
    }
    if(isset($_POST['ujfelnev']))
    {
        $ujfelnev=$_POST['ujfelnev'];
        $sql = "SELECT nev FROM felhasznalo WHERE nev='$ujfelnev'";
        $result=$con->query($sql);
        if (mysqli_num_rows($result)<1) {
            $sql = "UPDATE felhasznalo SET nev = '$ujfelnev' WHERE id=".$_SESSION['id'];
            $con->query($sql);
            print "Sikeres név változtatás!";
        }
        else{
            print "foglalt";
        }
    }
    if(isset($_POST['ujemail']))
    {
        $ujemail=$_POST['ujemail'];
        $sql = "SELECT email FROM felhasznalo WHERE email='$ujemail'";
        $result=$con->query($sql);
        if (mysqli_num_rows($result)<1) {
            $sql = "UPDATE felhasznalo SET email = '$ujemail' WHERE id=".$_SESSION['id'];
            $con->query($sql);
            print "Sikeres név változtatás!";
        }
        else{
            print "foglalt";
        }
    }