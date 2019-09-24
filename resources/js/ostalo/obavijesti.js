function pregledaj(red){
    let tr =  red.parentNode.cloneNode(true);
    tr.deleteCell(4);
    tr.insertCell(4);
    tr.className = null;
    red.parentNode.remove();
    let nepregledano = $('.table-info');

    let hiddenid = red.children[1].textContent;
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url: '/obavijesti/ajaxpregled',
        data: { id: hiddenid},
        success:function(data){
            $('#tabelaObavijesti > tbody > tr').eq( nepregledano.length).before(tr);
        }
    });
}
function checkhover(celija){
    let id = celija.children[0].id;
    $('#'+id).show();
}
function checkhide(celija){
    let id = celija.children[0].id;
    $('#'+id).hide();
}