let this_year, this_month, this_day, this_day_w;

let this_months   = new Array("Januar", "Februar", "Mart", "April", "Maj", "Juni", "Juli", "August", "Septembar", "Oktobar", "Novembar", "Decembar");
let this_days_w   = new Array("Nedjelja", "Ponedjeljak", "Utorak", "Srijeda", "Četvrtak", "Petak", "Subota");
let this_days_w_s = new Array("Ned", "Pon", "Uto", "Sri", "Čet", "Pet", "Sub");
let this_months_d = new Array(31,28,31,30,31,30,31,31,30,31,30,31);

let just_date = null;

function create(y, m, d){
    if(y){
        just_date = new Date(y,m,d);
    }else just_date = new Date();

    this_year    = just_date.getFullYear();
    this_month   = just_date.getMonth();
    this_day     = just_date.getDate();
    this_day_w   = just_date.getDay();

    if(this_year % 4 === 0) this_months_d[1] = 29; // Ako je prestupna godina

 }



function get_year(){return this_year; } // get current year instance
function get_month(){return this_month; } // get current month instance
function get_day(){return this_day; } // get current day instance

// returns number of days for this month
function month_duration(){
    return this_months_d[this_month];
}


// returns last 7 days of previous month - or less than 7 days, depends on day current month starts
function last_month_days(){
    if(this_month === 0){
        // go back one day - we have 31 day
        return (31 - get_first_day() + 1);
    }else{
        return (this_months_d[this_month - 1] - get_first_day() + 1);
    }
}

// function for returning Month Name
function get_monthName(month){
    return this_months[this_month];
}
function get_previous_month_name(){
    if(this_month === 0) return this_months[11];
    else return this_months[this_month - 1];
}
function get_next_month_name(){
    if(this_month === 11) return this_months[0];
    else return this_months[this_month + 1];
}


// function for returnin Day Name
function get_dayName(day){
    if(day != null){
        return this_days_w[day];
    }else{
        return this_days_w[this_day_w];
    }
}

function get_shortDayName(index){
    return this_days_w_s[index];
}


// get first day of specific month - initial this month
function get_first_day(){
    just_date.setDate(1);
    return just_date.getDay();
}



// class myDate{
//     // if constructor parameters are null, we are facing this current month
//     constructor(y, m, d){
//         if(y){
//             this.date = new Date(y,m,d);
//         }else this.date   = new Date();
//
//
//         if(y){
//             console.log("Postojano !!");
//         }else console.log("Nema nikakvih parametara ... ");
//
//         this.year   = this.date.getFullYear();
//         this.month  = this.date.getMonth();
//         this.day    = this.date.getDate();
//         this.day_w  = this.date.getDay();
//
//
//         this.months   =
//         this.days_w   =
//         this.days_w_s =
//         this.months_d =
//         if(this.year % 4 == 0) this.months_d[1] = 29; // leap year
//
//         this.last_month_day = new Array();
//
//         /** working with month table **/
//         this.calendar = document.getElementsByClassName("calender_body")[0];
//     }
//
//     /** simple getters **/
//     get_year(){return this.year; } // get current year instance
//     get_month(){return this.month; } // get current month instance
//     get_day(){return this.day; } // get current day instance
//
//     // returns number of days for this month
//     month_duration(){
//         return this.months_d[this.month];
//     }
//
//
//     // returns last 7 days of previous month - or less than 7 days, depends on day current month starts
//     last_month_days(){
//         if(this.month == 0){
//             // go back one day - we have 31 day
//             return (31 - this.get_first_day() + 1);
//         }else{
//             return (this.months_d[this.month - 1] - this.get_first_day() + 1);
//         }
//     }
//
//     // function for returning Month Name
//     get_monthName(month = null){
//         return this.months[this.month];
//     }
//     get_previous_month_name(){
//         if(this.month == 0) return this.months[11];
//         else return this.months[this.month - 1];
//     }
//     get_next_month_name(){
//         if(this.month == 11) return this.months[0];
//         else return this.months[this.month + 1];
//     }
//
//
//     // function for returnin Day Name
//     get_dayName(day = null){
//         if(day != null){
//             return this.days_w[day];
//         }else{
//             return this.days_w[this.day_w];
//         }
//     }
//
//     get_shortDayName(index){
//         return this.days_w_s[index];
//     }
//
//
//     // get first day of specific month - initial this month
//     get_first_day(){
//         this.date.setDate(1);
//         return this.date.getDay();
//     }
// }


/******************************** **********************************/

var main_date = new Date();

var c_day = main_date.getDate(), c_month = main_date.getMonth(), c_year = main_date.getFullYear();
var t_day = main_date.getDate(), t_month = main_date.getMonth(), t_year = main_date.getFullYear();

var f_day = main_date.getDate(), f_month = main_date.getMonth(), f_year = main_date.getFullYear();

