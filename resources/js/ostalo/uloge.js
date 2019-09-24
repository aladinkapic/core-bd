let last_checked = false;

$(document).ready(function () {
    $(".custom_span").click(function(){
        let custom_id = $(this).attr("custom_id");   // Daj ID za određenog korisnika

        let all_elem = $(".select_roles").hide();    // Sakrij sve ostale koji su tu
        let elem = $("#show_roles" + custom_id);

        if(last_checked){
            elem.hide();
            last_checked = false;
            return;
        }else{
            elem.show();
        }

        if(!last_checked) last_checked = elem;

    });

    $(".specific_role_value").click(function () {
        let keyword = $(this).attr("keyword");
        let sluzbenik_id = $(this).attr("sluzbenik_id");

        let vrijednost = this.checked;
        if(vrijednost) vrijednost = 1;
        else vrijednost = 0;

        console.log(vrijednost);

        loading();
        $.ajax({
            type: "POST",
            url: '/uloge/azuriraj_uloge',
            data: {
                keyword      : keyword,
                sluzbenik_id : sluzbenik_id,
                vrijednost   : vrijednost,
            },
            success: function(d){
                loading();
            },
            dataType: null
        });
    });
});