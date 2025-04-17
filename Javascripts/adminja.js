//ha rákattintok akkor eltüntettem a kártyáknak a div-ét, és megjelenítem a másikat
$(document).ready(function () {
    $("#uzemfal").click(function (e) {
        $("#uzemtartalomkeret").show();
        $("#segitsegtartalomkeret").hide();
        
    });
    $("#segitseg").click(function (e) {
        $("#uzemtartalomkeret").hide();
        $("#segitsegtartalomkeret").show();
    });
});
function Jelentesek()
{
    keret=document.getElementById("jelentesek");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const obj = JSON.parse(this.responseText);
            for (let i = 0; i < obj.length; i++) {
                keret.innerHTML+="<div class='jelentes'><p>"+obj[i].nev+"</p><p>"+obj[i].cim+"</p><p>"+obj[i].datum+"</p><button>Jóváhagyás</button></div>";
            }
        }
    };
    xhttp.open("GET", "assets/jelentes.php", true);
    xhttp.send();
}
Jelentesek();
        

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