/******************************** ***********************************/

function set_top_of_calendar(month, year){ // ** set month day and year at the top of calendar ** //
    var title = document.getElementById("current_month_title");
    title.innerHTML = month + ' ' + year;
}

function this_day_ext(y, m, d, month_name){ // ** this is where magic happen ** //
    f_day = d; f_month = m; f_year = y;

    show_agenda(month_name);
}

function makeItHappenDelegate(y, m, d, month_name) { //make a function that returns function
    return function(){
        this_day_ext(y, m, d, month_name) //call the real function
    }
}

function delagate_clickable(what){
    if(what == 0) return function(){previous_month();}
}

function delegateDeleteDay(id){                            // Ovdje odlažemo pozivanje funkcije dinamički kreirane
    console.log("Delegate delete : " + id);
    return function(){
        kreiraj_request('POST', '/hr/odsustva/obrisi_odsustvo', "id=" + id, true, odzivKalendara);
    }
}
function delegateEdit(id){                              // Ovdje odlažemo pozivanje funkcije dinamički kreirane
    console.log("Delegate update : " + id);
    return function(){
        kreiraj_request('POST', '/hr/odsustva/odsustvo_json', "id=" + id, true, odzivKalendaraUredi);
    }
}

function odzivKalendaraUredi(what){
    document.getElementById("id_odsustva").value = what[0]['id']; // Postavi ID odsustva - UREĐUJEMO

    var vrsta_odsustva     = document.getElementById("vrsta_odsustva");
    var sluzbenik_id       = document.getElementById("sluzbenik_id");
    var datum_od           = document.getElementById("datum_od");
    var datum_do           = document.getElementById("datum_do");
    var putni_nalog        = document.getElementById("putni_nalog");
    var naknade            = document.getElementById("naknade");
    var troskovi           = document.getElementById("troskovi");
    var napomena           = document.getElementById("napomena");

    vrsta_odsustva.value = what[0]['vrsta_odsustva'];
    sluzbenik_id.value = what[0]['sluzbenik_id'];
    datum_od.value = what[0]['datum'];
    datum_do.value = what[0]['datum'];
    putni_nalog.value = what[0]['putni_nalog'];
    naknade.value = what[0]['naknade'];
    troskovi.value = what[0]['troskovi'];
    napomena.value = what[0]['napomena'];

    edit_vacation = true; // Uređujemo odsustvo

    openDialbox();
    currentMonth();
}

function odzivKalendara(what){
    currentMonth();
}

/**** get onclick events for previous and next month -- > day and year ******/
function previous_month_click(y, m){
    if(m == -1) return new Array(y-1, 11);
    else return new Array(y, m);
}
function next_month_click(y, m){
    if(m == 12) return new Array(y+1, 0);
    else return new Array(y, m);
}

var holidays_mark = false; // Ako hoćemo da ispišemo samo praznike, ovu varijablu postavljamo na vrijednost true
var edit_vacation = false; // Po defaultu je omogućeno da se unose 2 datuma (od - do)



function init_calendar(set_days, holidays) { // ** Update calendar ** //
    var url = "", extra_post = '';

    document.getElementById("loading_wrapper").style.display = 'block'; /** show loading part **/

    var calender = document.getElementsByClassName("calendar");


    create(c_year,c_month,c_day);                 // Sistematske varijable


    if(holidays){
        holidays_mark = holidays; // Očitavamo praznike samo
        url = '/hr/odsustva/daj_praznike';
    }else{
        url = '/hr/odsustva/daj_odsustvo';
        holidays_mark = false;
        var sluzbenik_id = document.getElementById("sluzbenik_id").value;
        extra_post = '&sluzbenik_id='+sluzbenik_id;
    }


    kreiraj_request('POST', url, "mjesec=" + parseInt(get_month() + 1) + "&godina=" + get_year() + extra_post, true, pregledPraznika);
}

