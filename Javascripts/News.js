$(document).ready(function(){
  $("#rolled1").click(function(){
    $("#rolled1").fadeOut(1000);
    $("#scroll1").delay(1000).fadeIn(1000);
  });
  $("#rolled2").click(function(){
    $("#rolled2").fadeOut(1000);
    $("#scroll2").delay(1000).fadeIn(1000);
  });
  $("#rolled3").click(function(){
    $("#rolled3").fadeOut(1000);
    $("#scroll3").delay(1000).fadeIn(1000);
  });
  $("#eltuntet").click(function(){
    $("#eltuntet").hide();
    $("#komm").hide();
  });
  $(".komment").click(function(){
    $("#eltuntet").show();
    $("#komm").show();
  });
});

function KommentSec(id)
{
  keret=document.getElementById("k");
  keret.innerHTML="";
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      const adatok=JSON.parse(this.responseText);
      for (let i = 0; i < adatok.length; i++) {
        if (adatok[i].helyese==true) {
          keret.innerHTML+="<div class='kommentsec'><h4>"+adatok[i].nev+":</h4><p>"+adatok[i].szoveg+"</p><p>"+adatok[i].datum+"</p></div>";
        }
        else{
          keret.innerHTML="<p>Nem volt még komment, légy te az első!</p>";
        }
          
      }
    }
  };
  xhttp.open("GET", "assets/Kommentshow.php?id="+id, true);
  xhttp.send();
}


function UziKuld()
{
  
  szoveg=document.getElementById("uzenetkuld").value;
  xhttp = new XMLHttpRequest();
  xhttp.open('POST', 'assets/Kommentment.php', true);
  xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState == 4 && xhttp.status == 200) {
      KommentSec(this.responseText);
      szoveg=document.getElementById("uzenetkuld").value="";
    }
  }
  xhttp.send("szoveg="+szoveg);
}