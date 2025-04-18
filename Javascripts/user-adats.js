document.addEventListener("DOMContentLoaded", function () {
    const kilepes = document.querySelector(".kilepes");
    const megerosites = document.querySelector(".megerosites");
    const profils = document.querySelector(".profils");
    const szobak = document.querySelector(".szobak");
    const element = document.querySelector(".element");


    const kuldesGomb = document.getElementById("cseveges-kuldes");
    const uzenetBevitel = document.getElementById("cseveges-bevitel");
    const cimBevitel = document.getElementById("jelentes-cim"); 
    const uzenetDoboz = document.getElementById("cseveges-uzenetek");
    const csevegesKapcsolo = document.getElementById("cseveges-kapcsolo");
    const csevegesDoboz = document.getElementById("cseveges-doboz");
    const csevegesBezaras = document.getElementById("cseveges-bezar");

    let csevegesNyitva = false;

    fetch("felhasznalo_belepve")
        .then(response => response.json())
        .then(data => {
            if (data.loggedIn) {
                kilepes.style.display = "block";
                megerosites.style.display = "block";
                profils.style.display = "block";
                szobak.style.display = "none";
                fetch("felhasznalo_kod")
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if (data.megerosites == true) {
                                megerosites.style.display = "none";
                                element.style.display = "none";
                        }
                    })
                    .catch(error => console.error("Hiba történt (megerősítés lekérés):", error));
            } else {
                 megerosites.style.display = "none";
            }
        })
        .catch(error => console.error("Hiba történt (bejelentkezés ellenőrzés):", error));

    function uzenetekBetoltese() {
        fetch("assets/uzenet_betolto.php")
            .then((response) => response.json())
            .then((data) => {
                uzenetDoboz.innerHTML = "";

                if (data.length === 0) {
                    uzenetDoboz.innerHTML = "<p class='nincs-uzenet'>Nincsenek üzenetek.</p>";
                    return;
                }

                data.forEach((uzenet) => {
                    const uzenetElem = document.createElement("div");
                    uzenetElem.classList.add("cseveges-uzenet");

                    let jovahagyasInfo = "";
                    if (uzenet.jovahagyva === 0) {
                        jovahagyasInfo = "<div class='figyelmeztetes'>⏳ Admin jóváhagyásra vár</div>";
                    }

                    uzenetElem.innerHTML = `
                        <strong>${uzenet.felhasznalo}:</strong> ${uzenet.szoveg}
                        <small>${uzenet.letrehozva}</small>
                        ${jovahagyasInfo}
                    `;

                    uzenetDoboz.appendChild(uzenetElem);
                });

                uzenetDoboz.scrollTop = uzenetDoboz.scrollHeight;
            })
            .catch((err) => {
                console.error("Hiba történt az üzenetek betöltésekor:", err);
                uzenetDoboz.innerHTML = "<p class='hiba-uzenet'>Nem sikerült az üzenetek betöltése.</p>";
            });
    }

    if (csevegesKapcsolo) {
        csevegesKapcsolo.addEventListener("click", function () {
            csevegesDoboz.style.display = csevegesNyitva ? "none" : "block";
            csevegesNyitva = !csevegesNyitva;
            if (csevegesNyitva) {
                uzenetekBetoltese();
            }
        });
    }

    if (csevegesBezaras) {
        csevegesBezaras.addEventListener("click", function () {
            csevegesDoboz.style.display = "none";
            csevegesNyitva = false;

            fetch("assets/uzenet_torlese.php", {
                method: "POST",
                body: JSON.stringify({}),
                headers: { "Content-Type": "application/json" },
            })
            .then(response => response.json())
            .then(data => {
                if (data.siker) {
                    console.log("Az üzenetek sikeresen törölve");
                } else {
                    console.error("Hiba történt az üzenetek törlésekor");
                }
            })
            .catch((err) => {
                console.error("Hiba történt az üzenetek törlésekor:", err);
            });
        });
    }

    if (kuldesGomb && uzenetBevitel) {
        kuldesGomb.addEventListener("click", function () {
            const uzenet = uzenetBevitel.value.trim();
            const cim = cimBevitel ? cimBevitel.value.trim() : "";

            if (uzenet === "") return;

            const formData = new FormData();
            formData.append("uzenet", uzenet);
            formData.append("cim", cim); // Jelentés címe csak az első üzenetnél

            fetch("assets/Uzenet_Mentes.php", {
                method: "POST",
                body: formData,
            })
                .then((res) => res.json())
                .then((res) => {
                    if (res.siker) {
                        uzenetBevitel.value = "";
                        if (cimBevitel) cimBevitel.value = ""; // egyszer kell
                        uzenetekBetoltese();
                    } else {
                        alert("Hiba történt az üzenet küldésekor: " + (res.hiba || "Ismeretlen hiba"));
                    }
                })
                .catch((err) => {
                    alert("Hiba történt az üzenet küldésekor: " + err.message);
                });
        });
    }

    // Automatikus frissítés
    setInterval(() => {
        if (csevegesNyitva) {
            uzenetekBetoltese();
        }
    }, 5000);
});