function pregledPraznika(response){
    var calender = document.getElementsByClassName("calendar");
    calender[0].innerHTML = ''; // reset calender

    var days_counter = 0; // for counting days

    create(c_year,c_month,c_day);

    var last_month_days_ext = parseInt(last_month_days());
    var next_month_days = 1; // just counter for incerasing

    create_header(calender, holidays_mark, get_monthName() + ' ' + get_year()); // create clickable buttons

    var days_of_week = create();
    for(var i=0; i<7; i++){
        var day = document.createElement("div");
        day.className = "day day_b day_r day_merged";
        if(i == 6) day.className = "day day_merged day_b";

        var value = document.createElement("p");
        value.className = "day_of_week";
        value.innerHTML = get_dayName(i);

        day.appendChild(value);

        calender[0].appendChild(day);
    }


    create(c_year,c_month,c_day);


    for(var i=0; i<6; i++){
        for(var j=0; j<7; j++){
            var day = document.createElement("div");
            var class_b_n = "day"; // start with base class
            if(j < 6) class_b_n += ' day_r'; // add right border
            if(i < 5) class_b_n += ' day_b'; // add bottom border

            /* day number */
            var day_n = document.createElement("p");
            var num_class = "day_num";

            // ** start clocking days ** //
            if(i == 0 && j == get_first_day()) days_counter ++;
            if(days_counter && days_counter < month_duration() + 1){ /*************** This month *****************/
            day_n.innerHTML = days_counter;
                num_class += ' day_num_b'; // black color

                // add title to object
                var title = days_counter + ' ' + get_monthName() + ' ' + get_year() + '\n';

                if(response){
                    for(var k=0; k<response.length; k++){
                        if(holidays_mark) var r_date = response[k]['datum_praznika'].split('-');
                        else var r_date = response[k]['datum'].split('-');

                        var r_day = parseInt(r_date[2]); var r_month = parseInt(r_date[1]) - 1; var r_year = r_date[0];

                        // console.log("dan : " + r_day + ", mjesec : " + r_month);


                        if(r_day === days_counter && r_month === get_month()){
                            var header = document.createElement("h5");
                            if(holidays_mark) header.innerHTML = response[k]['naziv_praznika'];
                            else header.innerHTML = response[k]['odsustvo'];
                            day.appendChild(header);
                            class_b_n += " day_num_r";


                            if(!holidays_mark){
                                /***************************************************************************************
                                 *
                                 *      Kreiraj font awesome ikonu, koja se trigeruje na onclick event i obriše odsustvo.
                                 *      Reload je dinamički, putem ajax-a gdje se reloada samo treutni mjesec.
                                 *
                                 ***************************************************************************************/


                                var delete_it = document.createElement("i");
                                delete_it.className = "fas fa-trash";
                                delete_it.title = "Obrišite odsustvo";

                                delete_it.addEventListener("click", delegateDeleteDay(response[k]['id']));
                                day.appendChild(delete_it);


                                /***************************************************************************************
                                 *
                                 *      Kreiraj font awesome ikonu, koja se trigeruje na onclick event i otvori identičnu
                                 *      formu za kreiranje odsustva, samo sa popunjenim podacima.
                                 *
                                 **************************************************************************************/

                                var edit_it = document.createElement("i");
                                edit_it.className = "fas fa-edit";
                                edit_it.title = "Uredite odsustvo";

                                edit_it.addEventListener("click", delegateEdit(response[k]['id']));

                                day.appendChild(edit_it);
                            }

                            // response['headers'][k] = response['headers'][k].replace("<span>", "").replace("</span>", "");
                            //just_header += ();

                            // title += (' \n ' + response['headers'][k]);
                        }
                    }
                }

                day.title = title;

                // add onclick event listener
                // day.addEventListener("click", makeItHappenDelegate(date.get_year(), date.get_month(), days_counter, date.get_monthName()), false);
                days_counter ++;
            }else if(days_counter > month_duration()){ /*************** Next month *****************/
            day_n.innerHTML = next_month_days;
                if(i == 5 && j == 0) return;
                class_b_n += ' day_num_g'; // grey color
                next_month_days++;
            }

            // ** PREVIOUS MONTH ** //
            if(!days_counter ){ /************** Previous month month ***************/
            day_n.innerHTML = last_month_days_ext;
                class_b_n += ' day_num_g'; // grey color
                last_month_days_ext++;
            }

            day_n.className = num_class;
            day.appendChild(day_n);
            /* end of day number */


            day.className = class_b_n; // assign class to object
            calender[0].appendChild(day); // append object to calendar
        }
    }
}



function create_header(calendar, holidays, name_of_month){
    var buttons_w = document.createElement("div");
    buttons_w.className = "calendar_buttons";

    var first_button = document.createElement("div");
    // day.addEventListener("click", makeItHappenDelegate(previous_month_click());
    first_button.onclick = function(){previous_month();}
    first_button.className = "butt first_butt";
    var first_button_v = document.createElement("p");
    first_button_v.innerHTML = 'Prijašnji mjesec';
    first_button.appendChild(first_button_v);
    buttons_w.appendChild(first_button);

    var second_button = document.createElement("div");
    second_button.className = "butt second_butt";
    second_button.onclick = function(){this_month_ext();}
    var second_button_v = document.createElement("p");
    second_button_v.innerHTML = 'Ovaj mjesec';
    second_button.appendChild(second_button_v);
    buttons_w.appendChild(second_button);

    var third_button = document.createElement("div");
    third_button.className = "butt third_butt";
    third_button.onclick = function(){next_month();}
    var third_button_v = document.createElement("p");
    third_button_v.innerHTML = 'Sljedeći mjesec';
    third_button.appendChild(third_button_v);
    buttons_w.appendChild(third_button);

    var current_month = document.createElement("div");
    current_month.className = "currentMonth";
    var current_month_v = document.createElement("p");
    current_month_v.innerHTML = name_of_month;
    current_month.appendChild(current_month_v);
    buttons_w.appendChild(current_month);

    if(!holidays){
        var add_something = document.createElement("div");
        add_something.className = "butt last_butt";
        add_something.onclick = function(){openDialbox(true);}
        var add_something_p = document.createElement("p");
        add_something_p.innerHTML = "Registrujte odsustvo";
        add_something.appendChild(add_something_p);
        buttons_w.appendChild(add_something);
    }


    calendar[0].appendChild(buttons_w);
}

