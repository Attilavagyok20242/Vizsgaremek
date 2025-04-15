<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once "../connection/connection.php";
require_once "../PHPMailer/PHPMailer.php";
require_once "../PHPMailer/SMTP.php";
require_once "../PHPMailer/Exception.php";

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Username = "arenaklub001@gmail.com"; // Use a valid Gmail address
$mail->Password = "lrbxhdvwvctddwvv";    // Use an App Password (DO NOT use your real password)
$mail->Port = 465;
$mail->SMTPSecure = "ssl";

$email=$_SESSION['email'];
$kod=$_SESSION['kod'];
// Validate email format
// Email content
$subject = "Arena Klub megerősítő kód";
$fromName = "Arena Klub";
$body = "Köszönjük, hogy regisztrált az oldalunkra! Kód: " . htmlspecialchars($kod, ENT_QUOTES, 'UTF-8');

$mail->isHTML(true);
$mail->setFrom("arenaklub001@gmail.com", $fromName);
$mail->addAddress($email);
$mail->Subject = $subject;
$mail->Body = $body;
$mail->CharSet = 'UTF-8';

if (!$mail->send()) {
    echo "Hiba a levél küldésekor: " . $mail->ErrorInfo;
} else {
    echo "Az üzenet sikeresen továbbítva.";
}
?>
