/**********************************************************************************************************************
 *
 *      Ovdje postavljamo globalnu varijablu, koja ima mogućnost good_to_go ili not_good_to_go. Ako su sve validacije
 *      ispravne, može proći dalje, ako nisu, well Huston we have a problem.
 *
 **********************************************************************************************************************/

var change_it = false;

/**********************************************************************************************************************/

function djevojacko_prezime(what){ /** ako je odabrana žena, onda treba dati opciju postavljanja djevojačkog prezimena **/

    var prezime = document.getElementsByClassName("djevojacko_prezime")[0];
    var input   = document.getElementsByClassName("djevojacko_prezime_input")[0];

    if(parseInt(what.value) == 0){
        prezime.className   = "control-label djevojacko_prezime";
        input.style.display = 'block';
    }else{
        prezime.className   = "control-label djevojacko_prezime hidden";
        input.style.display = 'none';
    }
}


function set_tokens(xml){
    var metas = document.getElementsByTagName('meta');
    for (var i=0; i<metas.length; i++) {
        if (metas[i].getAttribute("name") == "csrf-token") {
            xml.setRequestHeader("X-CSRF-Token", metas[i].getAttribute("content"));
        }
    }

    return xml;
}
/**********************************************************************************************************************/





/******************************************* UNESI SLIKU SLUŽBENIKA ***************************************************/

function upload_slider_image(id, image_id, image_url){
    var data = new FormData();
    var ins = document.getElementById(id).files.length;

    data.append(id, document.getElementById(id).files[0]);

    document.getElementById("loading_wrapper").style.display = 'block'; /** show loading part **/

    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            var source = image_url + this.responseText;

            source = source.replace(' ', '');

            var image = document.getElementById(image_id);
            image.setAttribute('src', source);

            // ** ovdje ćemo postaviti naziv fotografije, tako da je kasnije možemo samo strpati u bazu ** //
            document.getElementById("fotografija").value = this.responseText;
            document.getElementById("loading_wrapper").style.display = 'none'; /** hide loading part **/
        }
    };
    xml.open('POST', '/hr/sluzbenici/unesi_sliku');

    // ** Postavi tokene ** //
    var metas = document.getElementsByTagName('meta');
    for (var i=0; i<metas.length; i++) {
        if (metas[i].getAttribute("name") == "csrf-token") {
            xml.setRequestHeader("X-CSRF-Token", metas[i].getAttribute("content"));
        }
    }

    xml.send(data); // napravi http
}
/**********************************************************************************************************************/

/********************************************** PROVJERA REQUIRED *****************************************************/


function required(){
    var inputs = document.getElementsByClassName("required");
    for(var i=0; i<inputs.length; i++){
        for(var j=0; j<inputs[i].className.split(" ").length; j++){
            if(inputs[i].className.split(" ")[j] === 'required'){
                if(inputs[i].value === ''){
                    console.log("Polje " + inputs[i].id + ' ne smije biti prazno');
                    return true;
                }
            }
        }
    }

    return false;
}


/**********************************************************************************************************************/

/********************************************** SPREMI SLUŽBENIKA *****************************************************/
function spremi_sluzbenika(){
    var id_sluzbenika            = document.getElementById("id_sluzbenika").value;
    if(id_sluzbenika == ''){
        url = '/hr/sluzbenici/spremi_sluzbenika';
    }else{
        url = '/hr/sluzbenici/azurirajSluzbenika';
        id_sluzbenika = '&id=' + id_sluzbenika;
    }

    var currentDate = parseInt((new Date().getTime()) / 1000);

    if(required()){
        $.notify("Došlo je do greške. Molimo popunite sva polja. ", 'warn');
    }
    if(change_it){
        $.notify("Došlo je do greške. Neka od polja nisu ispravno popunjena. Molimo provjerite. . ", 'warn');
    }

    if(change_it ||required()) return;

    var ime                      = document.getElementById("ime").value;
    var prezime                  = document.getElementById("prezime").value;
    var korisnicko_ime           = document.getElementById("korisnicko_ime").value;
    var email                    = document.getElementById("email").value;
    var jmbg                     = document.getElementById("jmbg").value;
    var ime_roditelja            = document.getElementById("ime_roditelja").value;
    var pol                      = document.getElementById("pol").value;
    var kategorija               = document.getElementById("kategorija").value;
    var djevojacko_prezime       = document.getElementById("djevojacko_prezime").value;
    var drzavljanstvo_1          = document.getElementById("drzavljanstvo_1").value;
    var drzavljanstvo_2          = document.getElementById("drzavljanstvo_2").value;
    var nacionalnost             = document.getElementById("nacionalnost").value;
    var bracni_status            = document.getElementById("bracni_status").value;
    var mjesto_rodjenja          = document.getElementById("mjesto_rodjenja").value;
    var datum_rodjenja           = document.getElementById("usr1").value;
    var fotografija              = document.getElementById("fotografija").value;
    var licna_karta              = document.getElementById("licna_karta").value;
    var mjesto_izdavanja_lk      = document.getElementById("mjesto_izdavanja_lk").value;
    // var privremeni_premjestaj    = document.getElementById("privremeni_premjestaj").value;
    var PIO                      = document.getElementById("PIO").value;
    var trenutno_radi            = document.getElementById("trenutno_radi").value;
    var ekonkurs                 = (document.getElementById("ekonkurs") != null ) ? document.getElementById("ekonkurs").value : 0;
    var ekonkurs_prijava         = (document.getElementById("ekonkurs_prijava") != null ) ? document.getElementById("ekonkurs_prijava").value : 0;
    // var radno_mjesto             = document.getElementById("radno_mjesto").value;


    var datum_dan = parseInt((new Date(datum_rodjenja.split(".")[1] + '/' + datum_rodjenja.split(".")[0] + '/' + datum_rodjenja.split(".")[2]).getTime()) / 1000);
    if(datum_dan >= currentDate){
        $.notify("Došlo je do greške. Uneseni datum rođenja ne može biti u budućnosti.", 'warn');

        return;
    }
    document.getElementById("loading_wrapper").style.display = 'block'; /** show loading part **/

    kreiraj_request('POST', url, "ime=" + ime + '&prezime=' + prezime + '&korisnicko_ime=' + korisnicko_ime + '&email=' + email + '&jmbg=' + jmbg + '&ime_roditelja=' + ime_roditelja + '&pol=' + pol + '&kategorija=' + kategorija + '&djevojacko_prezime=' + djevojacko_prezime + '&drzavljanstvo_1=' + drzavljanstvo_1 + '&drzavljanstvo_2=' + drzavljanstvo_2 + '&nacionalnost=' + nacionalnost + '&bracni_status=' + bracni_status + '&mjesto_rodjenja=' + mjesto_rodjenja + '&datum_rodjenja=' + datum_rodjenja + '&fotografija=' + fotografija + '&licna_karta=' + licna_karta + '&mjesto_izdavanja_lk=' + mjesto_izdavanja_lk + '&PIO=' + PIO + '&trenutno_radi=' + trenutno_radi + '&ekonkurs=' + ekonkurs + '&ekonkurs_prijava=' + ekonkurs_prijava + '&_method=PUT' + id_sluzbenika, true, spremiSluzbenikaResponse);
}


