
/*********************************************** Kreiraj request ******************************************************/

/********************************************************************************************************************* /
 *
 *      Ovdje imamo funkciju koja služi kao univerzalni alat za kreiranje requesta
 *      Prima nekoliko parametara:
 *          1. metoda       : POST ili GET
 *          2. url          : predstavlja url na koji pravimo request /hr/sluzbenici/unesi_sluzbenika
 *          3. json         : ako hoćemo da dobijemo povrat u obliku JSON formata, pošaljemo true, inače je false
 *          4. respFunction : naziv funkcije kojom primamo request. Ona u biti treba imati jedan parametar, a to je xml
 *                            i sastoji se od oblika this.responseText -> koji može biti oblika JSON ili neki wrap tekst
 *
 *
 *      BITNO JE NAPOMENUTI DA BI USPJEŠNO KREIRALI REQUEST NA OVAJ PRINCIP, POTREBNO JE DA KREIRAMO DVIJE JAVASCRIPT
 *      FUNKCIJE OD KOJIH JEDNA PRAVI REQUEST A DRUGA GA PRIHVATA I DALJE OBRAĐUJE.
 *
 *      Ako ima bilo kakvih uslova, koje treba ishendlati prije slanja requesta, to je najbolje uraditi u početnoj
 *      funkciji, prije bilo kakvog doticaja sa PHP-om.
 *
 *      Za obradu, kreiranje notifikacija i slično, sve se treba raditi u callback funkciji koja je u biti 4 parametar
 *      ove kreirane funkcije !!
 *
 *      FORMAT INPUTA : "ime=aladin&prezime=kapic&trece=cetvrto"
 *
 *
 **********************************************************************************************************************/

function kreiraj_request(method, url, inputs, json, respFunction){
    document.getElementById("loading_wrapper").style.display = 'block';
    var xml = new XMLHttpRequest();

    xml.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200){
            // console.log("Response : " + this.responseText);
            document.getElementById("loading_wrapper").style.display = 'none'; /** hide loading part **/

            if(json){
                respFunction(JSON.parse(this.responseText));
            }else{
                respFunction(this.responseText);
            }
        }
    };
    xml.open(method, url);                                                      // url za request
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  // ovo se ne dira :D

    // ** Postavi tokene ** //
    var metas = document.getElementsByTagName('meta');
    for (var i=0; i<metas.length; i++) {
        if (metas[i].getAttribute("name") == "csrf-token") {
            xml.setRequestHeader("X-CSRF-Token", metas[i].getAttribute("content"));
        }
    }

    xml.send(inputs);
}
/**********************************************************************************************************************/


/********************************************************************************************************************* /
 *
 *      Ovu funkciju možemo generički koristiti za provjeru da li ima duplikat bilo koje od kolona ili ne.
 *      U biti, sve počinje od toga kako pozivamo funkciju. Trigeruje se na onkeyup !!
 *
 *      Osnovni oblik pozivanja funkcije je:
 *      provjeriPodatke(what, naziv_polja, id_of) gdje je this zapravo html obojekat (input, textarea ili slično).
 *
 *
 **********************************************************************************************************************/

/********************************************** Provjeri podatke ******************************************************/

var id_polja = '';

function provjeriPodatke(what, naziv_polja, id_of){
    id_polja = id_of;                    // Odaberemo koje ćemo polje, npr hoćemo li jmbg ili ćemo polje za ličnu kartu

    if(what.value.length === 13) kreiraj_request('POST', '/hr/sluzbenici/provjeri_sluzbenika', "osnova="+ naziv_polja +"&polje=" + what.value, true, obradiPodatke);;
}


function obradiPodatke(response){
    var polje = document.getElementById(id_polja);

    if(response['status'] == 'error'){
        // polje.style.color = "red";
        verifikuj_string("jmbg", "Postoji korisnik sa istim JMBG-om.", "jmbg", true);
    }else{
        polje.style.color = "#000";
    }
}

/**********************************************************************************************************************/

$('[url]').click(function(){
   window.location.href = $(this).attr('url');
});



/********************************************************************************************************************* /
 *
 *      U ovom odjeljku kreiramo funkciju koja ima za ulogu kopiranje sadržaja iz jedne forme u drugu. Kao parametre
 *      prima this (element iz kojeg se uzima) i niz elemenata (ID-eva) u koje se sprema taj sadržaj.
 *
 **********************************************************************************************************************/


function copy_content(base, ids){
    console.log(base.value);
    for(var i=0; i<ids.length; i++){
        document.getElementById(ids[i]).value = base.value;
    }
}





/**********************************************************************************************************************/




