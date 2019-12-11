/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import bootbox from 'bootbox';
import moment from 'moment'




window.Promise = require('es6-promise').Promise;
window.TableFilter = require('tablefilter');
window.Cookies = require('js-cookie');
window.bootbox = bootbox;
window.deparam = require('jquery-deparam');

require('function.name-polyfill');
require('./bootstrap');

import $ from 'jquery';
import 'select2';                       // globally assign select2 fn to $ element
import 'select2/dist/css/select2.css';  // optional if you have css loader

$(() => {
    $('.select2-enable').select2();
});



window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
var tf = null, globalData = null;

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('DD.MM.YYYY');
    }
});

Vue.filter('getNestedObject', function(value, obj) {
    return deep_value(obj, value);
});

Vue.filter('formatColumn', function(value) {
    value = value.replace('_', ' ');
    value = value.replace('rm', ' Radno Mjesto');
    value = value.replace('oj', ' Organizaciona jedinica');
    value = value.charAt(0).toUpperCase() + value.slice(1);

    return value;
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const deep_value = (obj, path) =>
    path
        .replace(/\[|\]\.?/g, '.')
        .split('.')
        .filter(s => s)
        .reduce((acc, val) => acc && acc[val], obj);


window.app = new Vue({
    el: '#app',
    methods: {
        alert: function(content){
            var fill = $(content).html();

            bootbox.dialog({
                message: fill ,
                size: 'large',

            });

        },
        toggle: function (element){

            $(element).slideToggle('fast');
            window.location.href = '' + element;
        },
        url: function(e){
            window.location.href = e;
        },
        leaving: function(){
            $("#loading_wrapper").fadeToggle();
        },
        confirm: function(element){
            bootbox.confirm({
                message: 'Jeste li sigurni da želite obrisati organizacionu jedinicu? Sva radna mjesta i podređene organizacione jedinice će biti obrisane!',
                buttons: {
                    confirm: {
                        class: 'btn-success',
                        label: 'Da'
                    },
                    cancel: {
                        class: 'btn-danger',
                        label: 'Ne'
                    }
                },
                callback: function(result){
                    if(result){
                        $(element).submit();
                    }
                }
            });
        },
        confirmText: function(text, element){

            bootbox.confirm({
                message: text,
                buttons: {
                    confirm: {
                        class: 'btn-success',
                        label: 'Da'
                    },
                    cancel: {
                        class: 'btn-danger',
                        label: 'Ne'
                    }
                },
                callback: function(result){
                    if(!result){
                        // return false;
                    } else {
                        $(element).submit();
                    }
                }
            });
        },
        setNoviBroj: function (){
            var id = $("#parent").val();

            $.ajax({
               url: '/organizacija/jedinica/api/getOrgBroj',
                method: 'POST',
                data: { id: id },
                success: function(response){
                   $("#broj").val(response);
                }
            });

        },
        expand: function (){
            $(".col-md-3").slideUp();
            $(".col-md-9").addClass('col-md-12').removeClass('col-md-9');
        },
        mountHidden: function(){
            var app = this;


            $("#filtering thead th").each(function(index){
                if(app.hidden_columns.includes(index)){
                    $(this).css('display', 'none');
                }
            });

            $("#filtering tbody tr").each(function(){

                $("td", this).each(function(index){

                    if(app.hidden_columns.includes(index)){
                        $(this).css('display', 'none');
                    }
                });
            });

        },
        progressMove: function(value){
            $(".progress-bar").attr("aria-valuenow", value).css("width", value+"%").html(value+"%");
        },
        fireTable: function(){

                $("#filtering th").each(function(){
                   $("<input />").attr({ type: 'text', name: 'filter[' + $(this).attr('data-filter') + ']', class: 'form-control'}).appendTo($(this));
                });

                return true;

                /*
                let total = $(".total").html();

                let data = [];

                if(total.length == 0){
                    app.triggerFilters();
                    return true;
                }

                let getData = function(){
                    $.ajax({
                        method: 'POST',
                        url: app.chunked_url,
                        data: { limit: 500, offset: offset, _token: $('[name="csrf-token"]').attr('content') },
                        beforeSend: function(){
                            app.progressMove(Math.round((offset/total) * 100));
                        },
                        success: function(response){
                            if(response.length > 0 ){
                                offset += 500;

                                app.items = app.items.concat(response);

                                setTimeout(function(){
                                    getData();
                                }, 500);

                            } else {
                                app.triggerFilters();
                            }
                        }
                    });
                }

                getData();
                */

        },

        triggerFilters: function(){
          let app = this;

            if($("#filtering").length > 0 && app.fired == 0) {

                tf = new TableFilter('filtering', {
                    base_path: '/vendor/tablefilter/dist/tablefilter/',
                    auto_filter: {
                        delay: 500 // milliseconds
                    },
                    rows_counter: true,
                    status_bar: true,
                    paging: {
                        results_per_page: ['Redovi: ', [10, 25, 50, 100]]
                    },
                    state: { types: ['cookie'] }, // da ostane
                    btn_reset: {
                        text: 'Clear'
                    },
                    extensions: [{
                        name: 'colsVisibility',
                        text: 'Odaberite polja: ',
                        at_start: app.hidden_columns,
                        enable_tick_all: true
                    }, {
                        name: 'sort'
                    }]
                });
                tf.init();
                app.progressMove(100);
                $("#export-button-excel").show();
                $("#export-button-word").show();
                $("#export-button-pdf").show();
                app.fired = 1;
            }
        },
        getVisibleColumns : function(what){
            // let data = tf.getFilteredValues();
            let link = null;
            if(what === 'excel'){
                link = '/export/excel'
            }else if(what === 'word'){
                link = '/export/word';
            }else if(what === 'pdf'){
                link = '/export/pdf';
            }

            globalData = [];
            let header = [];
            $("#filtering thead th:not(.fltrow)").each(function(){
                if  ($(this).css("display") !== 'none' && this.className !== 'akcije'){
                    header.push($(this).text());
                }
            });

            $("#filtering tbody tr:not(.fltrow)").each(function(){
                let roww = [];
                if($(this).css("display") !== 'none'){
                    $("td", this).each(function(){
                        if($(this).css("display") !== 'none' && this.className !== 'akcije'){
                            roww.push($(this).text());
                        }
                    });

                    globalData.push(roww);
                }
            });

            bootbox.prompt({
                title: "Naziv izvještaja",
                inputType: 'textarea',
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
                        $.notify("Eksport podataka nije uspio ..", "warn");
                    }else{
                        // loading();

                        // console.log(globalData);
                        //loading();

                        $.ajax({
                            url: link,
                            method: 'POST',
                            data: {
                                data   : globalData,
                                header : header,
                                result : result
                            },
                            success: function(response){
                                // $("#broj").val(response);
                                $.notify("Vaš fajl je uspješno generisan. ", successOptions);

                                download = response;

                                //loading();

                                // $.notify({
                                //     title: "Da li želite da preuzmete izvještaj?",
                                //     button: 'Confirm'
                                // }, {
                                //     style: 'buttons_style',
                                //     autoHide: 10000,
                                //     clickToHide: false
                                // });
                            }
                        });
                    }
                }
            });
        },



        getAllowedObject: function(value){

            let allowed = ["id", "created_at", "updated_at"];

            if(allowed.indexOf(value) > -1){
                return false;
            }

            return true

        },
        getNestedObject: function(object, name){
            return deep_value(object, name);
        }
    },
    mounted() {
        window.addEventListener('beforeunload', this.leaving);



        let timeelapsed = 0;
        var interval =  setInterval(function(){

            timeelapsed += 1;

            if(timeelapsed >= 10){

                clearInterval(interval);
            }

            if(app.hidden_columns.length > 0){
                $("#filtering").css('display', 'table');
                app.mountHidden();

                clearInterval(interval);
            }
        }, 100);
    },
    data: {
        items: [],
        fired: 0,
        hidden_columns: [],
        chunked_url: ''
    }
})