function spremiSluzbenikaResponse(response){
    var status   = response['status'];
    var code     = response['code'];
    var message  = response['message'];
    var special  = response['special'];


    if(status == 'success'){
        var dialog = bootbox.dialog({
            title: 'Obaviještenje',
            message: "<p> Službenik je uspješno spremljen. U daljem nastavku unesite ostale informacije za službenika ! </p>",
            size: 'large',
            buttons: {
                cancel: {
                    label: "Odustanite",
                    className: 'btn-primary',
                    callback: function(){
                        window.location = '/hr/sluzbenici/pregledaj';
                    }
                },
                ok: {
                    label: "Nastavite sa unosom",
                    className: 'btn-secondary',
                    callback: function(){
                        window.location = "/hr/sluzbenici/uredi_sluzbenika/" + special;
                    }

                }
            }
        });
        // create_not('fas fa-check-circle', 'SLUŽBENIK SPREMLJEN', 'Uspješno ste spasili službenika. U daljem nastavku unesite ostale informacije za službenika !', '/hr/sluzbenici/dodatno_o_sluzbeniku/' + special, 'NASTAVITE SA UNOSOM', '00BFAC');
    }else if(status == 'error'){
        $.notify("Žao nam je, došlo je do greške. Molimo pokušajte opet.", "warn");
        // create_not('fas fa-times', 'GREŠKA ' + code, message, '#', 'UNESITE PONOVO', '#FF0D53')
    }
}

/**********************************************************************************************************************/





/********************************************** KREIRAJ  USERNAME *****************************************************/


function kreirajKorisnickoIme(){
    var ime     = document.getElementById("ime").value;
    var prezime = document.getElementById("prezime").value;

    var korisnickoIme = document.getElementById("korisnicko_ime");

    if(prezime == '') var string = ime.toLowerCase();
    else if(ime == '') var string = prezime.toLowerCase();
    else var string = (ime + '.' + prezime).toLowerCase();


    var newString = string.replace(/ć/g, "c");
    newString = newString.replace(/č/g, "c");
    newString = newString.replace(/š/g, "s");
    newString = newString.replace(/đ/g, "d");
    newString = newString.replace(/ž/g, "z");

    newString = newString.replace(/ /g, "");

    korisnickoIme.value = newString;
}


/**********************************************************************************************************************/


/****************************************** FUNKCIJE ZA VERIFIKACIJU **************************************************/


function checkEmail (email) {
    return /\S+@\S+\.\S+/.test(email);
}

function verifikuj_string(id, poruka, what, force){
    change_it = false;


    var forma        = document.getElementById(id);

    var notifikacija = document.getElementById(id + '_not');   // ID notifikacije je isti kao ID forme uz dodatni _not
    var vrijednost   = document.getElementById(id + '_not_v'); // ID paragrafa je isti kao ID forme uz dodatni _not_v

    if(forma.value === ''){
        sakrij_notifikaciju(id + '_not');
        return;
    }

    if(what === 'ima_li_brojeva'){
        for(var i=0; i<forma.value.length; i++){
            if(forma.value[i].charCodeAt() > 47 &&  forma.value[i].charCodeAt() < 58) change_it = true;
        }
    }else if(what === 'email'){
        if(checkEmail(forma.value) === false) change_it = true;
    }else if(what === 'ima_li_slova'){
        for(var i=0; i<forma.value.length; i++){
            if(forma.value[i].charCodeAt() < 48 || forma.value[i].charCodeAt() > 57){
                change_it = true;
            }
        }
    }else if(what === 'jmbg'){
        if(forma.value.length !== 13) change_it = true;
    }

    if(force === true) change_it = true;


    if(change_it){
        vrijednost.innerHTML = poruka;
        notifikacija.style.height = (vrijednost.clientHeight + 20) + "px";
        notifikacija.style.marginBottom = "20px";
        return;
    }


    sakrij_notifikaciju(id + '_not');
}


function sakrij_notifikaciju(id){
    document.getElementById(id).style.height = '0px';
    document.getElementById(id).style.marginBottom = '0px';
}



function ima_li_brojeva(string){

}

/**********************************************************************************************************************/












