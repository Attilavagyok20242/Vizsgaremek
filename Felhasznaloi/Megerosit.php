<?php
use PHPMailer\PHPMailer\PHPMailer;

require_once "../connection.php";
require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Username = "arenaklub001@gmail.com";
$mail->Password = "lrbx hdvw vctd dwvv";
$mail->Port = 465; 
$mail->SMTPSecure = "ssl"; 

$email=$_POST["email"];
$sql="SELECT kod FROM felhasznalo WHERE email='$email'";
$result=$con->query($sql);
while ($row=$result->fetch_assoc()) {
    $kod=$row['kod'];
}

$targy="E-mail megerősítés";
$oldal_cime="E-mail PHP-ból";
$tartalma="A megerősítő kódód: ".$kod;
       
$mail->isHTML(true);
$mail->setFrom($email, $oldal_cime);
$mail->addAddress($email);

$mail->Subject = $targy;
$mail->Body =$tartalma;
$mail->CharSet = 'UTF-8';
$mail->Send();

print "Az e-mailt sikeresen elküldtük.";
?>
