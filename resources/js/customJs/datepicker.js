var customIDs = new Array('period_od', 'period_do');

function delegateClick(id, day, month, year){
    return function(){
        setDateAndTime(id, day, month, year);
    }
}


function setDateAndTime(id, day, month, year){
    if(parseInt(day) < 10) day = "0" + day;
    if(parseInt(month) < 10) month = "0" + month;

    document.getElementById(id).value = day + '.' + month + '.' + year;
    killCustomCalendar();

    for(var i=0; i<customIDs.length; i++){
        if(id === customIDs[i]){
            console.log("Find for redirecting ..");
            go_to();
        }
    }

}

function delegateFocus(id){
    return function(){
        initCustomCalendar(id);
    }
}

function delegateBlur(id){
    return function(){
        killCustomCalendar(id);
    }
}

var calendar_id_custom, calendar_parent_custom, calendar_open = false;


function initCustomCalendar(id){
    var parent = document.getElementById(id).parentElement;
    calendar_parent_custom = parent;
    calendar_id_custom = id;
    calendar_open = true;


    // delete all of them
    var calendars  = document.getElementsByClassName("mini_calendar");
    for(var i=0; i<calendars.length; i++){
        calendars[i].remove();
    }

    pickDate(id, parent);
}

function killCustomCalendar(){
    var elem = document.getElementById(calendar_id_custom + '_calendar');
    elem.remove();
    calendar_open = false;
}

// initCustomCalendar('usr1');

$(document).ready(function () {

    // focus - show pikcer
    $(".datepicker").focus(function(){
        var id = $(this).attr('id');
        supreme_id = id;
        initCustomCalendar(id);
    });

    // hide picker

    $("*").click(function (event){
        if(calendar_open){
            // Imamo jedan otvoren kalendar, i trebamo ga zatvoriti

            // console.log("Clicked ... ");
            if(
                event.target.className === 'day' ||
                event.target.className === 'day_num' ||
                event.target.className === 'form-control datepicker' ||
                event.target.className === 'form-control read_stuffs datepicker' ||
                event.target.className === 'form-control datepicker required' ||
                event.target.className === 'butt first_butt' ||
                event.target.className === 'butt third_butt' ||
                event.target.className === 'fas fa-chevron-right' ||
                event.target.className === 'months years' ||
                event.target.className === 'months' ||
                event.target.className === 'textwee' ||
                event.target.className === 'single_row' ||
                event.target.className === 'single_row_value' ){

                // console.log("Bingo ... ");
            }else{
                killCustomCalendar();
                 // console.log("Kill it !! " + event.target.className);
            }
        }
    });

    $(".datepicker").keydown(function(e){
       var id = $(this).attr('id');
       if(id === calendar_id_custom){
           e.preventDefault();
           return false;
       }
    });

});

