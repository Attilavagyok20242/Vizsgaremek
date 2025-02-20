<?php
require("../Kapcsolat.php");
if (isset($_POST["komment"])) {
    $komment=$_POST["komment"];
    if ($komment!="") {
        $sql="INSERT INTO kommentek(Szoveg,Datum) VALUES('$komment',NOW())";
        if($con->query($sql)===TRUE){
            
            echo ("Sikeres posztolás!");
            header('Refresh: 1; url=News.php');
        }
        else{
            echo "Hiba:".$sql."<br>". $con->error;
        }
    }
    else{
        header('Refresh: 1; url=News.php');
    }
    
    
}
else{
    header('Refresh: 1; url=News.php');
}
    
    


