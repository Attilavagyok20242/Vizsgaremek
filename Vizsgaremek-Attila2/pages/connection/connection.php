<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbadat="game";

$con =  mysqli_connect($servername, $username, $password,$dbadat,3306);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