function pickDate(id_of_element, parent){
    if(!id_of_element) id_of_element = 'Probni elemenat';

    var calender = document.createElement("div");
    calender.className = 'calendar mini_calendar';
    calender.id = id_of_element + '_calendar';


    parent.appendChild(calender);
    // var calender = document.getElementsByClassName("calendar");
    // calender[0].innerHTML = ''; // reset calender
    calender.innerHTML = '';

    var days_counter = 0; // for counting days

    create(c_year,c_month,c_day);
    var last_month_days_ext = parseInt(last_month_days());
    var next_month_days = 1; // just counter for incerasing


    create_header_cust(calender, false, get_monthName() + ' ' + get_year()); // create clickable buttons

    // Add year and month picker
    create_footer_cust(calender);


    create();
    for(var i=0; i<7; i++){
        var day = document.createElement("div");
        day.className = "day day_b day_r day_merged";
        if(i == 6) day.className = "day day_merged day_b";

        var value = document.createElement("p");
        value.className = "day_of_week day_of_week222";
        value.innerHTML = get_shortDayName(i);

        day.appendChild(value);

        calender.appendChild(day);

    }
    create(c_year,c_month,c_day);

    for(var i=0; i<6; i++){
        for(var j=0; j<7; j++){
            var day = document.createElement("div");
            var class_b_n = "day"; // start with base class

            /* day number */
            var day_n = document.createElement("p");
            var num_class = "day_num";

            // ** start clocking days ** //
            if(i === 0 && j === get_first_day()) days_counter ++;
            if(days_counter && days_counter < month_duration() + 1){ /*************** This month *****************/
            day_n.innerHTML = days_counter;
                // num_class += ' day_num_b'; // black color

                // add title to object
                var title = days_counter + ' ' + get_monthName() + ' ' + get_year() + '\n';

                day.title = title;

                /** pick date and put it into form **/
                day.addEventListener("click", delegateClick(id_of_element, days_counter, get_month() + 1, get_year()));

                // add onclick event listener
                // day.addEventListener("click", makeItHappenDelegate(date.get_year(), date.get_month(), days_counter, date.get_monthName()), false);
                days_counter ++;
            }else if(days_counter > month_duration()){ /*************** Next month *****************/
            day_n.innerHTML = next_month_days;
                if(i === 5 && j === 0) break;
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
            calender.appendChild(day); // append object to calendar
        }
    }
}



function create_header_cust(calendar, holidays, name_of_month){
    var buttons_w = document.createElement("div");
    buttons_w.className = "calendar_buttons";

    var first_button = document.createElement("div");
    // day.addEventListener("click", makeItHappenDelegate(previous_month_click());
    first_button.onclick = function(){previous_month_datepick();}
    first_button.className = "butt first_butt";
    var first_button_v = document.createElement("p");
    first_button_v.innerHTML = '<i class="fas fa-chevron-left"></i>';
    first_button.appendChild(first_button_v);
    buttons_w.appendChild(first_button);

    var third_button = document.createElement("div");
    third_button.className = "butt third_butt";
    third_button.onclick = function(){next_month_datepick();}
    var third_button_v = document.createElement("p");
    third_button_v.innerHTML = '<i class="fas fa-chevron-right"></i>';
    third_button.appendChild(third_button_v);
    buttons_w.appendChild(third_button);

    var current_month = document.createElement("div");
    current_month.className = "currentMonth";
    var current_month_v = document.createElement("p");
    current_month_v.innerHTML = name_of_month;
    current_month.appendChild(current_month_v);
    buttons_w.appendChild(current_month);


    calendar.appendChild(buttons_w);
}


// Trigerovanje kada idemo sa opcijom izaberi mjesec odnosno godinu

let custom_pick_month = null; let open_scrolls = false;


function delegateSpecialDate(what, value){
    return function(){
        resetSpecialDate(what, value);
    }
}

function delegateShowAdditional(parent, what){
    return function (){
        showAdditional(parent, what);
    }
}

function resetSpecialDate(what, value){
    if(what === 'months'){
        c_month = value;
        killCustomCalendar();
        pickDate(calendar_id_custom , calendar_parent_custom);
    }else{
        c_year = value;
        killCustomCalendar();
        pickDate(calendar_id_custom , calendar_parent_custom);
    }
}

function showAdditional(parent, what){
    parent.innerHTML = '';

    if(what === 'months'){
        console.log("Signing in ..");
        for(var i=0; i<this_months.length; i++){
            var inst = document.createElement("div");
            inst.className = "single_row";
            inst.addEventListener("click", delegateSpecialDate('months', i));
            // inst.style.width = "100%";
            // inst.style.height = "30px";
            // inst.style.position = "relative";

            var inst_v = document.createElement("p");
            inst_v.innerHTML = this_months[i];
            inst_v.className = "single_row_value";
            inst.appendChild(inst_v);

            parent.appendChild(inst);
        }
    }else{
        let from = this_year + 10;



        for(var i=0; i<70; i++){
            var inst = document.createElement("div");
            inst.className = "single_row";
            inst.addEventListener("click", delegateSpecialDate('years', from));
            // inst.style.width = "100%";
            // inst.style.height = "30px";
            // inst.style.position = "relative";

            var inst_v = document.createElement("p");
            inst_v.innerHTML = from--;
            inst_v.className = "single_row_value";
            inst.appendChild(inst_v);

            parent.appendChild(inst);
        }
    }

    if(!open_scrolls){
        document.getElementsByClassName("preview_all")[0].style.width = '220px';
        open_scrolls = true;
    }else{
        document.getElementsByClassName("preview_all")[0].style.width = '0px';
        open_scrolls = false    ;
    }

}

function create_footer_cust(calendar){
    let months_previev = document.createElement("div");
    months_previev.className = 'preview_all';
    months_previev.innerHTML = '';

    var mon_w = document.createElement("div");
    mon_w.className = "dodatni_mjeseci";

    let months = document.createElement("div");

    //////// OVDJE TREBAMO ODRADITI DELAYED CLICK
    months.addEventListener("click", delegateShowAdditional(months_previev, 'months'));
    // months.onclick = function(){show_additional();}
    months.className = 'months';
    let months_prev = document.createElement("p");
    months_prev.className = "textwee";
    months_prev.innerHTML = this_months[this_month];
    let months_prev_arrow = document.createElement("i");
    months_prev_arrow.className = "fas fa-chevron-right";

    months.appendChild(months_prev_arrow);
    months.appendChild(months_prev);
    mon_w.appendChild(months);



    let years = document.createElement("div");
    years.className = 'months years';
    years.addEventListener("click", delegateShowAdditional(months_previev, 'years'));
    // years.onclick = function(){show_additional('years');}
    let years_prev = document.createElement("p");
    years_prev.className = "textwee";
    years_prev.innerHTML = this_year;
    let years_prev_arrow = document.createElement("i");
    years_prev_arrow.className = "fas fa-chevron-right";


    years.appendChild(years_prev_arrow);
    years.appendChild(years_prev);
    mon_w.appendChild(years);

    calendar.appendChild(months_previev);
    calendar.appendChild(mon_w);
}


function this_month_datepick(){ /** go to this month **/
c_year = t_year; c_month = t_month; c_day = t_day;
    killCustomCalendar();
    pickDate();
}


function next_month_datepick(){ /** go to next month **/
    if(c_month == 11){
        c_month = 0; c_year += 1;
    }else c_month ++;
    killCustomCalendar();
    pickDate(calendar_id_custom , calendar_parent_custom);
}


function previous_month_datepick(){ /** go to previous month **/
    if(c_month == 0){
        c_month = 11; c_year -= 1;
    }else c_month --;
    killCustomCalendar();
    pickDate(calendar_id_custom , calendar_parent_custom);
}

function currentMonth_datepick(){
    console.log("Initializin new instance of calender .. ");
    pickDate(calendar_id_custom , calendar_parent_custom);
}