/********************************************************************************************************************* /
 *
 *      Prilikom dinamičkog dodavanja elemenata, ali prije spremanja u bazu, potrebno je kreirati mnoštvo
 *      formi koje se ponašaju kao jedna velika. Naknadno, kada se unos završi, pozivom na submit, svi
 *      elementi se unose kao jedan.
 *
 **********************************************************************************************************************/


(function () {
    var typesToPatch = ['DocumentType', 'Element', 'CharacterData'],
        remove = function () {
            // The check here seems pointless, since we're not adding this
            // method to the prototypes of any any elements that CAN be the
            // root of the DOM. However, it's required by spec (see point 1 of
            // https://dom.spec.whatwg.org/#dom-childnode-remove) and would
            // theoretically make a difference if somebody .apply()ed this
            // method to the DOM's root node, so let's roll with it.
            if (this.parentNode != null) {
                this.parentNode.removeChild(this);
            }
        };

    for (var i=0; i<typesToPatch.length; i++) {
        var type = typesToPatch[i];
        if (window[type] && !window[type].prototype.remove) {
            window[type].prototype.remove = remove;
        }
    }
})();

function obrisiDomElement(id, index){
    var element = document.getElementById(id).getElementsByClassName("copied_form")[index];

    var class_name = element.className.split(" ");
    if(class_name.length > 1){
        var id_of = parseInt(class_name[1].split("*")[1]);
        var tabela = class_name[1].split("*")[0];

        document.getElementById("loading_wrapper").style.display = 'block'; /** show loading part **/

        kreiraj_request('POST', '/help/help/obrisi_iz_baze', "tabela="+ tabela +"&id=" + id_of, true, dohvatiRequest);
    }

    element.remove();
    iterateThruElements(id);
}


function dohvatiRequest(request){

}


function obrisiIzBaze(id, tabela){
    kreiraj_request('POST', '/help/help/obrisi_iz_baze', "tabela="+ tabela +"&id=" + id, false, dohvatiRequestZaBrianje);
}

function dohvatiRequestZaBrianje(response){
    console.log(response);
}


function urediDomElement(id, index){
    var element = document.getElementById(id).getElementsByClassName("copied_form")[index].getElementsByClassName("shadow_delete")[0];

    element.style.display = 'none';
}

function createNewDomElements(id, form_for_copy){
    var cont = document.getElementById(id);
    var elem = document.getElementById(form_for_copy);
    var copy = elem.cloneNode(true);


    /*** read selected element ***/
    var select = elem.getElementsByClassName("form-control");
    var select_c = copy.getElementsByClassName("form-control");


    /******************************************************************************************************************
     *
     *      Ovdje trebamo pokupiti selected elements i prebaciti postaviti u kopiju adekvatno izabrani element.
     *
     *      -- to je potrebno samo za određene elemente !!
     *
     *****************************************************************************************************************/

    for(var i=0; i<select.length; i++){
        if(select[i].nodeName == 'SELECT'){
            // select_c[i].selectedIndex = (select[i].value - 1);

            select_c[i].value = (select[i].value - 1);
            select_c[i].value = (select[i].value);
        }
    }




    var shadow           = document.createElement("div");
    shadow.className     = "shadow_delete";

    var delete_i_w       = document.createElement("div");
    delete_i_w.className = "delete_item";
    delete_i_w.title     = "Obrišite uslov !";
    var icon             = document.createElement("i");
    icon.className       = "fas fa-times";
    delete_i_w.appendChild(icon);
    shadow.appendChild(delete_i_w);

    if(id != 'korisnici'){
        var edit_i_w         = document.createElement("div");
        edit_i_w.className   = "delete_item edit_item";
        edit_i_w.title       = "Uredite uslov";
        var icon_e           = document.createElement("i");
        icon_e.className     = "fas fa-edit";
        edit_i_w.appendChild(icon_e);
        shadow.appendChild(edit_i_w);
    }

    copy.appendChild(shadow);
    cont.appendChild(copy);

    iterateThruElements(id);
}


