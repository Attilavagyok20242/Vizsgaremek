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

            if (password_verify($jelszo, $user['jelszo'])) {
                return 200;
            }
            return 403; 
        } else {
            return 404; 
        }
    }

    return 400; 
}
