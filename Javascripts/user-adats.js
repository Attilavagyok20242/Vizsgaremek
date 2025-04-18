document.addEventListener("DOMContentLoaded", function () {
    const kilepes = document.querySelector(".kilepes");
    const megerosites = document.querySelector(".megerosites");
    const profils = document.querySelector(".profils");
    const szobak = document.querySelector(".szobak");
    const element = document.querySelector(".element");

    const kuldesGomb = document.getElementById("cseveges-kuldes");
    const uzenetBevitel = document.getElementById("cseveges-bevitel");
    const cimBevitel = document.getElementById("jelentes-cim"); // Jelentés címe input
    const uzenetDoboz = document.getElementById("cseveges-uzenetek");
    const csevegesKapcsolo = document.getElementById("cseveges-kapcsolo");
    const csevegesDoboz = document.getElementById("cseveges-doboz");
    const csevegesBezaras = document.getElementById("cseveges-bezar");

    let csevegesNyitva = false;

    // Jogosultság és UI frissítés
    fetch("felhasznalo_belepve")
        .then(response => response.json())
        .then(data => {
            if (data.loggedIn) {
                if (kilepes) kilepes.style.display = "block";
                if (megerosites) megerosites.style.display = "block";
                if (profils) profils.style.display = "block";
                if (szobak) szobak.style.display = "block";

                fetch("felhasznalo_kod")
                    .then(response => response.json())
                    .then(data => {
                        if (data.megerosites === true) {
                            if (megerosites) megerosites.style.display = "none";
                            if (element) element.style.display = "none";
                        }
                    })
                    .catch(error => console.error("Hiba történt (megerősítés lekérés):", error));
            } else {
                if (megerosites) megerosites.style.display = "none";
            }
        })
        .catch(error => console.error("Hiba történt (bejelentkezés ellenőrzés):", error));

    // Üzenetek betöltése
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

    // Csevegés kapcsoló
    if (csevegesKapcsolo) {
        csevegesKapcsolo.addEventListener("click", function () {
            csevegesDoboz.style.display = csevegesNyitva ? "none" : "block";
            csevegesNyitva = !csevegesNyitva;
            if (csevegesNyitva) {
                uzenetekBetoltese();
            }
        });
    }

    // Csevegés bezárás és üzenetek törlése
    if (csevegesBezaras) {
        csevegesBezaras.addEventListener("click", function () {
            csevegesDoboz.style.display = "none";
            csevegesNyitva = false;

            // Az összes üzenetet töröljük a chat bezárásakor
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

    // Üzenet küldése
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
