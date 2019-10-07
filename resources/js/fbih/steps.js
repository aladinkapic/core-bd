/***********************************************************************************************************************
 *
 *      Fancy steps made by Infodom.ba
 *
 ***********************************************************************************************************************
 *
 *
 *
 *
 *
 *
 *
 *
 ***********************************************************************************************************************/

(function (original) {
    $.fn.clone = function () {
        var result           = original.apply(this, arguments),
            my_textareas     = this.find('textarea').add(this.filter('textarea')),
            result_textareas = result.find('textarea').add(result.filter('textarea')),
            my_selects       = this.find('select').add(this.filter('select')),
            result_selects   = result.find('select').add(result.filter('select'));

        for (var i = 0, l = my_textareas.length; i < l; ++i) $(result_textareas[i]).val($(my_textareas[i]).val());
        for (var i = 0, l = my_selects.length;   i < l; ++i) result_selects[i].selectedIndex = my_selects[i].selectedIndex;

        return result;
    };
}) ($.fn.clone);


var serialize = require('form-serialize');

window.myStepps = function(options){

    /* Variables accessible in the class */
    var vars = {
        wrapper : $("#steps"),
        name    : 'steps',
        data    : null,
        header  : 'original Value',
        values  : null,   // all values for steps
        icons   : null,   // icons inside steps - have to be added manually just like values

        /** here are http request values **/
        send    : true,   // if we want to stop after last step
        ajax    : true,   // if we want to use ajax
        url     : null,   // if we use ajax, we need to set url for ajax form
        submit  : false,  // if we want to use form submit
        goto    : '',     // url to redirect after success submition of form
        buttons : true,   // If we do not want to create any buttons or key-up form detect

        /** check if we have any errors **/
        errors  : new Array(),
        error_h : true,

        /** X-CSRF TOKEN -- Laravel **/
        csrf    : true,
    };

    var messages = {
        email   : 'Kontent nema formu email-a !',
        number  : 'Sadržaj ne smije sadržavati druge karaktere osim cifara',
        jmbg    : 'Sadržaj smije sadržavati tačno 13 znakova !',
        required: 'Polje ne smije biti prazno !',
    };

    /*
     |--------------------------------------------------------------------------------------------------------------
     |      X-CSRF TOKEN - LARAVEL
     |--------------------------------------------------------------------------------------------------------------
     |
     |     There is one great thing, we can set by default X-CSRF token for laravel. If we do not use Laravel,
     |     we can disable this option. By default, it's enabled !!
     |
     */
    let setCSRF = function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    };
    this.enableCSRF = function () { vars.csrf = true; }
    this.disableCSRF = function () { vars.csrf = false; }


    var wrapperID = "steps";

    /* Can access this.method inside other methods using root.method() */
    var root = this;

    /* Constructor */
    this.construct = function(options){
        $.extend(vars , options);

        /** Here we set new ID for our main wrapper - if sent thru parameters **/
        if(!vars.wrapper.length) console.log("There is no wrapper elements. Please, add some !!");

        // Here, lets create ul and li elements inside steps
        createElements();
    };


    /**************************************************************************************************************/
    /** Private method Can only be called inside class **/
    /*
     |--------------------------------------------------------------------------------------------------------------
     |      CREATE ELEMENTS
     |--------------------------------------------------------------------------------------------------------------
     |
     |      Lets just create all header elements, new dynamic steps, add them some style via css;
     |      We also here set shaking elements
     |
     */
    let createElements = function(){
        // Create ul and li elements -- set with of li
        vars.wrapper.prepend("<ul class='steps-ul'> </ul>");  // Append UL

        let active_cl = "";
        for(let i=0; i<vars.values.length; i++){
            (i === 0) ? active_cl = "active" : active_cl = "";
            if(vars.values.length > 5){
                // If we have more than 5 steps, we need to reduce them to five
                if(i > 3 && i !== (vars.values.length - 1)){
                    active_cl += 'steps-hidden';
                }

                if(i === (vars.values.length - 1)) active_cl += 'steps-left-lines';
                else if(i === 3) active_cl += 'steps-right-lines';
            }


            $(".steps-ul").append(
                "<li class=' " + active_cl + " '> "
                + "<div class='steps-back-left'></div> <div class='steps-back-right'></div>"
                + "<div class='steps-circle'>" + vars.icons[i] + "</div>"
                + "<p>" + vars.values[i] + "</p>" +
                "</li>"
            );
        }

        // Work with sections -- here we just set the class of active to the first element : )
        let sections = vars.wrapper.children("section").each(function(index = 0){
            (index === 0) ? $(this).addClass("active-section") : '';
        });

        if(vars.buttons){
            vars.wrapper.append("<div class='steps-buttons'> </div>");
            $(".steps-buttons").append(
                "<div class='step-button step-previous'> <p>Prethodno</p> </div>" +
                "<div class='step-button step-next'> <p>Sljedeće </p> </div>"
            );
        }

        /** When we have less than 4 steps, we need to resize their width so we can set them **/
        if(vars.values.length === 1){
            vars.wrapper.find("li").css("width", vars.wrapper.width() + 'px');
            changeButtons();
        }else if(vars.values.length === 2){
            vars.wrapper.find("li").css("width", (vars.wrapper.width() / 2) + 'px');
        }else if(vars.values.length === 3){
            vars.wrapper.find("li").css("width", (vars.wrapper.width() / 3) + 'px');
        }
    };

    /*
     |--------------------------------------------------------------------------------------------------------------
     |      SHAKE ELEMENTS
     |--------------------------------------------------------------------------------------------------------------
     |
     |      Here we need to properly set elements, some of then show and some of them hide. Next after that,
     |      we are dealing with problem "extend elements" ;
     |      Problem solved by custom adding CSS and setting some of them :: ONLY IF WE HAVE MORE THAN FIVE
     |
     */

    let shakeElements = function () {
        if(vars.values.length > 5){
            // If we have more than 5 steps, we need to reduce them to five
            for(var i=0; i<vars.values.length; i++){
                // First delete all classes -> after that, put some new
                vars.wrapper.find("li:eq( " + i + " )").removeClass('steps-right-lines');
                vars.wrapper.find("li:eq( " + i + " )").removeClass('steps-left-lines');
                vars.wrapper.find("li:eq( " + i + " )").addClass('steps-hidden');

                if(i === 0) vars.wrapper.find("li:eq( " + i + " )").removeClass('steps-hidden');
                if(i >= vars.wrapper.find("ul .active").index() && i < (vars.wrapper.find("ul .active").index() + 3)){
                    vars.wrapper.find("li:eq( " + i + " )").removeClass('steps-hidden');
                }
                if(i === (vars.values.length - 1)) vars.wrapper.find("li:eq( " + i + " )").removeClass('steps-hidden');


                // Lets check current active
                if(vars.wrapper.find("ul .active").index() >= (vars.values.length - 4) && i >= (vars.values.length - 4)){
                    vars.wrapper.find("li:eq( " + i + " )").removeClass('steps-hidden');
                }

                // If we want last 4 of them to stay
                if(vars.wrapper.find("ul .active").index() === 0) vars.wrapper.find("li:eq( " + 3 + " )").removeClass('steps-hidden');


                // Change background colors
                if(vars.wrapper.find("ul .active").index() <= (vars.values.length - 5)){

                    if(i === (vars.values.length - 1)) vars.wrapper.find("li:eq( " + i + " )").addClass('steps-left-lines');
                    if(vars.wrapper.find("ul .active").index() === 0){
                        if(i === (vars.wrapper.find("ul .active").index() + 3) ) vars.wrapper.find("li:eq( " + i + " )").addClass('steps-right-lines');
                    }else{
                        if(i === (vars.wrapper.find("ul .active").index() + 2) ) vars.wrapper.find("li:eq( " + i + " )").addClass('steps-right-lines');
                    }
                }

                if(vars.wrapper.find("ul .active").index() >= 2){
                    if(i === 0) vars.wrapper.find("li:eq( " + i + " )").addClass('steps-right-lines');
                    if(vars.wrapper.find("ul .active").index() >= (vars.values.length - 4)){
                        vars.wrapper.find("li:eq( " + (vars.values.length - 4) + " )").addClass('steps-left-lines')
                    }
                    else if(i === vars.wrapper.find("ul .active").index()) vars.wrapper.find("li:eq( " + i + " )").addClass('steps-left-lines');
                }
            }
        }
    };

    /*
     |--------------------------------------------------------------------------------------------------------------
     |      BUTTONS
     |--------------------------------------------------------------------------------------------------------------
     |
     |      If we reach the end, it's normal to change value of right button to "finish-it" or something like that,
     |      and give it a some link, final value or form submit !!
     |
     */
    let changeButtons = function() {
        if(!vars.buttons) return;
        let empty = $(".step-next").empty();

        // Change button value and add some link which can be added manually later or when creating object
        if(vars.wrapper.find("ul .active").index() === (vars.values.length - 1) || vars.values.length === 1){
            if(vars.send){
                if(vars.values.length === 1){
                    $(".step-previous").css('display', 'none');
                }
                if(vars.send){
                    $(".step-next").append("<p>Spremite promjene</p>").addClass('step-button-colorful');
                }
            }else{
                if(vars.values.length === 1){

                }
            }
        }else{
            $(".step-next").append("<p>Sljedeće</p>").removeClass('step-button-colorful');
        }
    };
    /*
     |--------------------------------------------------------------------------------------------------------------
     |      VALIDATE FOR NUMBERS, EMAIL, PHONE
     |--------------------------------------------------------------------------------------------------------------
     |
     |      When we need only numerical data, or email format, or phone format or anything like that, that's where
     |      we can check it. If there is any wrong char inside string, we can
     |
     */

    let validateNUmber = function(string){
        let myString = $(string).val();
        for(let i=0; i<myString.length; i++){
            if(myString.charCodeAt(i) < 48 || myString.charCodeAt(i) > 57){
                // console.log("Replacing " + myString[i]);
                // myString = myString.replace(myString[i], '');
                // console.log(myString);
                // myString = replaceString(myString, myString[i], '');
                return false;
            }
        }

        // $(string).val(myString);
        return true;
    };

    let validateEmail = function(string){
        return /\S+@\S+\.\S+/.test($(string).val());
    };

    let validatePhone = function (string){
        return 12;
    };

    let validateJMBG = function(string){
        return ($(string).val().length === 13) ? true : false;
    };

    let pushInto = function(value){
        let found = false;
        for(let i=0; i<vars.errors.length; i++){
            if(vars.errors[i] === value) found = true;
        }

        if(!found){
            vars.errors.push(value);
            return;
        }
    };

    let getIndex = function(value){
        for(let i=0; i<vars.errors.length; i++){
            if(vars.errors[i] === value) return i;
        }
    }

    /*
     |--------------------------------------------------------------------------------------------------------------
     |      ACTIONS
     |--------------------------------------------------------------------------------------------------------------
     |
     |      We are able to choose to make http request or submit form - where and what to set and more
     |
     */
    let removeFromObject = function(){
        for (var variableKey in vars.data){
            if (vars.data.hasOwnProperty(variableKey)){
                delete vars.data[variableKey];
            }
        }
    }
    let chech_if_contains = function(parent, child){

    };

    let fullFillData = function(){
        let inputs = $(":input, textarea").each(function (index) {
            if($(this).val() === '' && $(this).attr('type') !== 'file' && $(this).attr('special') !== 'empty-id'){
                if(typeof $(this).attr('validate') !== typeof undefined && $(this).attr('validate') !== false){
                    let validate = $(this).attr('validate').split(" ");
                    let found = false;
                    for(let i=0; i<validate.length; i++){
                        if(validate[i] === 'required') found = true;
                    }
                    // TODO - provjeriti / kada je prazno
                    if(!found){
                        // if(! $(this).hasClass('datepicker')) $(this).val("/");
                    }
                }else {
                    // console.log("Validate else : " + $(this).attr('validate'));
                    // if(! $(this).hasClass('datepicker')) $(this).val("/");
                }
            }
        });
    };


    //********************************************* Style notifications !! *******************************************//

    $.notify.addStyle('happyblue', {
        html: "<div><span data-notify-text/></div>",
        classes: {
            base: {
                "white-space": "nowrap",
                "background-color": "lightblue",
                "padding": "5px"
            },
            superblue: {
                "color": "white",
                "background-color": "blue"
            }
        }
    });

    $.notify.addStyle('custom-error-message', {
        html: "<div><i class='fas fa-exclamation-triangle' style='margin-right:10px;'></i><span data-notify-text/></div>",
        classes: {
            base: {
                "white-space": "nowrap",
                "background-color": "#F2DEDE",
                "padding": "10px",
                "color" : "#B94A48",
                "max-width" : "600px",
                "white-space" : "initial",
                // "opacity" : "0.75",
                "border-radius" : "4px"
            },
            superblue: {
                "color": "#B94A48",
                "background-color": "#F2DEDE"
            }
        }
    });

    let chooseWhatToDo = function() {
        if(vars.errors.length === 0){
            // $("#loading-bar").css('display', 'block');
            fullFillData();
            if(vars.url === 'form'){
                $("form").submit();
            }else if(vars.ajax){
                // Send data thru ajax
                if(vars.csrf) setCSRF();

                // Remove everythig from data

                removeFromObject();
                let myData = {};
                let array_of_datas = new Array();

                var form = document.querySelector('#' + vars.wrapper.parent().attr('id'));

                // var form = $('#' + vars.wrapper.parent().attr('id'))
                var obj = serialize(form, { hash: true, empty: true });

                $.ajax({
                    type:'POST',
                    url: vars.url,
                    data: JSON.stringify(obj),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success:function(data){
                        if(data['code'] === '4004'){
                            $.notify(data['message'], 'error');
                        }else if(data['code'] === '75698'){
                            // Prazno polje ;;
                            $.notify('' + 'Došlo je do greške! ' + data['message'], {
                                style: 'custom-error-message'
                            });
                            // $.notify('hello !!', {
                            //     style: 'happyblue'
                            // });
                        }else if(data['code'] !== '0000'){
                            // Došlo je do neke greške !
                            console.log(data['code'] + ':' + data['message'], 'error');
                            $.notify('' + 'Došlo je do greške! ', 'error');
                        }else{
                            // Uspješan request !!
                            $.notify(data['message'], 'success');
                            if(vars.goto){
                                if(typeof data['response'] !== typeof undefined){
                                    vars.goto += '/' + data['response'];
                                }
                                window.location = vars.goto;
                            }
                        }

                        $("#loading-bar").css('display', 'none');
                    }
                });
            }else if(vars.submit){
                // Submit form and send data through form wherever we want
                console.log("Sending via submit form ..");
            }
        }else{
            $.notify("Došlo je do greške. Provjerite polja prije spašavanja !", 'warn');
        }
    };



    /**************************************************************************************************************/
    /** Public method Can be called outside class **/

    // Here we can set values for our steps or append them later - READ also
    this.appendValues = function(options){ $.extend(vars , options); };
    this.readValues = function(){ return vars.values; };

    // Here we can set icons for steps or append them later - READ also
    this.appendIcons  = function(options){$.extend(vars, options); };
    this.readIcons = function(){ return vars.icons; };

    this.giveParent = function () { return vars.wrapper;}

    /*
     |--------------------------------------------------------------------------------------------------------------
     |      CREATE HTTP
     |--------------------------------------------------------------------------------------------------------------
     |
     |      Default value is to create HTTP request via ajax - not via submit form. We can change it , and rechange
     |      again.
     |      To choose ajax http version, we need to set one parameter - url. Can do it via constructor or via this
     |      method. send :: options = { ajax : true, url : 'this/url' } ;
     |
     */

    this.createHTTP = function(options){ $.extend(vars , options); vars.submit = false; };

    /*
     |--------------------------------------------------------------------------------------------------------------
     |      SUBMIT FORM
     |--------------------------------------------------------------------------------------------------------------
     |
     |      We also have an option to submit form. In that case, we have to set submit to true, and disable
     |      ajax option for sending data. That could be made also through methods or via constructor.
     |
     */

    this.submitForm = function () { vars.ajax = false; vars.submit = true; };

    /*
     |--------------------------------------------------------------------------------------------------------------
     |      ERROR HANDLING
     |--------------------------------------------------------------------------------------------------------------
     |
     |      Now, we have an option to choose whether we could pass data without verification or we can verify data
     |      and then allow to go to next step. Default : errors = false , errors_handling = true;
     |
     */

    this.errorHandle = function () { vars.error_h = true; };
    this.errorHandleStop = function () { vars.error_h = false; };

    /*
     |--------------------------------------------------------------------------------------------------------------
     |      USE FINAL STEPP
     |--------------------------------------------------------------------------------------------------------------
     |
     |      There are situations when we only want to reach last step , and after that stop doing anything. Not to
     |      send any data, submit any forms and etc. In this particular situation, we can say "I'll right then, we
     |      will not end anything, when we get into last step, just hide button and we are fine !
     |
     */

    this.sendIt = function () { vars.send = true; };
    this.prevendFromSending = function () { vars.send = false;};


    /* Pass options when class instantiated */
    this.construct(options);


    /**************************************************************************************************************/

    /** Onclick event on two dynamic buttons **/
    let nextStep = $(".step-next").click(function(){
        let current = vars.wrapper.find("ul .active");

        if(current.index() === (vars.values.length - 1)){  /** if we have reached the end, stopp it ! :D **/
        chooseWhatToDo();
            return;
        }

        let next    = vars.wrapper.find("li:eq(" + (current.index() + 1) +")").addClass("active");
        current.removeClass("active");
        // Change background of all of them before
        vars.wrapper.find(".active").prevAll().addClass("steps-before");

        // here we do some magic :D
        shakeElements();

        // Here we work with sections - fadeIn or fadeOut

        vars.wrapper.find("section:eq(" + (current.index() + 1) + ")").addClass("active-section");
        vars.wrapper.find("section:eq(" + (current.index()) + ")").removeClass("active-section");


        // **  Here we change buttons ** //
        changeButtons();
    });

    $(".step-previous").click(function(){
        let current = vars.wrapper.find("ul .active");
        if(current.index() === 0) return; // If we have reached the end, STOP
        let next    = vars.wrapper.find("li:eq(" + (current.index() - 1) +")").addClass("active");
        current.removeClass("active");
        next.removeClass("steps-before");
        shakeElements();

        // Here we work with sections - fadeIn or fadeOut

        vars.wrapper.find("section:eq(" + (current.index() - 1) + ")").addClass("active-section");
        vars.wrapper.find("section:eq(" + (current.index()) + ")").removeClass("active-section");


        // **  Here we change buttons ** //
        changeButtons();
    });

    // document.onkeydown = function(e) {
    //     switch (e.keyCode) {
    //         case 37:
    //             $(".step-previous").click();
    //             break;
    //         case 38:
    //             // UP
    //             break;
    //         case 39:
    //             if($('.step-next').hasClass("step-button-colorful")){
    //                 console.log("weee");
    //                 return;
    //             }
    //             $(".step-next").click();
    //             break;
    //         case 40:
    //             // DOWN
    //             break;
    //     }
    // };

    /** Instant step show - when we click on particular step - show it !! **/
    $(".steps-circle").click(function () {
        let current = $(this.parentElement);

        // First remove all active classes and set all of them before
        let all = vars.wrapper.find("ul li").each(function (index = 0) {
            $(this).removeClass('active').removeClass('steps-before');

            if(index < current.index()) $(this).addClass('steps-before');
            else if(index === current.index()){
                $(this).addClass('active');
            }
        });

        shakeElements();

        // Here we work with sections - fadeIn or fadeOut
        let all_sections = vars.wrapper.find("section").each(function () {
            $(this).removeClass('active-section');
        });

        vars.wrapper.find("section:eq(" + (current.index()) + ")").addClass("active-section");

        // **  Here we change buttons ** //
        changeButtons();
    });


    // TODO - On right click do something

    // $(".steps-for-copy:not(.form-control)").on("contextmenu",function(e){
    //     if($(e.target).closest('input').length > 0){
    //         // We clicked on input
    //     }else{
    //         // Clicked on something else , so we can disable right click :D
    //         console.log("Processing data for copying");
    //         return false;
    //     }
    //     //console.log(($(this).find('input, textarea, select').attr('class')));
    // });

    /*
     |--------------------------------------------------------------------------------------------------------------
     |      DYNAMIC CREATE NEW ELEMENTS - PARENTS
     |--------------------------------------------------------------------------------------------------------------
     |
     |      Sometimes we need more than one form. There are many ways, but we can simply copy it and then just append
     |      it through form.
     |
     */


    $(".copy-button-wrapper").click(function () {

        // Copy from main element and append it to it's parent !
        let copied_form = $(this.parentElement).find('.steps-for-copy').children().clone();

        $(copied_form).find('input').each(function () {
            if($(this).attr('special') === 'empty-id'){
                $(this).val('empty-next');
            }
        });

        // Create new div so we are able to delete it later on
        let new_record_w = $(this.parentElement).append("<div class='steps-inside-element'></div>").children('div:last-child');
        // here we append written data + button for deleting it.
        $(new_record_w).append(copied_form).append('<div class="steps-inside-element-delete"> <i class="fas fa-trash"></i> </div>');

        // Remove everything from main element
        ($(this.parentElement).find('.steps-for-copy')).find('input, textarea, select').each(function (index) {
            if(!$(this).attr('special')){
                $(this).val('');
            }else $(this).val('');
        });

        ($(this.parentElement).find('.steps-for-copy')).find('select').each(function (index) {
            $(this).val('0');
        });
    });

    // When we create new element - if there is mistake, there should be option to delete it. We can do it through this
    // way

    $("body").on('click', '.steps-inside-element-delete', function () {
        if(typeof $(this).attr('tabela') !== typeof undefined && typeof $(this).attr('tabela') != null){
            if(vars.csrf) setCSRF();

            let reloadPage = false;

            if($(this).attr("reload")) reloadPage = true;


            $.ajax({
                type:'POST',
                url: $(this).attr('url'),
                data: {"tabela" : $(this).attr('tabela'), id : $(this).attr("elem-id")},
                success:function(data){
                    console.log("data = " + data);
                    data = JSON.parse(data);
                    if(data['code'] !== '0000'){
                        // Došlo je do neke greške !
                        console.log(data['code'] + ':' + data['message'], 'error');
                        $.notify(data['code'] + ':' + data['message'], 'error');
                    }else{
                        // Uspješan request !!
                        $.notify(data['message'], 'success');

                        if(reloadPage){
                            location.reload();
                        }
                    }
                }

            });
        }

        if($(this).attr('extra') === 'reload') location.reload();
        console.log($(this).parent().remove());
    });


    /**************************************************************************************************************/

    vars.wrapper.find('input, textarea').keyup(function () {
        // If error handling is TRUE -> then we can check for errors and other stuffs lika that
        let input_this = $(this); let main_index = 0;
        if(vars.error_h){
            // console.log("Validating for " + $(this).attr('validate') + "..");
            $("input, textarea").each(function(index){
                if($(this).attr('name') === input_this.attr('name')) main_index = index;
            });

            // TODO -- if there is no validate attribute ; prevent from throwing an error

            let validate = $(this).attr('validate').split(" ");
            for(var i=0; i<validate.length; i++){
                if(validate[i] === 'number'){
                    // here we need to validate if there is any character except number
                    $(this.parentElement).find('.steps-col-number').remove();
                    if(!validateNUmber(this)){
                        $(this.parentElement).append(
                            "<div class='steps-col-warn steps-col-number'> <p>" + messages.number + "</p> </div> "
                        );

                        pushInto(main_index);
                    }else{
                        vars.errors.splice(getIndex(main_index), 1);
                    }
                }else if(validate[i] === 'email'){
                    $(this.parentElement).find('.steps-col-email').remove();
                    if(!validateEmail(this)){
                        $(this.parentElement).append(
                            "<div class='steps-col-warn steps-col-email'> <p>" + messages.email + "</p> </div> "
                        );

                        pushInto(main_index);
                    }else{
                        vars.errors.splice(getIndex(main_index), 1);
                    }
                }else if(validate[i] === 'phone'){
                    $(this.parentElement).find('.steps-col-phone').remove();
                    if(!validatePhone(this)){
                        $(this.parentElement).append(
                            "<div class='steps-col-warn steps-col-phone'> <p>" + messages.email + "</p> </div> "
                        );

                        pushInto(main_index);
                    }else{
                        vars.errors.splice(getIndex(main_index), 1);
                    }
                }else if(validate[i] === 'jmbg'){
                    $(this.parentElement).find('.steps-col-jmbg').remove();
                    if(!validateJMBG(this)){
                        $(this.parentElement).append(
                            "<div class='steps-col-warn steps-col-jmbg'> <p>" + messages.jmbg + "</p> </div> "
                        );

                        pushInto(main_index);
                    }else{
                        vars.errors.splice(getIndex(main_index), 1);
                    }
                }else if(validate[i] === 'required'){
                    $(this.parentElement).find('.steps-col-jmbg').remove();
                    if($(this).val() === ''){
                        $(this.parentElement).append(
                            "<div class='steps-col-warn steps-col-jmbg'> <p>" + messages.required + "</p> </div> "
                        );

                        pushInto(main_index);
                    }else{
                        vars.errors.splice(getIndex(main_index), 1);
                    }
                }
            }

        }
    });


    $('.file-input').change(function () {
        var data = new FormData();
        var ins = document.getElementById($(this).attr('id')).files.length;

        data.append($(this).attr('id'), document.getElementById($(this).attr('id')).files[0]);

        let fotoID = $(this).attr('foto-name');
        let previewID = $(this).attr('id') + '-title';
        // document.getElementById("loading_wrapper").style.display = 'block'; /** show loading part **/

        console.log(data);
        var xml = new XMLHttpRequest();
        xml.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                console.log(this.responseText);
                var source = '/images/slike-sluzbenika/' + this.responseText;

                source = source.replace(' ', '');

                console.log(fotoID);
                var image = document.getElementById(fotoID);
                image.setAttribute('src', source);

                // ** ovdje ćemo postaviti naziv fotografije, tako da je kasnije možemo samo strpati u bazu ** //
                document.getElementById(previewID).value = this.responseText;
                // document.getElementById("loading_wrapper").style.display = 'none'; /** hide loading part **/
            }
        };
        xml.open('POST', $(this).attr('url'));

        // ** Postavi tokene ** //
        var metas = document.getElementsByTagName('meta');
        for (var i=0; i<metas.length; i++) {
            if (metas[i].getAttribute("name") == "csrf-token") {
                xml.setRequestHeader("X-CSRF-Token", metas[i].getAttribute("content"));
            }
        }

        xml.send(data); // napravi http
    });



    $("#ime_korisnikaaa, #prezime_korisnikaaa").keyup(function () {
        let ime = $("#ime_korisnikaaa").val();
        let prezime = $("#prezime_korisnikaaa").val();


        var korisnickoIme = document.getElementById("korisnicko_ime");

        if(prezime === '') var string = ime.toLowerCase();
        else if(ime === '') var string = prezime.toLowerCase();
        else var string = (ime + '.' + prezime).toLowerCase();


        var newString = string.replace(/ć/g, "c");
        newString = newString.replace(/č/g, "c");
        newString = newString.replace(/š/g, "s");
        newString = newString.replace(/đ/g, "d");
        newString = newString.replace(/ž/g, "z");

        newString = newString.replace(/ /g, "");

        korisnickoIme.value = newString;

        console.log("ime : " + ime + ', prezime : ' + prezime);
    });

};



