<?php
session_start();
require_once("connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nev = filter_input(INPUT_POST, 'Nevs', FILTER_SANITIZE_STRING);
    $jelszo = $_POST['Jelszos'] ?? '';

    if ($nev && $jelszo) {
        $stmt = $con->prepare("SELECT id, nev, jelszo, email, kod, Szerep, elrontott_bejelenkezes FROM felhasznalo WHERE nev = ?");
        $stmt->bind_param("s", $nev);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $failedAttempts = $row['elrontott_bejelenkezes'];

            // Túl sok sikertelen próbálkozás ellenőrzése
            if ($failedAttempts >= 5) {
                echo "<script>alert('Túl sok sikertelen próbálkozás! Próbáld újra később.');</script>";
                exit();
            }

            // Jelszó ellenőrzése
            if (password_verify($jelszo, $row['jelszo'])) {
                // Felhasználói adatok tárolása sessionben
                $_SESSION['email'] = $row['email'] ?? null;
                $_SESSION['kod'] = $row['kod'] ?? null;
                $_SESSION['userLoggedIN'] = true;
                $_SESSION['nev'] = $row['nev'];
                if($_SESSION['nev']=$row['nev'])
                {
                $_SESSION['id'] = $row['id'];
                }

                // Sikertelen bejelentkezések számlálójának visszaállítása
                $update = $con->prepare("UPDATE felhasznalo SET elrontott_bejelenkezes = 0, aktív = 1 WHERE id = ?");
                $update->bind_param("i", $row['id']);
                $update->execute();

                // Szerep alapú átirányítás
                if ($row['Szerep'] == 1) {
                    header("Location: http://localhost/vizsgaremek-attila/Administrator/index.php");
                } else if($row['Szerep']==0){
                    header("Location: http://localhost/vizsgaremek-Attila/Fooldal/weblap.php");
                }
                exit();
            } else {
                // Hibás jelszó - sikertelen próbálkozások növelése
                $failedAttempts++;
                $updateStmt = $con->prepare("UPDATE felhasznalo SET elrontott_bejelenkezes = ? WHERE id = ?");
                $updateStmt->bind_param("ii", $failedAttempts, $row['id']);
                $updateStmt->execute();

                echo "<script>alert('Hibás jelszó! Próbáld újra.');</script>";
            }
        } else {
            echo "<script>alert('Nem található ilyen felhasználó!');</script>";
        }
    } else {
        echo "<script>alert('Hiányzó adat!');</script>";
    }
} else {
    echo "<script>Bejelentkezes();</script>";
}
?>
