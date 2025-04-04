function Komm() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        const adatok=JSON.parse(this.responseText);
        console.log(adatok);
        for(let i=0;i<adatok.length;i++)
        {
          document.getElementById("segitsegs").innerHTML+="<div class='asd'><tr><th>id"+adatok[i].id+"</th><th>felhasznalo_id</th><th>messages"+adatok[i].felhasznalo_id+"</th><th>dates"+adatok[i].messages+"</th></tr>"+adatok[i].dates+"</div>";
        }
      
      }
    };
    xhttp.open("GET", "segitseg.php", true);
    xhttp.send();
}
Komm();