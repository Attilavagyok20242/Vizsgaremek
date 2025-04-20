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

    console.log("DOM loaded. Elements:", {
        kilepes, megerosites, profils, szobak, element,
        kuldesGomb, uzenetBevitel, cimBevitel, uzenetDoboz,
        csevegesKapcsolo, csevegesDoboz, csevegesBezaras
    });

    fetch("felhasznalo_belepve")
        .then(res => res.json())
        .then(data => {
            if (data.loggedIn) {
                kilepes.style.display = "block";
                megerosites.style.display = "block";
                profils.style.display = "block";
                szobak.style.display = "block";

                fetch("felhasznalo_kod")
                    .then(res => res.json())
                    .then(data => {
                        console.log("Felhasználó kód:", data);
                        if (data.megerosites == true) {
                            megerosites.style.display = "none";
                            element.style.display = "none";
                        }
                    })
                    .catch(error => console.error("Hiba a megerősítés lekérésekor:", error));
            } else {
                megerosites.style.display = "none";
            }
        })
        .catch(error => console.error("Hiba a bejelentkezés ellenőrzésekor:", error));

    function uzenetekBetoltese() {
        fetch("assets/uzenet_betolto.php")
            .then(res => {
                if (!res.ok) throw new Error("HTTP " + res.status);
                return res.json();
            })
            .then(data => {
                console.log("Üzenetek:", data);
                uzenetDoboz.innerHTML = "";

                if (data.length === 0) {
                    uzenetDoboz.innerHTML = "<p class='nincs-uzenet'>Nincsenek üzenetek.</p>";
                    return;
                }

                data.forEach(uzenet => {
                    const uzenetElem = document.createElement("div");
                    uzenetElem.classList.add("cseveges-uzenet");

                    const jovahagyasInfo = parseInt(uzenet.jovahagyva) === 0
                        ? "<div class='figyelmeztetes'>⏳ Admin jóváhagyásra vár</div>"
                        : "";

                    uzenetElem.innerHTML = `
                        <strong>${uzenet.felhasznalo}:</strong> ${uzenet.szoveg}
                        <small>${uzenet.letrehozva}</small>
                        ${jovahagyasInfo}
                    `;

                    uzenetDoboz.appendChild(uzenetElem);
                });

                uzenetDoboz.scrollTop = uzenetDoboz.scrollHeight;
            })
            .catch(err => {
                console.error("Hiba történt az üzenetek betöltésekor:", err);
                uzenetDoboz.innerHTML = "<p class='hiba-uzenet'>Nem sikerült az üzenetek betöltése.</p>";
            });
    }

    // Csevegés megnyitása
    if (csevegesKapcsolo) {
        csevegesKapcsolo.addEventListener("click", function () {
            csevegesNyitva = !csevegesNyitva;
            csevegesDoboz.style.display = csevegesNyitva ? "block" : "none";
            if (csevegesNyitva) uzenetekBetoltese();
        });
    }

    // Csevegés bezárása és üzenetek törlése
    if (csevegesBezaras) {
        csevegesBezaras.addEventListener("click", function () {
            csevegesDoboz.style.display = "none";
            csevegesNyitva = false;

            fetch("assets/uzenet_torlese.php", {
                method: "POST",
                body: JSON.stringify({}),
                headers: { "Content-Type": "application/json" }
            })
            .then(res => res.json())
            .then(data => {
                if (data.siker) {
                    console.log("Üzenetek sikeresen törölve.");
                } else {
                    console.error("Hiba történt az üzenetek törlésekor.");
                }
            })
            .catch(err => console.error("Törlés hiba:", err));
        });
    }

    // Üzenet küldése
    if (kuldesGomb && uzenetBevitel) {
        kuldesGomb.addEventListener("click", function () {
            const uzenet = uzenetBevitel.value.trim();
            const cim = cimBevitel ? cimBevitel.value.trim() : "";

            if (!uzenet) return;

            const formData = new FormData();
            formData.append("uzenet", uzenet);
            formData.append("cim", cim);

            fetch("assets/Uzenet_Mentes.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if (res.siker) {
                    uzenetBevitel.value = "";
                    if (cimBevitel) cimBevitel.value = "";
                    uzenetekBetoltese();
                } else {
                    alert("Hiba történt az üzenet küldésekor: " + (res.hiba || "Ismeretlen hiba"));
                }
            })
            .catch(err => {
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
