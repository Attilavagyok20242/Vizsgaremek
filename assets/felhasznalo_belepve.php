<?php
header('Content-Type: application/json');
session_start();
$response = ["loggedIn" => false];
if (isset($_SESSION['userLoggedIN']) && $_SESSION['userLoggedIN'] === true) {
    $response["loggedIn"] = true;
    $response["username"] = $_SESSION['nev'] ?? "Ismeretlen";
}
echo json_encode($response);
exit;
