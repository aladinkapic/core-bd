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
    just_setDate(1);
    return just_getDay();
}






/******************************** **********************************/

var main_date = new Date();

var c_day = main_getDate(), c_month = main_getMonth(), c_year = main_getFullYear();
var t_day = main_getDate(), t_month = main_getMonth(), t_year = main_getFullYear();

var f_day = main_getDate(), f_month = main_getMonth(), f_year = main_getFullYear();

/******************************** ***********************************/

function set_top_of_calendar(month, year){ // ** set month day and year at the top of calendar ** //
    var title = document.getElementById("current_month_title");
    title.innerHTML = month + ' ' + year;
}

function this_day_ext(y, m, d, month_name){ // ** this is where magic happen ** //
    console.log("Datum : " + d + ' ' + month_name + ' ' + y);
    f_day = d; f_month = m; f_year = y;

    show_agenda(month_name);
}

function makeItHappenDelegate(y, m, d, month_name) { //make a function that returns function
    return function(){
        this_day_ext(y, m, d, month_name) //call the real function
    }
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

function init_calendar(){ // ** Update calendar ** //
    var calender = document.getElementsByClassName("calender_body");

    calender[0].innerHTML = ''; // reset calender

    var days_counter = 0; // for counting days

    create(c_year,c_month,c_day);
    var last_month_days_ext = parseInt(last_month_days());
    var next_month_days = 1; // just counter for incerasing


    // ** Set title of calendar ** //
    set_top_of_calendar(get_monthName(), get_year());



    /*** WHAT WE ARE SEARCING FOR ***/
    console.log("User id : " + company_ajdi);

    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);

            console.log(response);

            for(var i=0; i<6; i++){
                for(var j=0; j<7; j++){
                    var day = document.createElement("div");
                    var class_b_n = "single_day"; // start with base class
                    if(j < 6) class_b_n += ' single_day_r'; // add right border
                    if(i < 5) class_b_n += ' single_day_b'; // add bottom border



                    /* day number */
                    var day_n = document.createElement("p");
                    var num_class = "day_num";


                    // ** start clocking days ** //
                    if(i == 0 && j == get_first_day()) days_counter ++;


                    if(days_counter && days_counter < month_duration() + 1){ /*************** This month *****************/
                    day_n.innerHTML = days_counter;
                        num_class += ' day_num_b'; // black color

                        if(t_day == days_counter && get_month() == t_month && get_year() == t_year ){
                            class_b_n += ' single_day_back1';
                            document.getElementById("agenda_date").innerHTML = f_day + '. ' + get_monthName() + ' ' + f_year + '. godine'; // ** Set date on agenda ** //
                        }
                        // add title to object
                        var title = days_counter + ' ' + get_monthName() + ' ' + get_year() + '\n';

                        for(var k=0; k<response['d'].length; k++){
                            if(response['d'][k] == days_counter && response['m'][k] == get_month()){
                                var header = document.createElement("h5");
                                header.innerHTML = response['headers'][k];
                                day.appendChild(header);

                                class_b_n += ' single_day_back2';

                                response['headers'][k] = response['headers'][k].replace("<span>", "").replace("</span>", "");
                                //just_header += ();

                                title += (' \n ' + response['headers'][k]);
                            }
                        }

                        day.title = title;

                        // add onclick event listener
                        // day.addEventListener("click", makeItHappenDelegate(get_year(), get_month(), days_counter, get_monthName()), false);
                        days_counter ++;
                    }


                    else if(days_counter > month_duration()){ /*************** Next month *****************/
                    day_n.innerHTML = next_month_days;
                        num_class += ' day_num_g'; // grey color

                        // add onclick event listener
                        // day.addEventListener("click", makeItHappenDelegate(next_month_click(get_year(), get_month() + 1)[0], next_month_click(get_year(), get_month() + 1)[1], next_month_days, get_next_month_name()), false);
                        next_month_days++;
                    }



                    // ** PREVIOUS MONTH ** //
                    if(!days_counter ){ /************** Previous month month ***************/
                    day_n.innerHTML = last_month_days;
                        num_class += ' day_num_g'; // grey color

                        // add onclick event listener
                        // day.addEventListener("click", makeItHappenDelegate(previous_month_click(get_year(), get_month() - 1)[0], previous_month_click(get_year(), get_month() - 1)[1], last_month_days, get_previous_month_name()), false);
                        last_month_days++;
                    }

                    day_n.className = num_class;
                    day.appendChild(day_n);
                    /* end of day number */



                    day.className = class_b_n; // assign class to object
                    calender[0].appendChild(day); // append object to calendar
                }
            }
        }
    };
    xml.open('POST', "admin/parts/facebook/get_titles.php");

    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xml.send("user_id=" + company_ajdi + "&d=" + f_day + "&m=" + f_month + "&y=" + f_year);
}

/*********** SWITCH MONTHS ******************/

function this_month_ext(){ /** go to this month **/
c_year = t_year; c_month = t_month; c_day = t_day;
    init_calendar();
}


function next_month_ext(){ /** go to next month **/
    if(c_month == 11){
        c_month = 0; c_year += 1;
    }else c_month ++;
    init_calendar();
}


function previous_month_ext(){ /** go to previous month **/
    if(c_month == 0){
        c_month = 11; c_year -= 1;
    }else c_month --;
    init_calendar();
}