<?php
require_once("connection/connection.php");
session_start();
$userId = $_SESSION['id']; 
$sql = mysqli_query($con, "SELECT aktív FROM felhasznalo WHERE Aktív=true AND id=$userId");
if (mysqli_num_rows($sql) > 0) {
    session_unset(); 
    session_destroy(); 
    header("Location: http://localhost/vizsgaremek-attila/asd/index.php"); 
    exit(); 
} else {
    echo "A felhaznalo nincs bejelentkezve.";
}
?>
