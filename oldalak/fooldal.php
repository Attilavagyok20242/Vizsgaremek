
<body>
<?php
print("<script>console.log(ez:".$_SESSION['Szerep'].")</script>")
?>
   <!-- Hero Szakasz -->
   <section id="hero" class="hero">
        <h1>Becsületért és Dicsőségért</h1>
        <p>Lépj be egy világba ahol dicsőséget szerezhetsz.</p>
        <a href="" class="btn" id="enterArena">Lépj be az Arénába</a>
    </section>    
    <!-- Harcos Szakasz -->
    <section id="warriors" class="warrior-section">
        <h2>Legendás Harcosok</h2>
        <div class="warrior-gallery">
            <div class="warrior"><img src="kepek/you may live __].jpg" alt="Harcos 1"></div>
            <div class="warrior"><img src="kepek/max.jpg" alt="Harcos 2"></div>
            <div class="warrior"><img src="kepek/Spartan warrior.jpg" alt="Harcos 3"></div>
        </div>
    </section>
    <!-- Gladiátorok Legendája Szakasz -->
    <section id="legendary-warriors" class="legendary-warriors">
        <h2>Legendás Harcosok Története</h2>
        <div class="warrior-info" id="warrior1" style=" background-image: url('kepek/max.jpg');">
            <h3>Maximus</h3>
            <p>Maximus Decimus Meridius, a hűséges római tábornok, aki gladiátor lett családja meggyilkolása után, és visszavágott a császárnak.</p>
        </div>
        <div class="warrior-info" id="warrior2" style="background-image: url('kepek/you may live __].jpg');">
            <h3>Commodus</h3>
            <p>Commodus, a római császár, aki gladiátorként harcolt saját dicsősége érdekében, miközben elhanyagolta birodalma vezetését.</p>
        </div>
        <div class="warrior-info" id="warrior3" style="background-image: url('kepek/Spartan warrior.jpg');">
            <h3>Spartacus</h3>
            <p>Spartacus, a gladiátor és rabszolgafelkelő, aki vezetésével megszervezte a leghíresebb római lázadásokat a szabadságért.</p>
        </div>
    </section>

    <!-- Videó Szakasz -->
    <section id="warrior-video" class="video-section">
        <h2>Gladiátorok Akcióban</h2>
        <div class="video-container">
            <video id="myVideo" class="video-effect" width="800" controls>
                <source src="Gladiatorsképek/videoplayback.mp4" type="video/mp4">
                A böngésződ nem támogatja a videólejátszót.
            </video>
            <div class="play-button" id="playButton">
            <i class="fa-solid fa-play"></i>
            </div>
        </div>
        <div class="video-caption">
            <p>Tanúja lehetsz a végső csatának a dicsőségért és a tisztességért!</p>
        </div>
    </section>

    <!-- Lábléc Szakasz -->
    <footer class="footer">
        <div class="footer-content">
            <p>© 2025 Gladiátor UI. Minden jog fenntartva.</p>
            <div class="contact-info">
                <p><strong>Kapcsolat:</strong></p>
                <p>Email: arenaklub001@gmail.com</p>
                <p>Telefon: +30 513 6408</p>
            </div>
            <div class="social-links">
                <a href="#" class="social-icon">Facebook</a>
                <a href="#" class="social-icon">Twitter</a>
                <a href="#" class="social-icon">Instagram</a>
            </div>
        </div>
    </footer>
    <script src="js.js"></script>
</body>
