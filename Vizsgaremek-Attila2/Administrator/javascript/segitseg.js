function Komm() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
      if (this.readyState === 4 && this.status === 200) {
          const adatok = JSON.parse(this.responseText);
          console.log(adatok);

          let tableBody = document.getElementById("resultTable");
          tableBody.innerHTML = ""; 

          adatok.forEach(adat => {
              let row = document.createElement("tr");
              row.innerHTML = `
                  <td>${adat.cim}</td>
                  <td>${adat.leiras}</td>
                  <td>${adat.datum}</td>
                  <td>
                      <button class="accept-btn" onclick="Megnyitas()">Elfogadás</button>
                  </td>
              `;

              tableBody.appendChild(row);
          });
      }
  };

  xhttp.open("GET", "segitseg.php", true);
  xhttp.send();
}

Komm();
