
document.addEventListener("DOMContentLoaded", function () {
    fetch("felhasznalo_belepve") 
        .then(response => response.json())
        .then(data => {
            if (data.loggedIn) {
                document.querySelector(".kilepes").style.display = "block";
                document.querySelector(".megerosites").style.display = "block";
                document.querySelector(".profils").style.display = "block";
                document.querySelector(".szobak").style.display = "block";


                fetch("felhasznalo_kod") 
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
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

document.addEventListener("DOMContentLoaded", function () {
    const kuldesGomb = document.getElementById("cseveges-kuldes"); // Csevegés küldés gomb
    const uzenetBevitel = document.getElementById("cseveges-bevitel"); // Üzenet beírása
    const uzenetDoboz = document.getElementById("cseveges-uzenetek"); // Üzenetek doboza
    const csevegesKapcsolo = document.getElementById("cseveges-kapcsolo"); // Csevegés ikon
    const csevegesDoboz = document.getElementById("cseveges-doboz"); // Csevegés panel
    const csevegesBezaras = document.getElementById("cseveges-bezar"); // Csevegés bezárás gomb
    let csevegesNyitva = false; // Állapot jelző, hogy a csevegés panel nyitva van-e

    uzenetDoboz.innerHTML = "";

    // Üzenetek betöltése
    function uzenetekBetoltese() {
        fetch("assets/uzenet_betolto.php")
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                uzenetDoboz.innerHTML = "";

                data.forEach((uzenet) => {
                    const uzenetElem = document.createElement("div");
                    uzenetElem.classList.add("cseveges-uzenet");
                    uzenetElem.innerHTML = `<strong>${uzenet.felhasznalo}:</strong> ${uzenet.szoveg} <small>${uzenet.letrehozva}</small>`;
                    uzenetDoboz.appendChild(uzenetElem);
                });

                // Görgetés a legújabb üzenetre
                uzenetDoboz.scrollTop = uzenetDoboz.scrollHeight;
            })
            .catch((err) => {
                console.error("Hiba történt az üzenetek betöltésekor:", err);
                alert("Hiba történt az üzenetek betöltésekor!");
            });
    }

    // A csevegés panel megnyitása és bezárása
    csevegesKapcsolo.addEventListener("click", function () {
        if (!csevegesNyitva) {
            csevegesDoboz.style.display = "block"; 
            uzenetekBetoltese(); 
            csevegesNyitva = true; 
        } else {
            csevegesDoboz.style.display = "none"; 
            csevegesNyitva = false; 
        }
    });

    // A csevegés panel bezárása
    csevegesBezaras.addEventListener("click", function () {
        csevegesDoboz.style.display = "none"; 
        csevegesNyitva = false; 
    });

    // Üzenet küldése
    kuldesGomb.addEventListener("click", function () {
        const uzenet = uzenetBevitel.value.trim();
        if (uzenet === "") return; 

        const formData = new FormData();
        formData.append("uzenet", uzenet);

        fetch("assets/Uzenet_Mentes.php", {
            method: "POST",
            body: formData,
        })
        .then((res) => res.json())
        .then((res) => {
            if (res.siker) {
                uzenetBevitel.value = ""; 
                uzenetekBetoltese();
            } else {
                alert("Hiba történt az üzenet küldésekor: " + (res.hiba || "Ismeretlen hiba"));
            }
        })
        .catch((err) => {
            alert("Hiba történt az üzenet küldésekor: " + err.message);
        });
    });

    uzenetekBetoltese();

    setInterval(() => {
        if (csevegesNyitva) {
            uzenetekBetoltese();
        }
    }, 5000);
});
