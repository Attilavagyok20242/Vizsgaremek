<?php
require_once("../connection/connection.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nev = filter_input(INPUT_POST, 'Nevs', FILTER_SANITIZE_STRING);
    $jelszo = $_POST['Jelszos'] ?? '';

    if ($nev && $jelszo) {
        $stmt = $conn->prepare("SELECT id, nev, jelszo, email, kod, Szerep, elrontott_bejelenkezes FROM felhasznalo WHERE nev = ?");
        $stmt->bind_param("s", $nev);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $failedAttempts = $row['elrontott_bejelenkezes'];

            if ($failedAttempts >= 5) {
                echo "<script>alert('Túl sok sikertelen próbálkozás! Próbáld újra később.');</script>";

            }
            if (password_verify($jelszo, $row['jelszo'])) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['nev'] = $row['nev'];
                $_SESSION['email'] = $row['email'] ?? null;
                $_SESSION['kod'] = $row['kod'] ?? null;
                $_SESSION['userLoggedIN'] = true;

                $update = $conn->prepare("UPDATE felhasznalo SET elrontott_bejelenkezes = 0, aktív = 1 WHERE id = ?");
                $update->bind_param("i", $row['id']);
                $update->execute();

                if ($row['Szerep'] == 1) {
                    header("Location: /admin");
                } else {
                    header('Location: /');
                }
                exit();
            } else {
                $failedAttempts++;
                $updateStmt = $conn->prepare("UPDATE felhasznalo SET elrontott_bejelenkezes = ? WHERE id = ?");
                $updateStmt->bind_param("ii", $failedAttempts, $row['id']);
                $updateStmt->execute();
                $updateStmt->close();

                echo "<script>alert('Hibás jelszó! Próbáld újra.');</script>";
            }
        } else {
            echo "<script>alert('Nem található ilyen felhasználó!');</script>";
        }
    }
} else {
    echo "<script>Bejelentkezes()</script>";
}
?>
