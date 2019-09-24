/*
    Steps
 */

function nowActive() {
    var active = 1;
    $("#steps-window section").each(function () {
        if ($(this).hasClass('active')) {
            active = $(this).attr('step');


        }
    });

    return active;
}

var i = 1;
var x = 1;

$("#steps-window ul li").each(function () {
    $(this).attr('data-step', i);

    $(this).click(function(){

        var children = $(this).children('.tab_div').length;
        if(children == 0){ return false; }
        var now = parseInt(nowActive());

        $("#steps-window li.active").removeClass('active');
        $(this).addClass('active');

        $("#steps-window section.active").removeClass('active');

        $('[step="' + $(this).attr('data-step') + '"]').addClass('active');

    });

    i++;
});

$("#steps-window section").each(function () {
    $(this).attr('step', x);
    x++;
});


/*
    Nazad
 */

$("#steps-window .buttons button:first-child").click(function (e) {
    e.preventDefault();

    var now = parseInt(nowActive());

    var last = $("#steps-window li:last-child").attr('data-step');

    if(last == now){
        $("#steps-window .buttons button:last-child").css('display', 'none');
        $("#steps-window .buttons button:nth-child(2)").css('display', 'inline-block');
    }

    var current_step = $('[step="' + now + '"]');
    var last_step = $('[step="' + (now - 1) + '"]');
    var data_current_step = $('[data-step="' + now + '"]');
    var data_last_step = $('[data-step="' + (now - 1) + '"]');

    if (last_step.length == 0) {
        return false;
    }

    data_current_step.removeClass('active').removeClass('before-active');
    data_last_step.removeClass('before-active').addClass('active');

    current_step.removeClass('active');
    last_step.addClass('active');

});

/*
   Naprijed
 */

$("#steps-window .buttons button:nth-child(2)").click(function (e) {
    e.preventDefault();

    var stop = 0;

    $("section.active input, section.active select, section.active textarea").each(function(){

        var attr = $(this).attr('required');

        if(typeof attr !== typeof undefined && attr !== false && $(this).val() == ''){

            $(this).css('border', 'solid 1px red');

            stop = 1;
        }
    }).promise().done(function(){

            if(stop == 1){ return false; }

            var now = parseInt(nowActive());
            var last = $("#steps-window li:last-child").attr('data-step');
            var current_step = $('[step="' + now + '"]');
            var next_step = $('[step="' + (now + 1) + '"]');
            var data_current_step = $('[data-step="' + now + '"]');
            var data_next_step = $('[data-step="' + (now + 1) + '"]');

            if (next_step.length == 0) {
                return false;
            }

            current_step.removeClass('active');
            next_step.addClass('active');
            data_current_step.removeClass('active');
            data_next_step.addClass('active', 1000, "easeOutBounce");

            if (data_next_step.attr('data-step') === last) {
                data_next_step.addClass('before-active');
                $("#steps-window .buttons button:last-child").css('display', 'inline-block');
                $("#steps-window .buttons button:nth-child(2)").css('display', 'none');
            }

            for (i = 0; i <= now; i++) {
                $('[data-step="' + i + '"]').removeClass('active').addClass('before-active');
            }

    });

});

$("#steps-window .buttons button:last-child").click(function(e){
    //e.preventDefault();
    return true;
});


$("section input, section select, section textarea").keyup(function () {
   $(this).css('border', '1px solid #b4b0b0');
});
$("section select").change(function () {
    $(this).css('border', '1px solid #b4b0b0');
});