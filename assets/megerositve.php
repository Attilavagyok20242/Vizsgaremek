<?php
require "../connection/connection.php";
session_start();
$result=$conn->query("SELECT megerositve FROM felhasznalo WHERE id=".$_SESSION['id']);
$megerositve=$result->fetch_assoc();
print($megerositve["megerositve"]);