/*********** SWITCH MONTHS ******************/

function this_month_ext(){ /** go to this month **/
    c_year = t_year; c_month = t_month; c_day = t_day;
    init_calendar(1, holidays_mark);
}


function next_month(){ /** go to next month **/
    if(c_month == 11){
        c_month = 0; c_year += 1;
    }else c_month ++;
    init_calendar(1, holidays_mark);
}


function previous_month(){ /** go to previous month **/
    if(c_month == 0){
        c_month = 11; c_year -= 1;
    }else c_month --;
    init_calendar(1, holidays_mark);
}

function currentMonth(){
    console.log("Initializin new instance of calender .. ");
    init_calendar(1, holidays_mark);
}





var opened_dialbox = false;

function openDialbox(initial){
    var dialBox = document.getElementsByClassName("registruj_odsustvo")[0];


    if(initial){

        /* kada hoćemo da unesemo novo odsustvo, onda nam treba datum od - do
           u protivnom, ako želimo da izmijenimo odsustvo, mijenjamo ga samo za jedan dan ..
         */

        document.getElementById("datum_do_w").style.display = 'block';
        document.getElementById("datum_od_label").innerHTML = 'Datum od :';
    }else{
        document.getElementById("datum_do_w").style.display = 'none';
        document.getElementById("datum_od_label").innerHTML = 'Datum :';
    }

    if(!opened_dialbox){
        dialBox.style.display = 'block';
        opened_dialbox = true;
    }else{
        dialBox.style.display = 'none';
        opened_dialbox = false;
        inset_new_leav(); // Očisti sve forme , tj postavi ih na vrijednost null
    }
}



/******************************************** SPREMITE ODSUSTVO *******************************************************/


function unesiOdsustvo(){
    var vrsta_odsustva     = document.getElementById("vrsta_odsustva").value;
    var sluzbenik_id       = document.getElementById("sluzbenik_id").value;
    var datum_od           = document.getElementById("datum_od").value;
    var datum_do           = document.getElementById("datum_do").value;
    var putni_nalog        = document.getElementById("putni_nalog").value;
    var naknade            = document.getElementById("naknade").value;
    var troskovi           = document.getElementById("troskovi").value;
    var napomena           = document.getElementById("napomena").value;

    var id_odsustva_o      = document.getElementById("id_odsustva");
    var extra_link         = '';
    var url               = '/hr/odsustva/spasi_odsustvo';

    var id_odsustva = parseInt(id_odsustva_o.value);



    if(id_odsustva != 0){
        // Updejtujemo odsustvo
        extra_link = '&id='+id_odsustva;
        url = '/hr/odsustva/azuriraj_odsustvo';

        id_odsustva_o.value = 0; // Resetujemo ovo
    }


    var link = "vrsta_odsustva=" + vrsta_odsustva + "&sluzbenik_id=" + sluzbenik_id + "&datum_od=" + datum_od + "&datum_do=" + datum_do + '&putni_nalog=' + putni_nalog + "&naknade=" + naknade + "&troskovi=" + troskovi + "&napomena=" + napomena + extra_link;

    kreiraj_request('POST', url , link, true, pregledOdsustva);
}

function pregledOdsustva(response){
    openDialbox();

    if(response['status'] == 'error'){
        // console.log(response['message'])
    }else{
        currentMonth();
    }
}


function inset_new_leav(){
    var odsustva = document.getElementById("inset_new_leav").getElementsByClassName("form-control");

    for(var i=0; i<odsustva.length; i++){
        if(odsustva[i].nodeName == 'INPUT' || odsustva[i].nodeName == 'TEXTAREA'){
            odsustva[i].value = '';
        }else{
            odsustva[i].selectedIndex = 0;
        }
    }
}


/********************************************** LISTA ODSUSTAVA *******************************************************/

function go_to(){ // ovdje trigerujemo on change event za odlazak u određeni period
    var od_ = document.getElementById('period_od').value;
    var do_ = document.getElementById('period_do').value;
    var id  = document.getElementById("sluzbenik_id").value;

    window.location = '/hr/odsustva/lista_odsustava/' + od_ + '/' +  do_ + '/' + id;
}



































































