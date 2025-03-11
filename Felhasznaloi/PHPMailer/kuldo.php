<?php
use PHPMailer\PHPMailer\PHPMailer;
function VerificationSend(){

    //$email = $_POST['email'];

    require_once "PHPMailer/PHPMailer.php";
    require_once "PHPMailer/SMTP.php";
    require_once "PHPMailer/Exception.php";

    $mail = new PHPMailer();

    //SMTP Settings
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "";//ide jön a küldő Gmail cím
    $mail->Password = "";//jelszó
    $mail->Port = 465; //587
    $mail->SMTPSecure = "ssl"; //tls

$email='';//ide küldi az e-mail-t

//küldendő adatok
$targy="";
$oldal_cime="";
$tartalma="";


    //Email Settings
	//$mail->charSet = "UTF-8";
    $mail->isHTML(true);
    $mail->setFrom($email, $oldal_cime);
    //$mail->addAttachment('uploads/file.tar.gz'); //csatolmány küldése
    $mail->addAddress($email);

    $mail->Subject = $targy;
    $mail->Body =$tartalma;
    $mail->CharSet = 'UTF-8';  //karakterkódolás
    //$mail->send();
	if(!$mail->Send())
{
   echo "Hiba a levél küldésekor. Próbálja újra!";
   exit;
}

echo "Az üzenet sikeresen továbbítva.";
}
//levél küldése
VerificationSend();

       

?>