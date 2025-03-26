<?php
$email=$_POST['email'];
$token=bin2hex(random_bytes(16));
$token_hash=hash('sha256',$token);
date("Y-m-d H:i:s",time()+60*30);
$mysql=require __DIR__ . '/connection.php';
$sql="UPDATE felhasznalo 
SET reset_token_hash=?,
    reset_token_expire_at=?
 WHERE email=?";
$stmt=$mysql->prepare($sql);
$stmt->bind_param('sss',$token_hash,date("Y-m-d H:i:s",time()+60*30),$email);
$stmt->execute();
$stmt->close();
$mysql->close();
//send email

?>