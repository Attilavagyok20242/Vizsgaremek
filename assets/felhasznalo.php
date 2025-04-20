<?php
require "../connection/connection.php";
header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->begin_transaction();

    try {
        $tables = ['nev_elozmenyek', 'email_elozmenyek', 'jelszo_elozmenyek'];
        foreach ($tables as $table) {
            $stmt = $conn->prepare("DELETE FROM $table WHERE felhasznalo_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }

        $stmt = $conn->prepare("DELETE FROM felhasznalo WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        $conn->commit();
        echo json_encode(["status" => "success", "message" => "A felhasználó sikeresen törölve lett."]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => "Hiba történt: " . $e->getMessage()]);
    }

    $conn->close();
    exit;
}

$sql = "SELECT id, nev, email FROM felhasznalo";
$result = $conn->query($sql);

$users = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();
echo json_encode($users);
?>
