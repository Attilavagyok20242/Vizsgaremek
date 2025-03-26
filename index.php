<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gladiátor Aréna</title>
    <link rel="stylesheet" href="css/css.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <?php
    session_start();
    require_once "connection/connection.php";
    
    $page = isset($_GET['page']) ? $_GET['page'] : 'Fooldal';
    $stmt = $conn->prepare("SELECT content FROM pages WHERE title = ?");
    $stmt->bind_param("s", $page);
    $stmt->execute();
    $pageResult = $stmt->get_result();
    $pageData = $pageResult->fetch_assoc();
    
    $contentFile = "oldalak/" . ($pageData['content'] ?? 'fooldal.php');
    ?>
    
    <!-- Fejléc -->
    <header>
        <div class="logo">GLADIÁTOR ARÉNA</div>
        <nav>
            <ul>
                <li><a href="?page=Fooldal">Kezdőlap</a></li>
                <li><a href="?page=Harcosok">Harcosok</a></li>
                <li><a href="?page=Arena">Aréna</a></li>
                <li><a href="?page=Tortenelem">Történelem</a></li>
                <li><a href="?page=Kapcsolat">Kapcsolat</a></li>
            </ul>
            <div class="menu-icon" id="menuIcon"><i class="fas fa-bars"></i></div>
        </nav>
    </header>
    
    <!-- Hero Szakasz -->
    <section id="hero" class="hero">
        <h1>Honorért és Dicsőségért</h1>
        <p>Tapasztald meg az ókori gladiátorok legendás csatáit.</p>
        <a href="?page=Arena" class="btn" id="enterArena">Lépj be az Arénába</a>
    </section>
    
    <!-- Tartalom dinamikus betöltése -->
    <main class="content">
        <?php
        if (file_exists($contentFile)) {
            include($contentFile);
        } else {
            echo "<p>Ez a tartalom nem elérhető!</p>";
        }
        ?>
    </main>
    
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
    
    <!-- Lábléc -->
    <footer>
        <p>&copy; 2025 Gladiátor Aréna. Minden jog fenntartva.</p>
        <p>Email: gladiators@rome.com | Telefon: +123 456 789</p>
    </footer>
    
    <script src="Javascripts/js.js"></script>
    <script src="Javascripts/user-adats.js"></script>
</body>
</html>