function iterateThruElements(id){
    var cont = document.getElementById(id);
    var all_elements = cont.getElementsByClassName("copied_form");
    for(var i=0; i<all_elements.length; i++){
        all_elements[i].id = (all_elements[i].id + i);

        var shadow = all_elements[i].getElementsByClassName("shadow_delete")[0];
        shadow.style.display = 'block';

        if(i < all_elements.length - 1){
            all_elements[i].style.marginBottom = "0px";
            all_elements[i].style.borderBottom = "1px solid rgba(0,0,0,0.1)";
        }else{
            all_elements[i].style.borderBottom = "0px";
        }

        all_elements[i].style.paddingTop = "20px";

        all_elements[i].onmouseleave = function(){
            iterateThruElements(id);
        }

        var current_delete = all_elements[i].getElementsByClassName("delete_item")[0];
        current_delete.setAttribute('onclick', "obrisiDomElement('" + id + "'," + [i] +" )");

        if(id != 'korisnici'){
            var current_edit   = all_elements[i].getElementsByClassName("edit_item")[0];
            current_edit.setAttribute('onclick', "urediDomElement('" + id + "'," + [i] +" )");
            // current_delete.addEventListener("click", delegateAction('obrisi_dom_element', [i]));
        }

        var form_elements = all_elements[i].getElementsByClassName("form-control");

        if(id == 'uslovi_za_radno_mjesto'){
            // form_elements[0].name = "naziv_rm_inp[]";
            // form_elements[1].name = "tip_inp[]";
            // form_elements[2].name = "tekst_uslova_inp[]";
            // form_elements[3].name = "vrijednost_inp[]";
        }else{
            // form_elements[0].name = "sluzbenik_id[]";
        }


    }
}






// Ovdje ćemo kreirati request i pretražiti korisnike po imenu i prezimenu

function search_for_user(what){
    var offer_users = document.getElementsByClassName("offer_users")[0];

    if(what.value.length){
        kreiraj_request('POST', '/hr/pretraga/pretrazi_korisnika', "ime=" + what.value, true, pretraziKorisnika);
    }else{
        offer_users.style.display = 'none';
    }
}


function pretraziKorisnika(response){
    var offer_users = document.getElementsByClassName("offer_users")[0];

    offer_users.style.display = 'block';
    offer_users.innerHTML = "";

    for(var i=0; i<response.length; i++){
        console.log("ID : " + response[i]['id'] + ' - ' + response[i]['ime'] + ' ' + response[i]['prezime']);

        var id = response[i]['id'];
        var ime_prezime = response[i]['ime'] + ' ' + response[i]['prezime'];

        var wrapp = document.createElement("div");
        wrapp.className = "single_user";
        wrapp.setAttribute('onclick', "izaberiSluzbenika('" + id + "','" + ime_prezime + "' )");
        var wrapp_v = document.createElement("p");
        wrapp_v.innerHTML = response[i]['ime'] + ' ' + response[i]['prezime'];
        wrapp.appendChild(wrapp_v);

        offer_users.appendChild(wrapp);
    }
}


function izaberiSluzbenika(id, ime){
    var offer_users = document.getElementsByClassName("offer_users")[0];
    offer_users.style.display = 'none';
}



/**********************************************************************************************************************/


var openLoading = false;
function loading(){
    if(!openLoading){
        document.getElementById("loading_wrapper").style.display = 'block';
        openLoading = true;
    }else{
        document.getElementById("loading_wrapper").style.display = 'none';
        openLoading = false;
    }
}


/**********************************************************************************************************************/

/********************************************************************************************************************* /
 *
 *      Privremeni premještaj službenika. Procedura je sljedeća :
 *      Izaberemo korisnika. Na onchange triggerujemo event, i na osnovu ID službenika, tražimo prvo njegovo radno mjesto.
 *
 *      Nakon toga, kad nađemo njegovo radno mjesto pronađemo sva druga radna mjesta koja se nalaze u tom Organu javne
 *      uprave ..
 *
 **********************************************************************************************************************/


function privremeniPremjestaj(){
    var id = document.getElementById("trenutni_sluzbenik").value;
    if(id === ''){
        let radno_mjesto = document.getElementById("redovno_radno_mjesto");
        let radna_mjesta = document.getElementById("privremeno_radno_mjesto");

        radno_mjesto.value = '';
        for(let i=0; i<radna_mjesta.length; i++){
            radna_mjesta.remove(radna_mjesta.length-1);
        }

        return;
    }

    kreiraj_request('POST', '/ugovori/privremeno/radna_mjesta', "id=" + id, true, privremeniPremjestajDone);
}

$(document.body).on("change",".radna-mjesta-organa",function(){
    let value = $(this).val();

    kreiraj_request('POST', '/radna-mjesta-organa', "id=" + value, true, radnaMjestaOrgana);
});

function radnaMjestaOrgana(response) {
    let radna_mjesta = document.getElementById("privremeno_radno_mjesto");

    $('#privremeno_radno_mjesto')
        .find('option')
        .remove();

    // for(let i=0; i<radna_mjesta.length; i++){
    //     radna_mjesta.remove(radna_mjesta.length-1);
    //     console.log("wee");
    // }

    console.log(response['radna_mjesta']);
    console.log("we are here !!");

    for(let i=0; i<response['radna_mjesta'].length; i++){
        var opt = document.createElement('option');
        opt.value = response['radna_mjesta'][i]['id'];
        opt.innerHTML = response['radna_mjesta'][i]['naziv_rm'];
        radna_mjesta.appendChild(opt);
    }
}

