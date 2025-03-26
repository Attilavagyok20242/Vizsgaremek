<?php 
include("connection/connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['megerosites'])) {
        $megerosites = $con->real_escape_string($_POST['megerosites']);

        // Prepare the SQL statement
        $sql = "UPDATE felhasznalo SET megerositve=true WHERE kod='$megerosites'";
        $result = $con->query($sql);

        if ($result) {
            echo "Sikeres megerősítés";
            header("Location: http://localhost/vizsgaremek-Attila/Fooldal/weblap.php");
            exit;
        } else {
            echo "Sikertelen megerősítés: " . $con->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Felhasználó Megerősítés</title>
</head>
<body>
<button class="megerosites" onclick="megerosites()">Felhaszalo megerősítő kód kérése</button>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="number" name="megerosites" required>
    <button type="submit">Küldés</button>
</form>

<script src="../Fooldal/Javascripts/felhasznaloi.js"></script>    

</body>
</html>
