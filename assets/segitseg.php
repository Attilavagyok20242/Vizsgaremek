<?php
include 'connection/connection.php';
header('Content-Type: application/json;charset=UTF-8');
$sql = "SELECT * FROM segitseg";
    $tomb=array();
    $result=$con->query($sql);
    while($row=$result->fetch_assoc())
    {
        $tomb[]=$row;
    }
    $json=json_encode($tomb,JSON_UNESCAPED_UNICODE);
    print($json);
?>