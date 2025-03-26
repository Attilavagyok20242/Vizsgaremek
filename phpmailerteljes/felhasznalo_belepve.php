<?php
//felhasznalo ellenörzés, hogy belépett-e
session_start();
header('Content-Type: application/json');
$response = ["loggedIn" => false];
if (isset($_SESSION['userLoggedIN']) && $_SESSION['userLoggedIN'] === true) {
    $response["loggedIn"] = true;
    $response["username"] = $_SESSION['nev'] ?? "Ismeretlen";
}
echo json_encode($response);
exit;