function privremeniPremjestajDone(response){
    let radno_mjesto = document.getElementById("redovno_radno_mjesto_naziv");
    let rm_id = document.getElementById("redovno_radno_mjesto_id");

    radno_mjesto.value = response['naziv_radnog_mjesta'];
    rm_id.value = response['rm_id'];


    // for(let i=0; i<radno_mjesto.length; i++){
    //     radno_mjesto.remove(radno_mjesto.length-1);
    // }
    //
    // var opt = document.createElement('option');
    // opt.value =  response['rm_id'];
    // opt.innerHTML =  response['naziv_radnog_mjesta'];
    // radno_mjesto.appendChild(opt);

    // radno_mjesto.value = response['naziv_radnog_mjesta'];

    /*
    for(let i=0; i<radna_mjesta.length; i++){
        radna_mjesta.remove(radna_mjesta.length-1);
    }

    for(let i=0; i<response['radnaMjesta'].length; i++){
        var opt = document.createElement('option');
        opt.value = response['radnaMjesta'][i]['id'];
        opt.innerHTML = response['radnaMjesta'][i]['naziv_rm'];
        radna_mjesta.appendChild(opt);
    } */
}


$(document.body).on("change",".daj-aktivne-sistematizacije",function(){
    let value = $(this).val();

    kreiraj_request('POST', '/daj-sistematizacije', "id=" + value, true, postaviSistematizacije);
});

function postaviSistematizacije(response){
    $("#izaberite-sistematizacije").find('option').remove();

    let organizacije = document.getElementById("izaberite-sistematizacije");

    for(let i=0; i<response['organizacije'].length; i++){
        let opt = document.createElement('option');
        opt.value = response['organizacije'][i]['id'];
        console.log(response['organizacije'][i]['active']);
        if(parseInt(response['organizacije'][i]['active']) === 1) opt.innerHTML = response['organizacije'][i]['naziv'] + ' - Aktivna';
        else opt.innerHTML = response['organizacije'][i]['naziv'];
        organizacije.appendChild(opt);
    }
}

$(document.body).on("change",".daj-radna-mjesta-iz-sistematizacije",function(){
    let value = $(this).val();

    kreiraj_request('POST', '/radna-mjesta-iz-sistematizacije', "id=" + value, true, radnaMjestaizSistema);
});

function radnaMjestaizSistema(response){
    let radna_mjesta = document.getElementById("radna_mjestaa");

    $('#radna_mjestaa')
        .find('option')
        .remove();

    for(let i=0; i<response['radna_mjesta'].length; i++){
        var opt = document.createElement('option');
        opt.value = response['radna_mjesta'][i]['id'];
        opt.innerHTML = response['radna_mjesta'][i]['naziv_rm'];
        radna_mjesta.appendChild(opt);
    }
}
/**********************************************************************************************************************/

/********************************************************************************************************************* /
 *
 *      Obavijesti na naslovnoj stranici. U ovom odijeljku, imamo sljedeću situaciju :
 *
 *          - Kreira se obavijest za određenog korisnika ( administratora )
 *          - Ispiše se obavijest na naslovnoj
 *          - Da ne bi zauzimalo previše memorije i da bi se izbjegao slučaj ispisivanja previše informacija,
 *            korisnicima će biti omogućeno ( administratorima ) da te iste notifikacije na određeni način "Sakriju",
 *            putem AJAX forme i kreiranja jednostavnog HTTP requesta te nakon toga osvježavanjem čitave aplikacije.
 *
 **********************************************************************************************************************/

let notification_object = null;

function sakrijNotifikacije(object, not_id){
    notification_object = object;

    kreiraj_request('POST', '/notifikacije/oznaci_kao_procitano', "id=" + not_id, true, notifikacijeResponse);
    console.log(not_id);
}

function notifikacijeResponse(response){
    if(response['status'] === 'success'){
        // Obriši notifikaciju iz pregleda ako je moguće
        document.getElementById("notification-id-" + notification_object).remove();
        $.notify("Obavijest označena kao pročitana.", 'warn');
    }
}

$( window ).on("load", function() {
    let my_user_confirm   = $(".my-user-leggit-info").length ? true : false;
    let my_user_confirm_e = $(".my-user-leggit-info-edit").length ? true : false;

    if(my_user_confirm || my_user_confirm_e){
        $.notify("Uspješno ste spasili podatke o službeniku.", 'sucess');
    }
});
























































































