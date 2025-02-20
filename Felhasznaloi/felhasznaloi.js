$(document).ready(function () {
    $("#nevchan").click(function (e) { 
       $("#box1").slideToggle("slow");
    });
});

$(document).ready(function () {
    $("#emailchan").click(function (e) { 
       $("#box2").slideToggle("slow");
    });
});
$(document).ready(function () {
    $("#jelchan").click(function (e) { 
       $("#box3").slideToggle("slow");
    });
});
$(document).ready(function () {
    $("#adatvaltoz").click(function (e) { 
       $("#kartya2").fadeIn("slow");
       $("#kartya1").hide("fast");
    });
});
$(document).ready(function () {
    $("#profilkep").click(function (e) { 
       $("#kartya1").fadeIn("slow");
       $("#kartya2").hide("fast");
    });
});

function JelVizsgal()
{
    jelszo1=document.getElementById("ujjelszo");
    jelszo2=document.getElementById("ujujjelszo");
    visszajelzes=document.getElementById("visszajelzes3");
    if (jelszo1.value!="" || jelszo2.value!="") {
        if (jelszo1.value==jelszo2.value) {
            Modosit(jelszo1.value,visszajelzes);
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
function Modosit(jelszo1,visszajelzes)
{
    var xhttp = new XMLHttpRequest();
    xhttp.open('POST', 'Jelszovaltoz.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.onload = function () {
        visszajelzes.style.color="darkgreen";
        visszajelzes.innerHTML = this.responseText;
    };
    xhttp.send('jelszo1='+jelszo1);
}
function KepFeltolt()
{
    profilkep=document.getElementById("profil");
    utvonal=document.getElementById("kepfeltolt");
    var xhttp = new XMLHttpRequest();
    xhttp.open('FILE', 'felhasznaloi.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.onload = function () {
        profilkep.src = this.responseText;
    };
    xhttp.send(utvonal);
    




}
    
    






