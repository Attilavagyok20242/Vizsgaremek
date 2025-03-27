<?php
require_once("connection/connection.php");
if(isset($_SESSION['id'])){
    $userId = $_SESSION['id']; 
    $sql = mysqli_query($conn, "UPDATE felhasznalo SET aktív='false' WHERE  id=$userId");
}
session_unset(); 
session_destroy(); 
header("location: /"); 
?>
