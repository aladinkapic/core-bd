var currently_open = -2, currently_open_2 = -2;

/********************************************************************************************************************* /
 *
 *      Funkcija prikazi elemente, dobija dva parametra, jedan od njih je index (redni broj HTML elementa) koji se
 *      otkriva. U slučaju da želimo da otvorimo "dodaj novi dio" , onda šaljemo naziv klase.
 *
 *      Index je potrebno svaki put ručno inkrementirati, paziti na to !!!
 *
 **********************************************************************************************************************/


function prikazi_elemente(index, clsName){
    if(!clsName) clsName = 'predefined_elements';
    var subcategories = document.getElementsByClassName(clsName);
    var arrow = document.getElementsByClassName("arrow-icon");

    console.log("wee");

    if(clsName == 'predefined_elements'){
        if(index == currently_open){
            index = -1;
            currently_open = -2;
        }
    }else{
        if(index == currently_open_2){
            index = -1;
            currently_open_2 = -2;
        }
    }

    for(var i=0; i<subcategories.length; i++){
        if(i == index){
            // var all_subcategories = subcategories[i].getElementsByClassName("menu_subcategory");

            if(clsName == 'predefined_elements') currently_open = index;
            else  currently_open_2 = index;


            if(clsName == 'predefined_elements') arrow[i].className = "fas arrow-icon fa-chevron-up";
            // subcategories[i].style.height = (all_subcategories.length * 34) + 'px';
            subcategories[i].style.display = 'block';
        }else{
            if(clsName == 'predefined_elements') arrow[i].className = "fas arrow-icon fa-chevron-down";
            subcategories[i].style.display = 'none';
        }
    }
}

/********************************************************************************************************************* /
 *
 *      Ova funkcija služi za otvaranje polja za editovanje. Pošto su po defaultu na readonly, klikom na ikonicu edit
 *      otvara se mogućnsot editovanja određene forme.
 *
 *
 *      Globalne varijable služe da bi ovaj dio sa "otvori zatvori" i ikonama radio kako treba.
 *
 *      NOTE : Prilikom "kreiranja polja za funkciju" potrebno je ručno inkrementirati index !!!
 *
 *      -- Nadalje, treba dodati za polja koja želimo da imaju funkciju readonly - property readonly
 *      -- Provjeriti class name od svih HTML elemenata - u slučaju da ne bude radilo !!
 *
 **********************************************************************************************************************/

var edit_index = -2, edit_counter = -2;
var edit_open = false;

function edit_property(index, counter){
    var subcategories = document.getElementsByClassName('predefined_elements')[index];
    var wrappers      = subcategories.getElementsByClassName('input_element' + counter)[0]
    var inputs        = wrappers.getElementsByClassName("read_stuffs");

    var button        = wrappers.getElementsByClassName("btn")[0];
    var edit_icoon    = wrappers.getElementsByClassName("edit_icoon")[0];


    if(index == edit_index && counter == edit_counter){
        edit_icoon.className = 'fas edit_icoon fa-edit';
        edit_index = -2; edit_counter = -2;

        for(var i=0; i<inputs.length; i++){
            if(inputs[i].nodeName == 'INPUT') inputs[i].readOnly = true;
            else if(inputs[i].nodeName == 'SELECT') inputs[i].disabled = true;
        }

        button.style.display = 'none';

        return;
    }else{
        edit_icoon.className = 'fas edit_icoon fa-times';

        for(var i=0; i<inputs.length; i++){

            console.log(inputs[i].nodeName );
            if(inputs[i].nodeName == 'INPUT') inputs[i].readOnly = false;
            else if(inputs[i].nodeName == 'SELECT') inputs[i].disabled = false;
        }

        button.style.display = 'block';
    }

    // for(var i=0; i<subcategories.length; i++){
    //     if(i == index){
    //         for(var j=0; j<wrappers.length; j++){
    //             wrappers[j].className ==
    //         }
    //     }
    // }

    edit_index = index;
    edit_counter = counter;
}