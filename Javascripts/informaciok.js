let kovetkezoElem = document.getElementById('kovetkezo');
let elozoElem = document.getElementById('elozo');

let korhintaElem = document.querySelector('.korhinta');
let csuszkaElem = korhintaElem.querySelector('.korhinta .lista');
let elonezetKeretElem = document.querySelector('.korhinta .elonezet');
let elonezetElemek = elonezetKeretElem.querySelectorAll('.elem');
let idoElem = document.querySelector('.korhinta .ido');

elonezetKeretElem.appendChild(elonezetElemek[0]);
let futasiIdo = 3000;
let autoKovetkezoIdo = 7000;

kovetkezoElem.onclick = function(){
    mutatCsuszka('kovetkezo');    
}

elozoElem.onclick = function(){
    mutatCsuszka('elozo');    
}
let idoKeses;
let autoKovetkezo = setTimeout(() => {
    kovetkezoElem.click();
}, autoKovetkezoIdo)

function mutatCsuszka(tipus){
    let csuszkaElemek = csuszkaElem.querySelectorAll('.korhinta .lista .elem');
    let elonezetElemek = document.querySelectorAll('.korhinta .elonezet .elem');
    
    if(tipus === 'kovetkezo'){
        csuszkaElem.appendChild(csuszkaElemek[0]);
        elonezetKeretElem.appendChild(elonezetElemek[0]);
        korhintaElem.classList.add('kovetkezo');
    }else{
        csuszkaElem.prepend(csuszkaElemek[csuszkaElemek.length - 1]);
        elonezetKeretElem.prepend(elonezetElemek[elonezetElemek.length - 1]);
        korhintaElem.classList.add('elozo');
    }
    clearTimeout(idoKeses);
    idoKeses = setTimeout(() => {
        korhintaElem.classList.remove('kovetkezo');
        korhintaElem.classList.remove('elozo');
    }, futasiIdo);

    clearTimeout(autoKovetkezo);
    autoKovetkezo = setTimeout(() => {
        kovetkezoElem.click();
    }, autoKovetkezoIdo)
}
