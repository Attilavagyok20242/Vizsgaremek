<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbadat="game";

$conn =  mysqli_connect($servername, $username, $password,$dbadat,3306);
if ($conn->connect_error) {
   die("Connection failed: " . $con->connect_error);
}
?>
