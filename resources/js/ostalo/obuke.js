let global_what = null;
let alemCounter = 0;

function delegateDelete(id) {
    return function () {
        deleteAlemItem(id);
    }
}

function deleteAlemItem(id) {
    $("#globalWhatIdwithCounter" + id).remove();
}


function dodajpredavaca(what, input_id) {
    global_what = what;

    var value = document.getElementById(input_id);

    let wrapper = document.getElementById(what);

    let wrapper_elem = document.createElement("div");
    wrapper_elem.className = "row";
    wrapper_elem.style.width = "100%";
    wrapper_elem.style.marginLeft = "0px";
    wrapper_elem.child.style.paddingLeft = "0px";
    wrapper_elem.id = 'globalWhatIdwithCounter' + alemCounter;

    var form_w = document.createElement("div");
    form_w.className = "col-sm-8";
    let input = document.createElement("input");
    input.value = value.value;
    input.style.marginTop = "20px";
    input.name = what + "[]";
    input.className = "form-control";
    form_w.appendChild(input);

    let button_w = document.createElement("div");
    button_w.className = "col-4";
    var button = document.createElement("button");
    button.className = "btn btn-danger " + what;
    button.style.marginTop = "20px";
    button.innerText = "Obrišite";

    button.addEventListener("click", delegateDelete(alemCounter++));

    button_w.appendChild(button);

    wrapper_elem.appendChild(form_w);
    wrapper_elem.appendChild(button_w);

    wrapper.appendChild(wrapper_elem);


    value.value = '';
}


$(document).ready(function () {
    let max = $("#maxsluz").text();

    let dugmexlinkovi = document.querySelectorAll(".fa-times:not(.disable-popup)");
    for (let i = 0; i < dugmexlinkovi.length; i++) {
        dugmexlinkovi[i].parentElement.addEventListener("click", function (event) {
            event.preventDefault();

            bootbox.confirm({
                message: "Upozorenje. Da li ste sigurni da želite obrisati podatke?",

                buttons: {
                    confirm: {
                        label: 'DA',
                        className: 'btn-primary spremi-rjesenje'
                    },
                    cancel: {
                        label: 'Odustani',
                        className: 'btn-secondary'
                    }
                },
                callback: function (result) {
                    if (result === false) {
                        $.notify("Zatvoreno brisanje ...", "warn");
                    } else {
                        $.notify("Izbrisano ...", "warn");
                        window.location = dugmexlinkovi[i].parentElement.href;
                    }
                }
            });

        });
    }


    $(".predavacidiv").click(function () {
    });


    $('.js-example-basic-multiple').select2({
        theme: "classic",
        maximumSelectionLength: max,
        language: {
            maximumSelected: function (e) {
                var t = "Maksimalan broj odabira je: " + e.maximum;
                return t
            }
        }
    });

    $('.js-example-basic-single').select2({
        theme: "classic",

    });

    //modal data
    $('#exampleModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let recipient = button.data('whatever');
        $('#modaldata').val(recipient)

    })
    $('#exampleModal2').on('show.bs.modal', function (event) {
        $('#redpodataka').remove();
        let button = $(event.relatedTarget);
        let values = button.data('whatever');
        for (let key in values) {
            let row = document.createElement('tr');
            row.id = 'redpodataka';
            let td1 = document.createElement('td');
            td1.innerHTML = values[key]['operater'];
            row.append(td1);

            let td2 = document.createElement('td');
            td2.innerHTML = values[key]['datum'];
            row.append(td2);

            let td3 = document.createElement('td');
            td3.innerHTML = values[key]['vrijednostocjene'];
            row.append(td3);

            $('#tbody').append(row);
        }
    })

});