<?php
 include 'connection/connection.php';
session_start();
$id=0;
$nev="";
$jelszo="";
if(isset($_SESSION['id']))
{
   $id=$_SESSION['id'];
 
   $query = "UPDATE felhasznalo SET aktív = false WHERE id = " . $_SESSION['id'];
   mysqli_query($con, $query);
   session_destroy();
}
header('Location: http://localhost/vizsgaremek-attila/asd/index.php'); 
?>