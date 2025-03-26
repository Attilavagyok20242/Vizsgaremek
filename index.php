<?php
session_start();
require_once "connection/connection.php";

// Alapértelmezett oldal beállítása és SQL Injection elleni védelem
$page = isset($_GET['page']) ? $_GET['page'] : 'Fooldal';

$stmt = $conn->prepare("SELECT content FROM pages WHERE title = ?");
$stmt->bind_param("s", $page);
$stmt->execute();
$pageResult = $stmt->get_result();
$pageData = $pageResult->fetch_assoc();

// Ha nincs találat, alapértelmezett fájlt használunk
$contentFile = "oldalak/" . ($pageData['content'] ?? 'default.php');

// Menü lekérdezése
$menuQuery = "SELECT * FROM menu";
$menuResult = $conn->query($menuQuery);
?>
<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageData['title'] ?? 'Oldal nem található') ?></title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="css/weblapstilus.css">
  <link rel="stylesheet" href="css/first imageresz.css">
  <link rel="stylesheet" href="css/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
  <div class="container">
    <div class="navigation">
      <ul>
        <li>
          <a href="#">
            <div class="logo">
              <img src="kepek/g.png" alt="Arena Klub Logo">
            </div>
            <span class="title">Arena Klub</span>
          </a>
        </li>
        <?php if ($menuResult->num_rows > 0): ?>
          <?php while ($menu = $menuResult->fetch_assoc()): ?>
            <li>
              <a href="?page=<?= htmlspecialchars($menu['slug']) ?>">
                <span class="icon"><i class='bx bx-book'></i></span>
                <span class="title"><?= htmlspecialchars($menu['name']) ?></span>
              </a>
            </li>
          <?php endwhile; ?>
        <?php else: ?>
          <li><a href="#"><span class="title">Nincs elérhető menü</span></a></li>
        <?php endif; ?>
      </ul>
    </div>
    <div class="main">
      <div class="topbar">
        <div class="toggle">
          <i class='bx bx-menu'></i>
        </div>
        <div class="user">
          <img src="kepek/g.png" alt="Felhasználói kép">
        </div>
      </div>
      <div class="smooth-scroll">
        <div class="wrapper">
          <main class="page">
            <div class="page__content">
              <?php
              if (file_exists($contentFile)) {
                  include($contentFile);
              } else {
                  echo "<p>Ez a tartalom nem elérhető!</p>";
              }
              ?>
            </div>
          </main>
        </div>
      </div>
    </div>
  </div>

  <?php if (!isset($_SESSION['id'])): ?>
    <div class="element">
      <div class="bejelentkezes">
        Kedves felhasználó, nem jelentkeztél be. Ahhoz, hogy további tartalmat érj el:
        <div class="bejelentkezes_szoveg2">
          <a href="/login" class="megerosites-gomb">Jelentkezz be!</a>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <?php if (isset($_SESSION['id'])): ?>
    <div class="megerosites">
      <div class="bejelentkezes">
        Kedves felhasználó, nem erősítetted meg a fiókodat. Ahhoz, hogy további tartalmat érj el:
        <div class="bejelentkezes_szoveg2">
          <a href="/Felhasznalomegerosites" class="megerosites-gomb">Megerősítem!</a>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <button id="helpButton">Segítség</button>
  <div id="helpContent"></div>

  <script src="Javascripts/user-adats.js"></script>
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
      list.forEach((item) => item.classList.remove('hovered'));
      this.classList.add('hovered');
    }

    list.forEach((item) => item.addEventListener('mouseover', activeLink));
  </script>
</body>
</html>
