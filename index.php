<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gladiátor Aréna</title>
    <link rel="stylesheet" href="css/css.css">
    <link rel="stylesheet" href="css/style.css">
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
    
    $contentFile = "oldalak/" . ($pageData['content'] ?? 'fooldal');
    ?>
    
    <!-- Fejléc -->
    <header>
        <div class="logo">GLADIÁTOR ARÉNA</div>
        <nav>
            <ul>
                <li><a href="?page=Fooldal" class="fooldal">Kezdőlap</a></li>
                <li><a href="?page=Szobak" class="szobak">Szobák</a>
                <li><a href="?page=Profil" class="profils">Profilom</a></li>
                <li><a href="?page=Erdekesseg" class="erdekesseg">Erdekesseg</a></li>
                <li><a href="?page=Kilépés" class="kilepes">Kilépés</a></li>
            </ul>
            <div class="menu-icon" id="menuIcon"><i class="fas fa-bars"></i></div>
        </nav>
    </header>
    
 
    
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
    <script src="Javascripts/informaciok.js"></script>
    <script src="Javascripts/felhasznaloi.js"></script>
</body>
</html>