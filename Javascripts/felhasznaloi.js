$(document).ready(function () {
    $("#nevchan").click(function (e) { 
        $("#box1").slideToggle("slow");
     });
     $("#emailchan").click(function (e) { 
         $("#box2").slideToggle("slow");
      });
      $("#jelchan").click(function (e) { 
         $("#box3").slideToggle("slow");
      });
      $("#adatvaltoz").click(function (e) { 
         $("#kartya2").fadeIn("slow");
         $("#kartya1").hide("fast");
         $("#kartya3").hide("fast");
      });
      $("#profilkep").click(function (e) { 
         $("#kartya1").fadeIn("slow");
         $("#kartya2").hide("fast");
         $("#kartya3").hide("fast");
      });
      $("#naplo").click(function (e) { 
        $("#kartya3").fadeIn("slow");
        $("#kartya2").hide("fast");
        $("#kartya1").hide("fast");
     });
});
function Megerositve()
{
  
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            if (this.responseText==1) {
                document.getElementById("megerosit").style.display="none";
            }
            else{
                document.getElementById("megerosit").style.display="flex";
            }
          }
        };
        xhttp.open("GET", "assets/megerositve.php", true);
        xhttp.send();
}
Megerositve()
function JelVizsgal()
{
    jelszo1=document.getElementById("ujjelszo");
    jelszo2=document.getElementById("ujujjelszo");
    visszajelzes=document.getElementById("visszajelzesjelszo");
    if (jelszo1.value!="" || jelszo2.value!="") {
        if (jelszo1.value==jelszo2.value) {
            JelszoModosit(jelszo1.value,visszajelzes,jelszo1,jelszo2);
        }
        else if(jelszo1.value!=jelszo2.value){
            visszajelzes.style.color="red";
            visszajelzes.innerHTML="Nem egyezik a két jelszavad!";
        }
            
     
    }
    else
    {
        visszajelzes.style.color="red";
        visszajelzes.innerHTML="Nem adott meg jelszót!";
    }
}
function JelszoModosit(jelszo,visszajelzes,jelszo1,jelszo2)
{
    var xhttp = new XMLHttpRequest();
    xhttp.open('POST', 'adatvaltoz', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.onload = function () {
        if (this.responseText!="24") {
            visszajelzes.style.color="darkgreen";
            visszajelzes.innerHTML = this.responseText;
            jelszo1.value="";
            jelszo2.value="";
            setTimeout(() => window.location.reload(), 3000);
        }
        else{
            visszajelzes.style.color="red";
            visszajelzes.innerHTML = "Csak 24 óra múlva tudod újra megváltoztatni jelszavadat!";
        }
        

    };
    xhttp.send('jelszo1='+jelszo);
}

function FelhNevModosit()
{
    ujfelnev=document.getElementById("ujfelnev").value;
    visszajelzes=document.getElementById("visszajelzesnev");
    var xhttp = new XMLHttpRequest();
    xhttp.open('POST', 'adatvaltoz', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.onload = function () {
        if (this.responseText=="foglalt") {
            visszajelzes.style.color="red";
            visszajelzes.innerHTML="A felhasználónév már foglalt!";
        }
        else if(this.responseText=="nincs")
        {
            visszajelzes.style.color="red";
            visszajelzes.innerHTML="Adj meg egy felhasználó nevet!";
        }
        else{
            visszajelzes.style.color="darkgreen";
            visszajelzes.innerHTML=this.responseText;
            setTimeout(() => window.location.reload(), 3000);
        }
        
        
    };
    xhttp.send('ujfelnev='+ujfelnev);
}
function EmailModosit()
{
    ujemail=document.getElementById("ujemail").value;
    visszajelzes=document.getElementById("visszajelzesemail");
    var xhttp = new XMLHttpRequest();
    xhttp.open('POST', 'adatvaltoz', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.onload = function () {
        if (this.responseText=="foglalt") {
            visszajelzes.style.color="red";
            visszajelzes.innerHTML="Ez az E-mail cím már foglalt!";
        }
        else if(this.responseText=="formatum_hiba")
        {
            visszajelzes.style.color="red";
            visszajelzes.innerHTML="Rossz az email formatum!";
        }
        else{
            visszajelzes.style.color="darkgreen";
            visszajelzes.innerHTML=this.responseText;
            setTimeout(() => window.location.reload(), 3000);
        }
    };
    xhttp.send('ujemail='+ujemail);
}
function Kepvaltoztat()
{
    profilkep=document.getElementById("kepfeltolt").files[0];
    if(profilkep!=null)
    {
        formdata=new FormData();
        formdata.append("image",profilkep);
        kep=document.getElementById("profil");
        $.ajax({
            url: "keptolt",
            type: "POST",
            data: formdata,
            dataType: "multipart/form-data",
            processData: false,
            contentType: false,
            complete: function(vissza){
                if(vissza.responseText=="rossz_formatum")
                {
                    kep.src="ikon/feltoltes.png";
                    alert("Rossz a fájl formátum!");
                }
                else if(vissza.responseText=="tul_nagy")
                {
                    kep.src="ikon/feltoltes.png";
                    alert("A kép túl nagy!");
                }
                else{
                    kep.src=vissza.responseText;
                }
            }
        });
    }
}
function megerosites(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
            console.log("Válasz státusza:", this.status);
            console.log("Válasz szövege:", this.responseText);
        }
    };
    console.log("Küldés indítása...");
    xhttp.open("GET", "level_kuld2",true);
    xhttp.send();
    console.log("Küldés megtörtént!");
}
function Naplo()
{
    naplo=document.getElementById("naplod");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const adatok = JSON.parse(this.responseText);
            let osszadat = [];
            if (adatok.email?.length > 0) {
                osszadat.push(...adatok.email.map(item => ({
                    ...item,
                    tipus: 'email'
                })));
            }
            if (adatok.nev?.length > 0) {
                osszadat.push(...adatok.nev.map(item => ({
                    ...item,
                    tipus: 'nev'
                })));
            }
            if (adatok.jelszo?.length > 0) {
                osszadat.push(...adatok.jelszo.map(item => ({
                    ...item,
                    tipus: 'jelszo'
                })));
            }
            osszadat.sort((a, b) => new Date(b.datum) - new Date(a.datum));
            for (let i = 0; i < osszadat.length; i++) {
                const adat = osszadat[i];
                let html = "";

                if (adat.tipus === "email") {
                    html = `<p>Régi email: ${adat.old_email} | Változás időpontja: ${adat.datum}</p>`;
                } else if (adat.tipus === "nev") {
                    html = `<p>Régi felhasználónév: ${adat.old_nev} | Változás időpontja: ${adat.datum}</p>`;
                } else if (adat.tipus === "jelszo") {
                    html = `<p>Régi jelszó: #### | Változás időpontja: ${adat.datum}</p>`;
                }
                naplo.innerHTML += html;
            }
        }
    };
    xhttp.open("GET", "assets/naplo.php", true);
    xhttp.send();
}
Naplo();