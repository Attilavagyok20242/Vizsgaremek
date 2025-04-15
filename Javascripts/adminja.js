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
