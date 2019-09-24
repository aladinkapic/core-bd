function spremi_upravu() {
    url = '/hr/uprava/storeUprava';

    let tin = document.getElementById("tin").value;
    let naziv = document.getElementById("naziv").value;
    let tip = document.getElementById("tip").value;
    let ulica = document.getElementById("ulica").value;
    let broj = document.getElementById("broj").value;
    let telefon = document.getElementById("broj").value;
    let fax = document.getElementById("broj").value;
    let web = document.getElementById("broj").value;
    let email = document.getElementById("broj").value;

    document.getElementById("loading_wrapper").style.display = 'block'; /** show loading part **/

    kreiraj_request('POST', url, "tin=" + tin + '&naziv=' + naziv + '&tip=' + tip + '&email=' + email + '&ulica=' + ulica + '&broj=' + broj + '&telefon=' + telefon + '&fax=' + fax + '&web=' + web, false, spremiSluzbenikaResponse);

}