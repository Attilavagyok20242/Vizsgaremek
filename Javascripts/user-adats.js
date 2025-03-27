
document.addEventListener("DOMContentLoaded", function () {
    fetch("felhasznalo_belepve") 
        .then(response => response.json())
        .then(data => {
            if (data.loggedIn) {
                document.querySelector(".kilepes").style.display = "block";
                document.querySelector(".megerosites").style.display = "block";
                document.querySelector(".profils").style.display = "block";

                fetch("felhasznalo_kod") 
                    .then(response => response.json())
                    .then(data => {
                        if (data.megerosites==true) {
                                document.querySelector(".megerosites").style.display = "none";
                                document.querySelector(".element").style.display = "none"; 
                                document.querySelector(".szobak").style.display = "block";

                        }
                    })
                    .catch(error => console.error("Hiba történt:", error));
            } else {
                document.querySelector(".megerosites").style.display = "none";
           
            }
        })
        .catch(error => console.error("Hiba történt:", error));
});



 
 