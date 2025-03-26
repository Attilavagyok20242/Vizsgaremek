$(document).ready(function () {
    $(".user").click('unload', function () {
        window.location="felhasznaloi.php";
    });
    $("#vissza").click('unload', function () {
        window.location="weblap.php";
    });
    $(".Erdekesseg").click('unload', function () {
        window.location="gladiatorinformaciok.php";
    });
    $("#Szia").click('unload', function () {
        window.location="weblap.php";
    });
    $(".gombok").click('unload', function () {
        window.location="https://hu.wikipedia.org/wiki/Gladiátor_(harcos)";
    });
    $(".szoba").click('unload', function () {
        window.location="http://localhost:3500";
    });
    $(".segitseg").click('unload',function () { 
        window.location="index.php";
    });
    $("#adminszoba").click(function (e) { 
      $( "#szoba" ).load( "index.php" );        
    });
});
document.addEventListener("DOMContentLoaded", function () {
    fetch("felhasznalo_belepve.php") 
        .then(response => response.json())
        .then(data => {
            if (data.loggedIn) {
                document.querySelector(".megerosites").style.display = "block";

                fetch("felhasznalo_kod.php") 
                    .then(response => response.json())
                    .then(data => {
                        if (data.megerosites==true) {
                            document.querySelector(".megerosites").style.display = "none";

                                document.querySelector(".element").style.display = "none"; 
                        }
                    })
                    .catch(error => console.error("Hiba történt:", error));
            } else {
                document.querySelector(".megerosites").style.display = "none";
            }
        })
        .catch(error => console.error("Hiba történt:", error));
});



    document.getElementById('helpButton').addEventListener('click', function(event) {
        // Segítség div megjelenítése
        var helpContent = document.getElementById('helpContent');
        if (helpContent.style.display === 'block') {
            helpContent.style.display = 'none';  // Ha már látszik, akkor elrejtjük
        } else {
            helpContent.style.display = 'block';  // Máskülönben megjelenítjük
                
            
            // Betöltjük a másik oldal tartalmát
    fetch('index.php')  // Cseréld ki a kívánt oldal URL-jére
    .then(response => response.text())
    .then(data => {
        const helpContent = document.getElementById('helpContent');
        helpContent.innerHTML = data;  // Betöltjük a tartalmat

        // Keressük meg és futtassuk az inline <script> kódokat
        const scripts = helpContent.querySelectorAll('script');
        scripts.forEach(script => {
            const newScript = document.createElement('script');
            if (script.src) {
                // Ha a script src attribútummal rendelkezik (külső fájl), töltsük be
                newScript.src = script.src;
                newScript.async = false; // Sorrendben hajtsa végre a szkripteket
            } else {
                // Ha inline script, akkor másoljuk a kódját
                newScript.textContent = script.textContent;
            }
            document.body.appendChild(newScript); // Futtassuk a szkriptet
        });
    })
    .catch(error => console.error('Hiba a tartalom betöltésekor:', error));
        
        }
    });
        



 
 