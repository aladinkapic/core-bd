function dajPrijavu(){
    let id_prijave = document.getElementById("id_prijave").value;

    kreiraj_request('POST', '/ekonkurs/curl', "id_prijave=" + id_prijave, true, prijemPrijave);
}

function prijemPrijave(response){
    console.log(response);

    var sluzbenik = document.getElementById("sluzbenik_osnovne_info");

    sluzbenik.style.display = 'block';
}