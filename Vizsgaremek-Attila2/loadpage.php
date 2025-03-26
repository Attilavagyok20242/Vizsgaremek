<?php
if (isset($_POST['file'])) {
    $file = basename($_POST['file']); // Alapfájlnév kiszűrése
    $path = "pages/" . $file; // Az oldalak a "pages" mappában legyenek

    if (file_exists($path)) {
        include $path;
    } else {
        echo "<p>Nincs ilyen oldal!</p>";
    }
} else {
    echo "<p>Hibás kérés!</p>";
}
?>

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
        <?php
        $menuItems = [
            ['file' => 'weblap.php', 'icon' => 'bx bx-home', 'title' => 'Kezdőlap'],
            ['file' => 'Administrator.php', 'icon' => 'bx bx-user', 'title' => 'Adminisztrátor'],
            ['file' => 'logreg.php', 'icon' => 'bx bx-log-in', 'title' => 'Bejelentkezés / Regisztráció'],
            ['file' => 'felhasznaloi.php', 'icon' => 'bx bx-id-card', 'title' => 'Felhasználói adatok'],
            ['file' => 'segitseg.php', 'icon' => 'bx bx-help-circle', 'title' => 'Segítség'],
            ['file' => 'kilepes.php', 'icon' => 'bx bx-exit', 'title' => 'Kilépés']
        ];
        foreach ($menuItems as $item): ?>
            <li>
                <a href="#" class="menu-link" data-file="<?= $item['file'] ?>">
                    <span class="icon">
                        <i class='<?= $item['icon'] ?>'></i>
                    </span>
                    <span class="title"><?= $item['title'] ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