/*

 */
function triggerCookies(){


    setInterval(function(){

        var data = {};

        var i = 0;

        $("select, input, textarea").each(function (){
            data[i] = {};
            data[i].name = $(this).attr('name');
            data[i].value = $(this).val();
            data[i].type = $(this).prop('nodeName');

            i++;
        });

        Cookies.set(cookie_name, JSON.stringify(data));

    }, 2000);
}

function fillCookies(cookie_name){

    var cookie = JSON.parse(Cookies.get(cookie_name));

    for(var k in cookie) {
        $('[name="' + cookie[k].name + '"]').val(cookie[k].value);
    }
}

$(document).ready(function (){

    /*
        Cookies
     */
    var cookie = $(".cookie-save");

    if(cookie.length > 0){
        var cookie_name = cookie.attr('cookie-name');
        var Cookie = Cookies.get(cookie_name);

        if(Cookie != undefined){
            fillCookies(cookie_name);
        }

        triggerCookies(cookie_name);
    }

    /*
        Učitaj filtere
     */

    //let filters = getSearchParams('filter');

    // console.log(filters);


    $(".select-sluzbenik, " + '[name="sluzbenik"]').select2({
        minimumInputLength: 2,
        ajax: {
            url: "/api/pretraga/sluzbenik",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (params) {
                return {
                    data: params.term,
                    _token: $('meta[name="csrf-token"]').attr('content')
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function(obj) {
                        return { id: obj.id, text: obj.ime };
                    })
                };
            },

        }
    });


});


