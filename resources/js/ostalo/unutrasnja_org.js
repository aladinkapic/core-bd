

var radno_id = null, naziv_rm = null;
var redirectUrl = null, poruka = null;

// Da li želimo da redirektamo ili da nešto drugo radimo
var redirect = false;
// Želimo li da downloadujemo fajlove
var download = false;

var successOptions = {
    autoHideDelay: 2000,
    showAnimation: "fadeIn",
    hideAnimation: "fadeOut",
    hideDuration: 700,
    arrowShow: false,
    className: "success",
};

$(document).ready(function () {
    $.notify.addStyle('buttons_style', {
        html:
            "<div>" +
            "<div class='clearfix'>" +
            "<div class='title' data-notify-html='title'/>" +
            "<div class='buttons'>" +
            "<button class='no btn-light'>Odustani</button>" +
            "<button class='yes btn-success'>Pregledaj</button>" +
            "</div>" +
            "</div>" +
            "</div>"
    });


    $(document).on('click', '.notifyjs-buttons_style-base .no', function() {
        $(this).trigger('notify-hide');
    });
    $(document).on('click', '.notifyjs-buttons_style-base .yes', function() {
        if(redirect) window.location = redirectUrl;
        else if(download){
            $.ajax({
                url: '/export/download',
                method: 'POST',
                data: { id: download},
                success: function(response){
                    var save = document.createElement('a');
                    save.href = response[1];
                    save.download = response[0];
                    save.target = '_blank';
                    // document.body.appendChild(save);
                    save.click()

                    console.log(response);
                }
            });
        }
        $(this).trigger('notify-hide');
    });



    $(".rjesenje").click(function () {
        radno_id = $(this).attr('data-id');
        naziv_rm = $(this).attr('data-name');
        loading();

        var checkUrl = null , saveUrl = null;

        if(this.className === 'rjesenje rjesenje_korisnika'){
            checkUrl = '/ostalo/interno_trziste/rjesenjeKorisnika';
            saveUrl  = '/ostalo/interno_trziste/spremiRjesenjeKorisnika';
            redirectUrl = '/hr/sluzbenici/dodatno_o_sluzbeniku/' + radno_id + '/true';
            poruka   = 'Želite li pogledati službenika zajedno sa rješenjem ?';
        }else{
            checkUrl = '/ostalo/interno_trziste/rjesenje';
            saveUrl  = '/ostalo/interno_trziste/spremiRjesenje';
            redirectUrl = '/hr/radna_mjesta/pregledaj_radno_mjesto/' + radno_id + '/true';
            poruka   = 'Želite li pogledati radno mjesto sa rješenjem?';
        }

        redirect = true;

        $.ajax({
            type: "POST",
            url: checkUrl,
            data: 'id=' + radno_id,
            success: function(d){
                loading();
                bootbox.prompt({
                    title: "Rješenje za " + naziv_rm,
                    inputType: 'textarea',
                    value : d,
                    buttons: {
                        confirm: {
                            label: 'Spremite',
                            className: 'btn-primary spremi-rjesenje'
                        },
                        cancel: {
                            label: 'Odustanite',
                            className: 'btn-secondary'
                        }
                    },
                    callback: function(result){
                        if(result === null){
                            $.notify("Zatvoreno uređivanje rješenja o upražnjenim radnim mjestima ..", "warn");
                        }else{
                            kreiraj_request('post', saveUrl, 'id=' + radno_id + '&rjesenje=' + result, true, porukaRjesenja);
                        }
                    }
                });
            },
            dataType: null
        });
    });
});



function porukaRjesenja(response){

    if(response['status'] === 'success'){
        $.notify({
            title: poruka,
            button: 'Confirm'
        }, {
            style: 'buttons_style',
            autoHide: 5000,
            clickToHide: false
        });

        $.notify("Rješenje za " + naziv_rm + " je spremljeno.", successOptions);
    }else{
        $.notify("Neuspjelo spremanje rješenja.. Molimo pokušajte opet !", 'warn');
    }

}

