//ha rákattintok akkor eltüntettem a kártyáknak a div-ét, és megjelenítem a másikat
$(document).ready(function () {
    $("#uzemfal").click(function (e) {
        $(".cardBox").toggle();
   
    });
});
