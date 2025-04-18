<?php
require "../connection/connection.php";

try {
    $query = "UPDATE jelentesek SET jovahagyva = 1 WHERE jovahagyva = 0 LIMIT 1";  
    $stmt = $conn->prepare($query);

    if ($stmt->execute()) {
        echo json_encode(["siker" => true]);  
    } else {
        echo json_encode(["siker" => false, "hiba" => "Nem sikerült a státusz módosítása."]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["siker" => false, "hiba" => "Hiba történt: " . $e->getMessage()]);
}
?>
