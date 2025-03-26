<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbadat = "game";

$conn = mysqli_connect($servername, $username, $password, $dbadat, 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$menuQuery = "SELECT * FROM menu";
$menuResult = $conn->query($menuQuery);

$page = isset($_GET['page']) ? $_GET['page'] : 'home'; 
$pageQuery = "SELECT * FROM pages WHERE slug='$page'";
$pageResult = $conn->query($pageQuery);
$pageData = $pageResult->fetch_assoc();

$contentFile = isset($pageData['content']) ? 'content/' . $pageData['content'] : 'content/404_content.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageData['title'] ?? 'Oldal nem található') ?></title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="weblapstilus.css">
  <link rel="stylesheet" href="first imageresz.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
  <div class="container">
    <div class="navigation">
      <ul>
        <li>
          <a href="#">
            <div class="logo">
              <img src="kepek/g.png" alt="">
            </div>
            <span class="title">Arena Klub</span>
          </a>
        </li>
        <?php while ($menu = $menuResult->fetch_assoc()): ?>
        <li>
          <a href="?page=<?= htmlspecialchars($menu['slug']) ?>">
            <span class="icon">
              <i class='bx bx-book'></i>
            </span>
            <span class="title"><?= htmlspecialchars($menu['name']) ?></span>
          </a>
        </li>
        <?php endwhile; ?>
      </ul>
    </div>

    <div class="main">
      <div class="topbar">
        <div class="toggle">
          <i class='bx bx-menu'></i>
        </div>
        <div class="user">
          <img src="kepek/g.png" alt="">
        </div>
      </div>
      <div class="smooth-scroll">
        <div class="wrapper">
          <main class="page">
            <section class="banner-big">
              <div class="banner-big__bg"></div>
            </section>
            <div class="page__content">
              <h2 style="text-transform: none;"> <?= htmlspecialchars($pageData['title'] ?? '404 - Oldal nem található') ?> </h2>
              <p style="font-size: 18px">
                <?php
                if (file_exists($contentFile)) {
                    include($contentFile);
                } else {
                    echo "Content file not found!";
                }
                ?>
              </p>
            </div>
          </main>
        </div>
      </div>
    </div>
  </div>

  <?php if (!isset($_SESSION['user_id'])): ?>
    <div class="bejelentkezes">
      <p>Kedves felhasználó, nem jelentkeztél be, ahhoz, hogy további tartalmat érj el:</p>
      <div class="bejelentkezes_szoveg2">
        <a href="../asd/index.php" class="megerosites-gomb">Jelenkezz be!</a>
      </div>
    </div>
  <?php endif; ?>

  <?php if (isset($_SESSION['user_id']) && !isset($_SESSION['confirmed'])): ?>
    <div class="megerosites">
      <div class="bejelentkezes">
        <p>Kedves felhasználó, nem erősítetted meg a fiókodat, hogy további tartalmat érj el:</p>
        <div class="bejelentkezes_szoveg2">
          <a href="../asd/Felhasznalomegerosites.php" class="megerosites-gomb">Megerősítem!</a>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <button id="helpButton">Segítség</button>
  <div id="helpContent"></div>
<script src="user-adats.js"></script>
  <script>
    let toggle = document.querySelector('.toggle');
    let navigation = document.querySelector('.navigation');
    let main = document.querySelector('.main');
    toggle.onclick = function() {
      navigation.classList.toggle('active');
      main.classList.toggle('active');
    }

    let list = document.querySelectorAll('.navigation li');
    function activeLink() {
      list.forEach((items) => items.classList.remove('hovered'));
      this.classList.add('hovered');
    }
    list.forEach((item) => item.addEventListener('mouseover', activeLink));
  </script>
</body>
</html>
