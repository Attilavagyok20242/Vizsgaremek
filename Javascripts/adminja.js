document.addEventListener("DOMContentLoaded", function () {
    // === Menükapcsolók ===
    const uzemBtn = document.getElementById("uzemfal");
    const segitsegBtn = document.getElementById("segitseg");
    const felhasznalokBtn = document.getElementById("felhasznalok");

    const uzemTartalom = document.getElementById("uzemtartalomkeret");
    const segitsegTartalom = document.getElementById("segitsegtartalomkeret");
    const felhasznaloTorles = document.getElementById("felhasznalo_torles");

    if (uzemBtn && segitsegBtn && felhasznalokBtn) {
        uzemBtn.addEventListener("click", () => {
            uzemTartalom.style.display = "block";
            segitsegTartalom.style.display = "none";
            felhasznaloTorles.style.display = "none";
        });

        segitsegBtn.addEventListener("click", () => {
            uzemTartalom.style.display = "none";
            segitsegTartalom.style.display = "block";
            felhasznaloTorles.style.display = "none";
        });

        felhasznalokBtn.addEventListener("click", () => {
            uzemTartalom.style.display = "none";
            segitsegTartalom.style.display = "none";
            felhasznaloTorles.style.display = "block";
        });
    }

    // === Csevegés / Jelentések ===
    const jelentesKeret = document.getElementById("jelentesek");
    const kuldesGomb = document.getElementById("cseveges-kuldes");
    const uzenetBevitel = document.getElementById("cseveges-bevitel");
    const uzenetDoboz = document.getElementById("cseveges-uzenetek");
    const csevegesKapcsolo = document.getElementById("cseveges-kapcsolo");
    const csevegesDoboz = document.getElementById("cseveges-doboz");
    const csevegesBezaras = document.getElementById("cseveges-bezar");

    let csevegesNyitva = false;

    function uzenetekBetoltese() {
        if (!uzenetDoboz) return;

        fetch("assets/uzenet_betolto.php")
            .then((res) => res.json())
            .then((data) => {
                uzenetDoboz.innerHTML = "";

                if (!data.length) {
                    uzenetDoboz.innerHTML = "<p class='nincs-uzenet'>Nincsenek üzenetek.</p>";
                    return;
                }

                data.forEach((uzenet) => {
                    const elem = document.createElement("div");
                    elem.className = "cseveges-uzenet";
                    elem.innerHTML = `
                        <strong>${uzenet.felhasznalo || "Admin"}:</strong> 
                        ${uzenet.szoveg || "Nincs szöveg."}
                        <small>${uzenet.letrehozva || "N/A"}</small>
                    `;
                    uzenetDoboz.appendChild(elem);
                });

                uzenetDoboz.scrollTop = uzenetDoboz.scrollHeight;
            })
            .catch((err) => {
                console.error("Üzenet betöltési hiba:", err);
                uzenetDoboz.innerHTML = "<p class='hiba-uzenet'>Nem sikerült betölteni az üzeneteket.</p>";
            });
    }

    function Jelentesek() {
        if (!jelentesKeret) return;

        fetch("assets/jelentes.php")
            .then((res) => res.json())
            .then((obj) => {
                jelentesKeret.innerHTML = "";

                if (!obj.length) {
                    jelentesKeret.innerHTML = "<p>Nincsenek új jelentések.</p>";
                    return;
                }

                obj.forEach((jelentes) => {
                    const div = document.createElement("div");
                    div.className = "jelentes";
                    div.innerHTML = `
                        <p><strong>Név:</strong> ${jelentes.nev}</p>
                        <p><strong>Cím:</strong> ${jelentes.cim}</p>
                        <p><strong>Dátum:</strong> ${jelentes.datum}</p>
                        <button class="Jovahagyas">Jóváhagyás</button>
                        <button class="Lezaras">Jelentés lezárása</button>
                    `;
                    jelentesKeret.appendChild(div);

                    div.querySelector(".Jovahagyas")?.addEventListener("click", () => {
                        fetch("assets/jelentes_jovahagy.php", {
                            method: "POST",
                        })
                        .then((r) => r.json())
                        .then((d) => {
                            alert(d.siker ? "Jóváhagyva." : "Hiba történt.");
                            if (d.siker) {
                                Jelentesek();
                                csevegesKapcsolo?.click();
                            }
                        });
                    });

                    div.querySelector(".Lezaras")?.addEventListener("click", () => {
                        fetch("assets/jelentes_lezarasa.php", {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({})
                        })
                        .then((r) => r.json())
                        .then((d) => {
                            alert(d.siker ? "Lezárva." : "Hiba történt.");
                            if (d.siker) Jelentesek();
                        });
                    });
                });
            })
            .catch((err) => {
                console.error("Jelentések betöltési hiba:", err);
                jelentesKeret.innerHTML = "<p class='hiba'>Nem sikerült betölteni a jelentéseket.</p>";
            });
    }

    Jelentesek();

    // === Csevegés panel kezelés ===
    if (csevegesKapcsolo && csevegesDoboz) {
        csevegesKapcsolo.addEventListener("click", () => {
            csevegesNyitva = !csevegesNyitva;
            csevegesDoboz.style.display = csevegesNyitva ? "block" : "none";
            if (csevegesNyitva) uzenetekBetoltese();
        });
    }

    csevegesBezaras?.addEventListener("click", () => {
        csevegesNyitva = false;
        csevegesDoboz.style.display = "none";
    });

    // === Üzenet küldés ===
    kuldesGomb?.addEventListener("click", () => {
        const uzenet = uzenetBevitel?.value.trim();
        if (!uzenet) return;

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
                alert("Hiba: " + (res.hiba || "Ismeretlen"));
            }
        })
        .catch((err) => {
            alert("Hiba: " + err.message);
        });
    });

    // === Automatikus frissítés ===
    setInterval(() => {
        if (csevegesNyitva) uzenetekBetoltese();
    }, 5000);
});
