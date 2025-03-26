<?php
session_start(); // Start session to manage user information

$host = "localhost";
$username = "root";
$password = "";
$dbname = "game";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set proper character encoding
$conn->set_charset("utf8mb4");

// Handle incoming requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Insert message into the database
    if (isset($_POST['room'], $_POST['text'])) {
        $room = htmlspecialchars($_POST['room'], ENT_QUOTES, 'UTF-8');
        $text = htmlspecialchars($_POST['text'], ENT_QUOTES, 'UTF-8');
        $name = isset($_SESSION['nev']) ? $_SESSION['nev'] : 'Guest';
        $role = isset($_SESSION['role']) ? (int)$_SESSION['role'] : 0; // Default to "User"
        $time = date('Y-m-d H:i:s');

        $sql = "INSERT INTO messages (room, name, text, date, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssi", $room, $name, $text, $time, $role);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to insert message']);
            }
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to prepare SQL statement']);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch messages for a specific room
    if (isset($_GET['room'])) {
        $room = htmlspecialchars($_GET['room'], ENT_QUOTES, 'UTF-8');

        $sql = "SELECT * FROM messages WHERE room = ? ORDER BY date ASC";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $room);
            $stmt->execute();

            $result = $stmt->get_result();
            $messages = [];
            while ($row = $result->fetch_assoc()) {
                // Add "(admin)" if the role is admin
                if ($row['role'] == 1) {
                    $row['name'] .= " (admin)";
                }
                $messages[] = $row;
            }

            echo json_encode($messages, JSON_UNESCAPED_UNICODE);
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to fetch messages']);
        }
    }
}

// Close the database connection
$conn->close();
?>