/*
    Filters JS
 */
$(document).ready(function(){

    /*
        New filter
     */

    $(".new-filter").click(function(e){
        $(".append-filters").append($(".filter-row").first().clone());

        $(".filter-row input").last().val('');
        $(".filter-row select").last().val('');

    });

    /*
        Remove filter
     */


    $(document).on('click', '.remove-filter' , function(){
        if($(".append-filters .input-group").length > 1){
            $(this).closest('.filter-row').remove();
        }
    });

    // First hide one of them that are supposed to be hidden

    let hiddeThem = function(){
        let currentUrl = window.location.href.split('?')[0];
            // localStorage.clear();
        //
        // console.log(currentUrl);
        // return;
        // console.log(JSON.parse(localStorage[currentUrl]));

        // $("#filtering tbody tr").each(function(){
        //     $("td", this).each(function(){
        //         if($(this).index() > 4){
        //             $(this).toggle();
        //         }
        //     });
        // });
        //
        // $("#filtering th").each(function(){
        //     if($(this).index() > 4){
        //         $(this).toggle();
        //     }
        // });

    };


    hiddeThem();



    /*
        Fill checkable column names
     */

    let initialValues = [], updateIntialValues = false;

    let setCheckPoints = function(){
        let currentUrl = window.location.href.split('?')[0];

        if(typeof localStorage[currentUrl] === "undefined"){
            updateIntialValues = true;
        }else console.log("We already set it!");

        if(updateIntialValues){ // Ako nema ništa, ako prvi put otvaramo, onda ponudi inicijalne vrijednosti
            // Set first values
            $("#filtering tbody tr").each(function(){
                $("td", this).each(function(){
                    if($(this).index() < 4){
                        // $(this).css('display', 'block');
                        $(this).show();
                        // console.log($(this).text());
                    }else{
                        $(this).hide();
                    }
                });
            });


            $("#filtering th").each(function () {
                let $this = $(this);
                let checked = "";

                if($this.index() < 4){
                    $(this).show();
                }else $(this).hide();

                if($this.css('display') !== 'none') {
                    checked = 'checked="checked"';
                    initialValues.push($this.html().replace(new RegExp(' ', 'g'), '')); // Postavi unutar toga
                }
                let fillable = '<a class="dropdown-item"><input type="checkbox" ' + checked + ' id="' + $this.html().replace(new RegExp(' ', 'g'), '') + '" /> <label for="' + $this.html().replace(new RegExp(' ', 'g'), '') + '">' + $this.html() + '</label></a>';

                $(".fill-column-names").append(fillable);
            });

            localStorage.setItem(currentUrl, JSON.stringify(initialValues));
        }else{
            let jsonValues = JSON.parse(localStorage.getItem(currentUrl));

            $("#filtering th").each(function () {
                let $this = $(this);
                let checked = "";

                for(let i=0; i<jsonValues.length; i++){
                    if(jsonValues[i] === $this.html().replace(new RegExp(' ', 'g'), '')){
                        checked = 'checked="checked"';
                    }
                }

                let fillable = '<a class="dropdown-item"><input type="checkbox" ' + checked + ' id="' + $this.html().replace(new RegExp(' ', 'g'), '') + '" /> <label for="' + $this.html().replace(new RegExp(' ', 'g'), '') + '">' + $this.html() + '</label></a>';

                $(".fill-column-names").append(fillable);
            });

            // Kada smo postavili ono što treba da je čekirano, sad je vrijeme da uredimo ono što nije :)))
            for(var i=0; i<jsonValues.length; i++){
                let label = $('[for="' + jsonValues[i] + '"]').html();

                let head_element = $('th:contains("' + label + '")');

                let head_index = head_element.index();

                // console.log("Treba: " + jsonValues[i] + ', index:' +  head_index);

                $("#filtering tbody tr").each(function(){
                    $("td", this).each(function(){
                        if($(this).index() == head_index){
                            // $(this).css('display', 'block');
                            $(this).show();

                            // console.log($(this).text());
                        }else{
                            // console.log("Ne treba : " + $(this).text());
                        }
                    });
                });

                head_element.show();
                // head_element.css('display', 'block');
            }
        }
        console.log(localStorage.getItem(currentUrl));
    }

    setCheckPoints();


    $(".return-none").click(function(e){
        e.stopPropagation();
    });

    /*
        Return none at field, check column name
     */

    $(".return-none a, .return-none label").click(function(e){

        let id = ($("label", this).attr('for') == undefined) ? $(this).attr('for') : $("label", this).attr('for');

        let checkbox = $("#" + id);
        if(checkbox.attr('checked') == 'checked'){
            //checkbox.attr('checked', false);
            //checkbox.prop( "checked", false );
            //checkbox.trigger('change');
        } else {
            //checkbox.attr('checked', true);
            //checkbox.trigger('change');
            //checkbox.prop( "checked", true );
        }

    });

    /*
        Show/hide column
     */

    $(".fill-column-names").on('change', 'input', function (){


        let label = $('[for="' + $(this).attr('id') + '"]').html();

        let head_element = $('th:contains("' + label + '")');

        let head_index = head_element.index();

        let currentUrl = window.location.href.split('?')[0];
        initialValues = JSON.parse(localStorage.getItem(currentUrl));


        let foundInChecking = -1;
        for(let j=0; j<initialValues.length; j++){
            if(initialValues[j] === $(this).attr('id')) foundInChecking = j;
        }

        if(foundInChecking >= 0) initialValues.splice(foundInChecking, 1);
        else initialValues.push($(this).attr('id')); // Postavi unutar toga
        // console.log("Found : " + foundInChecking);

        console.log("After click : " + initialValues);

        localStorage.setItem(currentUrl, JSON.stringify(initialValues));

        console.log(initialValues);

        $("#filtering tbody tr").each(function(){
            $("td", this).each(function(){
                if($(this).index() == head_index){
                    $(this).toggle();
                } //else console.log("Nije moguće : " + )
            });
        });

        head_element.toggle();

    });


});

$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#buton-to-change-code').click(function () {
        // e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/uloge/validiraj-sifru',
            data: {sluzbenik_id : $("#sluzbenik_id").val(), sifra : $("#sifra").val(), pin : $("#pin").val()},
            success: function (data) {
                data = JSON.parse(data);
                if(data['code'] === '0000'){
                    $.notify(data['message'], 'success');
                }else{
                    $.notify(data['message']);
                }
                console.log(data);
            }
        });
    });

});



$(document).ready(function(){
    $( function() {
        $( ".tf-tree" ).draggable();
    } );


    let treeWrapperW = $(".tree-wrapper").width();
    console.log(treeWrapperW);

    // Now, lets put it on the left

    let scaleValue = 0.9;


    console.log($(".first-div").width());

    $(".box").scroll(function() {
        $("span").css( "display", "inline" ).fadeOut( "slow" );
    });

    $(".zoom-in-it").click(function () {
        scaleValue += 0.1;
        $('.tf-tree').css('transform', 'scale(' + (scaleValue) +')')
    });
    $(".zoom-out-it").click(function () {
        scaleValue -= 0.1;
        $('.tf-tree').css('transform', 'scale(' + (scaleValue) +')')
    });
});
