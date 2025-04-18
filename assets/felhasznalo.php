<?php
require "../connection/connection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM felhasznalo WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "A felhasználó sikeresen törölve lett.";
        } else {
            echo "Hiba történt a felhasználó törlésekor: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Hiba a lekérdezés előkészítésekor: " . $conn->error;
    }
    exit; 
}
$sql = "SELECT id, nev, email FROM felhasznalo";
$result = $conn->query($sql);
$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    echo "Nincsenek felhasználók az adatbázisban.";
}
$conn->close();
echo json_encode($users);
?>
