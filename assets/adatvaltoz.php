<?php
    session_start();
    require "../connection/connection.php";
    if(isset($_POST['jelszo1']))
    {
        $jelszo = password_hash($_POST['jelszo1'],PASSWORD_DEFAULT);
        $sql = "UPDATE felhasznalo SET jelszo = ? WHERE id=?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param("si" ,$jelszo,$_SESSION["id"]);
        try{
            $stmt->execute();
            print"Sikeresen megváltoztattad a jelszavadat!";
        }
        catch(Exception){
            print"24";
        }
        
        
    }
    if(isset($_POST['ujfelnev']))
    {
        $ujfelnev=$_POST['ujfelnev'];
        $sql = "SELECT nev FROM felhasznalo WHERE nev=?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param("s",$ujfelnev);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows<1) {
            $sql = "UPDATE felhasznalo SET nev = ? WHERE id=?";
            $stmt=$conn->prepare($sql);
            $stmt->bind_param("si",$ujfelnev,$_SESSION["id"]);
            $stmt->execute();
            print "Sikeres név változtatás!";
        }
        else{
            print "foglalt";
        }
    }
    if(isset($_POST['ujemail']))
    {
        $ujemail=$_POST['ujemail'];
        if (filter_var($ujemail, FILTER_VALIDATE_EMAIL)) {
            $sql = "SELECT email FROM felhasznalo WHERE email=?";
            $stmt=$conn->prepare($sql);
            $stmt->bind_param("si", $ujemail, $_SESSION["id"]);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows<1) {
                $sql = "UPDATE felhasznalo SET email = ? WHERE id=?";
                $stmt=$conn->prepare($sql);
                $stmt->bind_param("si", $ujemail, $_SESSION["id"]);
                $stmt->execute();
                print "Sikeres név változtatás!";
            }
            else{
                print "foglalt";
            }
        }
        
    }