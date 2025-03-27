function atad(){
    var cim = document.getElementById("email").value;
    console.log("Email érték: ", cim);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
            console.log("Válasz státusza:", this.status);
            console.log("Válasz szövege:", this.responseText);
        }
    };

    console.log("Küldés indítása...");
    xhttp.open("GET", "level_kuld2.php?c=" + encodeURIComponent(cim), true);
    xhttp.send();
    console.log("Küldés megtörtént!");
}


const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');
registerBtn.addEventListener('click', () => 
{
container.classList.add('active');
});
loginBtn.addEventListener('click', () => 
    {
    container.classList.remove('active');
    });
    $('#register').submit(function (e) { 
        e.preventDefault();
        
    });
