<?php
session_start();
require_once("../connection/connection.php");
if (isset($_SESSION["id"])) {
    if (isset($_POST['szoveg'])) {
        $szoveg=$_POST['szoveg'];
        $sql="INSERT INTO kommentek (szoveg,datum,felhasznalo_id,hir_id) VALUES (?,NOW(),?,?)";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param('sii',$szoveg,$_SESSION['id'],$_SESSION['hirid']);
        $stmt->execute();
        $stmt->close();
    }
}