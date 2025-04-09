<?php 
include("../connection/connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['megerosites'])) {
        $megerosites = $conn->real_escape_string($_POST['megerosites']);
        $sql = "UPDATE felhasznalo SET megerositve=true WHERE kod=$megerosites";
        $result = $conn->query($sql);
        if ($result) {
            echo "Sikeres megerősítés";
            header("Location: /");
            exit;
        } else {
            echo "Sikertelen megerősítés: " . $conn->error;
        }
    }
}
?>

    <title>Felhasználó Megerősítés</title>
<button class="megerosites" onclick="megerosites()">Felhaszalo megerősítő kód kérése</button>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="number" name="megerosites" required>
    <button type="submit">Küldés</button>
</form>
<script src="Javascripts/felhasznaloi.js"></script>    
