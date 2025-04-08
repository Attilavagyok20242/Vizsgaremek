<?php
function FelhasznaloNevJelszo($nev, $jelszo)
{
    require "./connection/connection.php";

    if ($nev && $jelszo) {
        $stmt = $conn->prepare("SELECT id, nev, jelszo, email, kod, Szerep, elrontott_bejelenkezes FROM felhasznalo WHERE nev = ?");
        $stmt->bind_param("s", $nev);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Ha a jelszó hash-elve van:
            if (password_verify($jelszo, $user['jelszo'])) {
                return 200;
            }

            // Ha nincs hashelve, sima összehasonlítás:
            if ($jelszo === $user['jelszo']) {
                return 200;
            }

            return 403; // jelszóhiba
        } else {
            return 404; // felhasználó nem található
        }
    }

    return 400; // ha nincs adat megadva
}
