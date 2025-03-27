<?php require_once "../assets/bejelentkezes.php";?>
<?php require_once "../assets/register.php";?>

    <link rel="stylesheet" href="css/kappa.css">
    <div class="container">
        <div class="form-box login">
        <form action="" method="POST">
                <h1>Bejelentkezés</h1>
           
                <div class="input-box">
                    <input type="text" placeholder="Felhasználó név" name="Nevs"required>
                    <i class="bx bx-user"></i>                   
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Jelszó" name="Jelszos" required>
                       <i class="bx bx-lock-alt"></i> 
                </div>
                <div class="forgot-link">
                    <a href="forgot-password.php">Elfelejtetted a Jelszavad?</a>
                </div>
                <button type="submit" class="btn" >Bejelentkezés</button>
                <p>Egyéb bejelenkezési formák</p>
                    <div class="social-icons">
                        <a href="#"><i class="bx bxl-facebook"></i></a>
                        <a href="#"><i class="bx bxl-twitter"></i></a>
                        <a href="#"><i class="bx bxl-instagram"></i></a>
                        <a href="#"><i class="bx bxl-google"></i></a>
                    </div>
                
            </form>
        </div>
        <div class="form-box register">
            <form action="" method="POST" id="register">
                <h1>Regisztráció</h1>
                <div class="input-box">
                    <input type="text" placeholder="Felhasználó Név" name="Nev" required>
                    <i class="bx bx-user"></i>                   
                </div>
                <div class="input-box">
                    <input type="mail" placeholder="email" name="email" id="email" required>
                    <i class="bx bx-envelope"></i>               
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Jelszó" name="Jelszo"required>
                       <i class="bx bx-lock-alt"></i> 
                </div>
                <input type="submit" class="btn" onclick="atad()" placeholder="Regisztráció">
                <p>Egyéb regisztrácós formák</p>
                    <div class="social-icons">
                        <a href="#"><i class="bx bxl-facebook"></i></a>
                        <a href="#"><i class="bx bxl-twitter"></i></a>
                        <a href="#"><i class="bx bxl-instagram"></i></a>
                        <a href="#"><i class="bx bxl-google"></i></a>
                    </div>
            </form>
        </div>
            <div class="toggle-box">
                <div class="toggle-panel toggle-left">
                    <h1>Üdvözöllek</h1>
                    <p> Nincs fiókod? </p>
                    <button class="btn register-btn">
                         Regisztráció
                    </button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Köszöntünk ismét!</h1>
                    <p> Már van fiókód?</p>
                    <button class="btn login-btn">
                        Bejelenetkezés
                    </button>
                </div>
            </div>
    </div>
    <div id="ide"></div>
    <script src="Javascripts/script.js"></script>
