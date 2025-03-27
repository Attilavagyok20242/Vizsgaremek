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
     });
     $("#profilkep").click(function (e) { 
        $("#kartya1").fadeIn("slow");
        $("#kartya2").hide("fast");
     });
});
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
        if (this.responseText!="foglalt") {
            visszajelzes.style.color="darkgreen";
            visszajelzes.innerHTML=this.responseText;
        }
        else{
            visszajelzes.style.color="red";
            visszajelzes.innerHTML="A felhasználónév már foglalt!";
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
        if (this.responseText!="foglalt") {
            visszajelzes.style.color="darkgreen";
            visszajelzes.innerHTML=this.responseText;
        }
        else{
            visszajelzes.style.color="red";
            visszajelzes.innerHTML="Ez az E-mail cím már foglalt!";
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
        console.log(profilkep);
        $.ajax({
            url: "keptolt",
            type: "POST",
            data: formdata,
            dataType: "multipart/form-data",
            processData: false,
            contentType: false,
            complete: function(vissza){
                kep.src=vissza.responseText;
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