

function Eltun(){
    document.getElementById("felugro1").style.display="none";
    document.getElementById("eltun").style.display="none";
    
}
function Komm() {
  document.getElementById("felugro1").style.display="block";
  document.getElementById("eltun").style.display="block";
  komment=document.getElementById("kommentelj1").innerHTML="";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        const adatok=JSON.parse(this.responseText);
        console.log(adatok);
        for (let i = 0; i < adatok.length; i++) {
          document.getElementById("kommentelj1").innerHTML+="<div class='megjelent'><p>"+adatok[i].felhasz_nev+":</p><p>"+adatok[i].szoveg+"</p><p>"+adatok[i].datum+"<button class='jelent'>Jelentés!</button></p></div>";
          
        }
       
        
        
            
            
        
      }
    };
    xhttp.open("GET", "KommShow.php", true);
    xhttp.send();
}
