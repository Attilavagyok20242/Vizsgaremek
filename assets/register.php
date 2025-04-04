<?php
require_once("../connection/connection.php");
if (isset($_POST['Nev'], $_POST['Jelszo'], $_POST['email'])) {
    $nev = mysqli_real_escape_string($conn, $_POST['Nev']);
    $jelszo = mysqli_real_escape_string($conn, $_POST['Jelszo']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Email formátum ellenőrzés
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Érvénytelen email formátum!');</script>";
        exit();
    }

    $stmt = $conn->prepare("SELECT email, nev FROM felhasznalo WHERE email = ? OR nev = ?");
    $stmt->bind_param("ss", $email, $nev);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($existingEmail, $existingNev);
        $stmt->fetch();
        
        if ($email === $existingEmail) {
            echo "<script>alert('Ez az email már foglalt!');</script>";
        } elseif ($nev === $existingNev) {
            echo "<script>alert('Ez a felhasználónév már foglalt!');</script>";
        }
        exit();
    }

    // Jelszó titkosítása
    $hashedPassword = password_hash($jelszo, PASSWORD_DEFAULT);
    $mysqltime = date('Y-m-d H:i:s');
    $rnd = rand(1000, 9999);  // Generálunk egy véletlenszámot a "kod" mezőhöz

    // Helyes INSERT paranccsal való beszúrás
    $stmt = $conn->prepare("INSERT INTO felhasznalo (nev, jelszo, email, aktív, Szerep, megerositve, kod, datum, utolso_bejelentkezes, utoljara_hasznalt_ip, elrontott_bejelenkezes) 
                           VALUES (?, ?, ?, 1, 0, 0, ?, ?, NULL, NULL, 0)");
    $stmt->bind_param("sssis", $nev, $hashedPassword, $email, $rnd, $mysqltime);

    if ($stmt->execute()) {
        echo "<script>alert('Sikeres regisztráció!');</script>";
        header('Location: /login');
        exit();
    } else {
        echo "<script>alert('Hiba történt a regisztráció során!');</script>";
    }

    $stmt->close();
}
?>
