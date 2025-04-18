<?php
// Adatbázis kapcsolat beállítása
$servername = "localhost";
$username = "root";  // Az adatbázis felhasználó neve
$password = "";      // Az adatbázis jelszava
$dbname = "game"; // Az adatbázis neve

// Kapcsolódás az adatbázishoz
$conn = new mysqli($servername, $username, $password, $dbname);

// Ellenőrizzük, hogy a kapcsolat sikerült-e
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Ha az id paraméter meg van adva (törlés)
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Az SQL lekérdezés a felhasználó törlésére
    $sql = "DELETE FROM felhasznalo WHERE id = ?";

    // A lekérdezés előkészítése
    if ($stmt = $conn->prepare($sql)) {
        // Paraméter bindolása (id)
        $stmt->bind_param("i", $id);

        // A lekérdezés végrehajtása
        if ($stmt->execute()) {
            echo "A felhasználó sikeresen törölve lett.";
        } else {
            echo "Hiba történt a felhasználó törlésekor: " . $stmt->error;
        }

        // A lekérdezés lezárása
        $stmt->close();
    } else {
        echo "Hiba a lekérdezés előkészítésekor: " . $conn->error;
    }
    exit; // Fontos, hogy kilépjünk, ne folytassuk a felhasználók listázását, ha törlés történik
}

// A felhasználók listázása
$sql = "SELECT id, nev, email FROM felhasznalo";
$result = $conn->query($sql);

$users = [];

if ($result->num_rows > 0) {
    // Felhasználók listázása
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    echo "Nincsenek felhasználók az adatbázisban.";
}

// Kapcsolat lezárása
$conn->close();

// Visszaküldjük a felhasználókat JSON formátumban
echo json_encode($users);
?>
