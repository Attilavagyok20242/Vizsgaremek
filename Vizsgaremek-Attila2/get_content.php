<?php
session_start();

// Adatbázis kapcsolat
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "game";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Menüpontok lekérdezése az adatbázisból
$sql = "SELECT id, title, file FROM menu";
$result = $conn->query($sql);
$menuItems = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $menuItems[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dinamikus Weboldal</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <nav>
        <ul>
            <?php foreach ($menuItems as $item): ?>
                <li><a href="#" class="menu-link" data-file="<?= $item['file'] ?>"><?= $item['title'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <div id="content">
        <?php include 'weblap.php'; ?>
    </div>
    
    <script>
        $(document).ready(function () {
            $(".menu-link").click(function (e) {
                e.preventDefault();
                var file = $(this).data("file");
                
                $.ajax({
                    url: "load_page.php",
                    type: "POST",
                    data: { file: file },
                    success: function (response) {
                        $("#content").html(response);
                    }
                });
            });
        });
    </script>
</body>
</html>
