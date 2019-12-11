<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Crypt;
use App\Notifications\NotifyMe;
use App\Models\Sluzbenik;
use App\Models\RadnoMjesto;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HelpController;


Route::get('/greska', function (){
    return HelpController::except('404', 'Desila se greška prilikom CRUD-a');
});

Route::prefix('/')->group(function () {
    Route::get('/',                           'HelpController@pocetak')->name("pocetna");
    Route::get('home',                        'HelpController@naslovna')->name("home");

    Route::get('scratch', function (){
        return view('template.scratch');
    });
    Route::get('scratches', 'ApiController@pretragaSluzbenik');

    Route::get('destroy/{naziv_sesije}',      'HelpController@unistiSesije')->name("unisti.sesiju");
    Route::get('generic_mail',                'HelpController@genericEmails')->name("email.generic");

    ROUTE::post('/notifikacije/oznaci_kao_procitano', 'HelpController@oznaciKaoProcitano');
    Route::get('obavijesti',                          'HelpController@obavijesti')->name('obavijesti');


    Route::get('feedback', 'FeedbackController@index')->name('feedback.index');
    Route::post('feedback/create', 'FeedbackController@create')->name('feedback.create');
    Route::delete('feedback/destroy', 'FeedbackController@delete')->name('feedback.delete');

});

/*** Dodjeljivanje šifre i PIN-a ***/



/*
 * API Route
 */

Route::prefix('/api')->group(function(){
    Route::post('pretraga/sluzbenik', 'ApiController@pretragaSluzbenik')->name('api.pretraga.sluzbenik');

    Route::post('chunked/sluzbenik', 'SluzbenikController@pregledSluzbenika')->name('api.chunked.sluzbenik');

});



//Route::get('/', function () {
//    /** U slučaju da želimo da pošaljemo notifikaciju korisniku putem mail-a, email njegov ide ovdje **/
//
//    // parametri -> Ukoliko želimo da imamo custom subject, custom
//
//    // Notification::route('mail', 'semso@poplava.com')->notify(new NotifyMe(array('subject' => 'Notifikacija bez emaila', 'from' => 'od@koga.com', 'link' => 'home', 'message' => 'Ako ima potrebe da se piše custom poruka, ovdje se piše :DD', 'send_email' => true)));
//
//
//  // $sluzbenik->notify(new NotifyMe(array('subject' => 'Give it a little try', 'from' => 'aladin.kapic@stu.ibu.edu.ba', 'link' => 'home', 'message' => 'Ako ima potrebe da se piše custom poruka, ovdje se piše :DD', 'send_email' => true)));
//
//
//
////
////   Notification::send($me, new NotifyMe(array('subject' => 'Notifikacija bez emaila', 'from' => 'od@koga.com', 'link' => 'home', 'message' => 'Ako ima potrebe da se piše custom poruka, ovdje se piše :DD', 'send_email' => true) ));
////
////    foreach ($sluzbenik->notifications as $notification) {
////         echo $notification->data['sluzbenik_id'];
////    }
//    return view('welcome');
//});


//Route::get('/home', function () {
//    $radnih_mjesta = RadnoMjesto::aktivna()->count();
//    $sluzbenika    = Sluzbenik::count();
//
//    //    RadnoMjesto::aktivnaUpraznjena();
//
//    // $me = Sluzbenik::where('id', Crypt::decryptString(Session::get('ID')))->with('uloge')->first();
//
//    return view('home', compact('radnih_mjesta', 'sluzbenika'));
//}) /* ->middleware('role')  */ ->name('home') ;




//Route::get('/destroy/{naziv_sesije}', function($naziv_sesije){ // uništi određenu sesiju na serveru
//    Session::forget($naziv_sesije);
//
//    if(Session::has($naziv_sesije)){
//        echo Session::get($naziv_sesije);
//    }
//});
/*********************************************** DODJELJIVANJE ULOGA **************************************************/

//Route::get('/roles')


/**************************************************** ODSUSTVA ********************************************************/

Route::prefix('hr/odsustva')->group(function () {
    /* praznici */
    Route::get('/izaberi_korisnika',     'SluzbenikController@pregledSluzbenika')->name('odsustva.izaberi');
    Route::get('/praznici/dodaj',        'OdsustvaController@dodajPraznik')->name('odsustva.dodajpraznik');
    Route::get('/uredi_praznik',         'OdsustvaController@urediPraznike');
    Route::post('/spremi_praznik',       'OdsustvaController@spremiPraznik');
    Route::get('/pregled_praznika',      'OdsustvaController@pregledPraznika');
    Route::get('/obrisi_praznik/{id}',   'OdsustvaController@obrisiPraznik');
    Route::get('/uredi_praznik/{id}',    'OdsustvaController@urediPraznik');
    Route::post('/azuriraj_praznik',     'OdsustvaController@azurirajPraznik');
    Route::post('/daj_praznike',         'OdsustvaController@dajPraznike');

    /* odsustva */

    Route::post('/daj_odsustvo/',        'OdsustvaController@dajOdsustvo');
    Route::post('/spasi_odsustvo',       'OdsustvaController@spasiOdsustvo');
    Route::post('/obrisi_odsustvo',      'OdsustvaController@obrisiOdsustvo');
    Route::post('/odsustvo_json',        'OdsustvaController@jsonOdsustvo');
    Route::post('/azuriraj_odsustvo',    'OdsustvaController@azurirajOdsustvo');

    Route::get('/lista_odsustava/{od}/{do}/{sluzbenik_id}', 'OdsustvaController@listaOdsustava');      // Ovdje ispisujemo odsustva od određenog službenika, vezana za određeni datum !!


    Route::get('/vrste_odsustva',        'OdsustvaController@vrsteOdsustava');          // Postavke - šifrarnik sa vrstama odsustava
    Route::get('/dodaj_vrstu_odsust',    'OdsustvaController@dodajVrstuOdsustva');      // Dodajte vrstu odsustva   - ovdje unosimo u šifrarnik
    Route::post('/spremi_vrstu_odsust',  'OdsustvaController@spremiVrstuOdsustva');     // Spremi u tabelu odsustvo - post request za spremanje u tabelu
    Route::get('/obrisi_vrstu_ods/{id}', 'OdsustvaController@obrisiVrstuOdsustva');     // Obrišite vrstu odsustva  - get request, proslijedi ID odsustva - obriši iz šifrarnika


    Route::get('/limiti',                'OdsustvaController@limitOdsustavaZaSve')->name('limiti.pregledlimita');     // Pregled svih limita po godinama, hronološki poredani - MOGUĆNOST UREĐIVANJA I BRISANJA !!
    Route::get('/postavi_limit_svima',   'OdsustvaController@limitirajOdsustvaZaSve')->name('limiti.dodajlimit');  // Postavi globalni limit za sve službenike na nivou jedne kalendarske godine
    Route::post('/spremi_limit',         'OdsustvaController@spremiLimite');            // Spremi limit u tabelu
    Route::get('obrisi_limite/{id}',     'OdsustvaController@obrisiGlobalniLimit');     // Obriši globalni limit
    Route::get('/uredi_limite/{id}',     'OdsustvaController@urediGlobalniLimit');      // Uredi globalni limit
    Route::post('/azuriraj_limite',      'OdsustvaController@azurirajGlobalniLimit');   // Uredi globalni limit


    Route::get('/limiti_pojedinca/{id}/{godina}',       'OdsustvaController@limitOdsustava');          // Uredite određeni limit za određenog službenika
    Route::get('/uredi_limite/{id}/{sluzbenik_id}',     'OdsustvaController@urediLimitSluzbenika');    // Uredi globalni limit
    Route::post('/azuriraj_o_limit',                    'OdsustvaController@azurirajOdredjeniLimit');  // Ažuriraj određeni limit, provjeri da li ima rekorda ako nema spasi ga !!



    Route::get('/kalendar/{sluzbenik_id}', 'OdsustvaController@kalendar')->name('odsustva.kalendar');
});


/************************************************ DRŽAVNI SLUŽBENICI **************************************************/

Route::prefix('hr/sluzbenici')->group(function () {

    /******************************************** Službenik kontroller ************************************************/

    Route::get('/dodaj_sluzbenika',                    'SluzbenikController@dodajSluzbenika')->name('sluzbenik.dodaj');                            // Ovdje unosimo osnovne informacije o službeniku
    Route::get('/uredi_sluzbenika/{id_sluzbenika}',    'SluzbenikController@urediSluzbenika')->name('sluzbenik.uredi');            // Ovdje možemo urediti osnovne informacije vezane za službenika


    Route::post('/unesi_sliku',                                      'SluzbenikController@unesiSliku');                                                               // Unosimo sliku na server slike/slike_sluzbenika
    Route::post('/provjeri_sluzbenika',                              'SluzbenikController@provjeriSluzbenika');                                               // Ovdje provjeravamo da li ima korisnik sa istim JMBG ili LK - u stvarnom vremenu
    Route::put('/spremi_sluzbenika',                                 'SluzbenikController@spremiSluzbenika');                                                    // Unosimo osnovne detalje o služeniku u bazu
    Route::put('/azurirajSluzbenika',                                'SluzbenikController@azurirajSluzbenika');                                                 // Ažuriranje osnovnih informacija o službeniku
    Route::get('/dodatno_o_sluzbeniku/{id_sluzbenika}',              'SluzbenikController@dodatno_o_sluzbeniku')->name('sluzbenik.dodatno');  // Unesite ostale informacije o službeniku --
    Route::get('/dodatno_o_sluzbeniku/{id_sluzbenika}/{what}',       'SluzbenikController@dodatno_o_sluzbeniku')->name('sluzbenik.dodatnoRjesenje');
    Route::get('/ispis_sluzbenika/{id}',                              'SluzbenikController@ispisSluzbenika')->name('ispis.sluzbenika');

    Route::get('/pregledaj', 'SluzbenikController@pregledSluzbenika')->name('sluzbenik.pregled');
    Route::post('/pregledaj', 'SluzbenikController@pregledSluzbenika')->name('sluzbenik.pregled');
    Route::get('/seedaj',    'SluzbenikController@seedaj')->name('sluzbenik.seedaj');



    /************************************************ Spremi sadržaj **************************************************/
    Route::post('spremi_sadrzaj',   'SluzbenikController@spremiSadrzaj');

    /*********************************************** Izmijeni sadržaj *************************************************/
    Route::post('izmijeni_sadrzaj',   'SluzbenikController@izmijeniSadrzaj');

    /************************************************ Obriši sadržaj **************************************************/
    Route::post('obrisi_sadrzaj',   'SluzbenikController@obrisiSadrzaj');


    Route::get('/seedaj',    'SluzbenikController@seedaj')->name('sluzbenik.seedaj');

    Route::get('/pick', function () {
        return view('/hr/sluzbenici/datepicker');
    });

});



/*************************************************** RADNA MJESTA *****************************************************/

//Route::group(['prefix' => 'hr/radna_mjesta', 'as' => 'radna_mjesta'], function (){

Route::prefix('hr/radna_mjesta')->group(function () {

    Route::get('/home',                              'RadnaMjestaController@svaRadnaMjesta')->name('radna.mjesta.sve');
    Route::get('/dodaj_rm/{id}',                     'RadnaMjestaController@dodajRadnoMjesto');
    Route::post('/spremi_mjesto',                    'RadnaMjestaController@spremiRadnoMjesto');
    Route::get('/pregledaj_radno_mjesto/{id}',       'RadnaMjestaController@pregledajRadnoMjesto')->name('radnamjesta.pregledaj');
    Route::get('/pregledaj_radno_mjesto/{id}/{what}','RadnaMjestaController@pregledajRadnoMjesto')->name('radnamjesta.rjesenje');
    Route::get('/pregledaj_radno_mjestooo/{id}',     'RadnaMjestaController@pregledajRadnoMjestoooo')->name('radnamjesta.pregledaj-mjestooo');

    Route::get('/uredi_radno_mjesto/{id}',           'RadnaMjestaController@urediRadnoMjesto');
    Route::post('/azuriraj_rm',                      'RadnaMjestaController@azurirajRadnoMjesto');
});



/*********************************************** UPRAVLJANJE UČINKOM **************************************************/



/**************************************************** Šifrarnici ******************************************************/

Route::prefix('sifrarnici')->group(function(){
    Route::get('svi_sifrarnici',         'SifrarnikController@sviSifrarnici')->name('svi.sifrarnici');          // Pregled svih šifrarnika
    Route::get('dodaj/{type}',            'SifrarnikController@dodajSifrarnik')->name('dodaj.sifrarnik');       // type je vrijednost - nacionalnost
    Route::get('unesi/{type}',            'SifrarnikController@unosSifrarnika')->name('unos.sifrarnika');       //
    Route::post('spremi',                 'SifrarnikController@spremiSifrarnik')->name('spremi.sifrarnik');
    Route::get('obrisi/{type}/{id}',      'SifrarnikController@obrisiSifrarnik')->name('obrisi.sifrarnik');
});



/*********************************************** Strateško planiranje *************************************************/
Route::prefix('ostalo/stratesko_planiranje')->group(function () {
    Route::get('home',             'StrateskoPlController@pregled')->name('pregled.strateskogplaniranja');
    Route::get('unos',             'StrateskoPlController@unos')->name('unos.strateskogplaniranja');
    Route::post('spremi',          'StrateskoPlController@spremiSP')->name("spremi.strateskoplaniranje");

    Route::get('uredi/{id}',       'StrateskoPlController@urediSP')->name('uredi.strateskoplaniranje');
    Route::post('azuriraj',        'StrateskoPlController@azurirajSp')->name('azurira.strateskoplaniranje');
    Route::get('pregled/{id}',     'StrateskoPlController@pregledSP')->name('pregled.strateskoplaniranje');
});


/*********************************************** Interno tržište rada *************************************************/
Route::prefix('/ostalo/interno_trziste')->group(function () {
    Route::get('pregled',             'InternoTrzisteController@pregled')->name('internotrziste.pregled');
    Route::get('radnomjesto/{id}',    'InternoTrzisteController@radnoMjesto')->name('internotrziste.radnomjesto');
    Route::post('rjesenje',           'InternoTrzisteController@rjesenje');
    Route::post('rjesenjeKorisnika',  'InternoTrzisteController@rjesenjeKorisnika');


    Route::get('prekobrojni_ljudi',   'InternoTrzisteController@prekobrojniLjudi')->name('internotrziste.prekobrojniljudi');
    Route::get('prekobrojni_ljudi/{id}','InternoTrzisteController@sviPrekobrojniLjudi')->name('internotrziste.sviprekobrojniljudi');

    Route::post('spremiRjesenje',     'InternoTrzisteController@spremiRjesenje')->name('internotrziste.spremiRjesenje');
    Route::post('spremiRjesenjeKorisnika', 'InternoTrzisteController@spremiRjesenjeKorisnika')->name('internotrziste.spremiRjesenjeKorisnika');


    Route::get('privremeni_premjestaj','InternoTrzisteController@privremeniPremjestaj')->name('internotrziste.privremeni.premjestaj');
});


/***************************************************** eKonkurs *******************************************************/

Route::prefix('ekonkurs')->group(function () {
    Route::get('request',             'eKonkursController@request')->name('ekonkurs.request');
    Route::post('request',             'eKonkursController@request')->name('ekonkurs.request');
    Route::get('historija',           'eKonkursController@historija')->name('ekonkurs.historija');

    Route::post('curl',               'eKonkursController@curl')->name('ekonkurs.curl');
    Route::get('curl',                'eKonkursController@curl')->name('ekonkurs.curl');
    Route::get('procedure',           'eKonkursController@dajProceduru')->name('ekonkurs.procedure');
});


/*************************************************** Help control *****************************************************/
Route::prefix('help')->group(function () {

    Route::post('/help/obrisi_iz_baze',            'HelpController@obrisiIzBaze');

});



/***************************************************** PRETRAGA *******************************************************/

Route::group(['prefix' => 'hr/pretraga', 'as' => 'pretraga'], function (){

    Route::post('/pretrazi_korisnika',                 'SearchController@searchUserByName');

});



/************************************************* PRIJAVA KORISNIKA **************************************************/
Route::get('/prijava', function(){
    return view('/prijava/prvi_stepen');
});



/************************************************* Export podataka ****************************************************/

Route::prefix('export')->group(function () {
    Route::post('excel',                'ExportController@excel')    ->name('export.excel');
    Route::post('pdf',                  'ExportController@pdf')      ->name('export.pdf');
    Route::post('word',                 'ExportController@word')     ->name('export.word');

    Route::get('read-pdf/{name}',       'ExportController@readPdf')->name('export.read-pdf');
    Route::post('download',             'ExportController@download') ->name('export.download');
});

/**************************************************** Izvještaji ******************************************************/
Route::prefix('izvjestaji')->group(function () {
    Route::get('pregled',                'IzvjestajiController@pregled')->name('izvjestaji.pregled');
});


/************************************************** Authentikacija ****************************************************/

Route::get('/prijavi_me', 'Auth@redirektajPrijavu');
Route::post('/prijavi_me', 'Auth@prijavime');
Route::post('/provjeri_pin', 'Auth@provjeri_pin');
Route::get('/odjavi_me', 'Auth@odjavi_me');

/************************************************* Uloge kontroleri ***************************************************/
Route::prefix('uloge')->middleware('role:postavke')->group(function () {
    Route::get('/pregled_uloga',              'Auth@pregledUloga')->name('izvjestaji.pregled.uloga');
    Route::get('/dodijeliUlogu/{id}',         'Auth@dodijeliUlogu')->name("izvjestaji.dodijeli.ulogu");
    Route::get('/generisi-sifru/{id}',        'Auth@generisiSifru')->name("izvjestaji.generisi-sifru");
    Route::post('/azuriraj_uloge',            'Auth@azurirajUloge')->name('izvjestaji.azuriraj.uloge');
    Route::post('/validiraj-sifru',           'Auth@validirajSifru')->name('validiranje-sifre');
});


Route::get('/encrypt', function(){ /*** Probna routa za igranje sa enkripcijama - Može se vidjeti ID logovanog korisnika ***/

    if(Session::has('ID')) dd(Crypt::decryptString(Session::get('ID')));


    /* $encrypted = Crypt::encryptString('aladin');

    echo '<br><br>';

    dd($decrypted = Crypt::decryptString($encrypted)); */
});







/*
 * Unutrašnja organizacija
 */

Route::prefix('organizacija')->group(function () {

    /*
     * Organizacioni Plan
     *
     */

    Route::get('index',             'OrganizacijaController@index')->name('organizacija.index');
    Route::get('edit/{id}',         'OrganizacijaController@edit')->name('organizacija.edit');
    Route::get('create',            'OrganizacijaController@create')->name('organizacija.create');
    Route::get('nova',              'OrganizacijaController@nova')->name('organizacija.novaaa');
    Route::put('store',             'OrganizacijaController@store')->name('organizacija.store');
    Route::delete('destroy/{id}',   'OrganizacijaController@destroy')->name('organizacija.destroy');
    Route::post('active/{id}',      'OrganizacijaController@active')->name('organizacija.active');


    /*
     * Organizacija API
     */

    Route::post('api', 'OrganizacijaController@api')->name('organizacija.api');


    /*
        Pregled organizacionog plana
    */

    Route::get('shema/{id}',         'OrganizacijaController@shema')->name('organizacija.shema');
    Route::get('radna-mjesta/{id}',  'OrganizacijaController@radnaMjesta')->name('organizacija.radna-mjesta');
    Route::get('jedinica/edit/{id}', 'OrganizacijaController@editJedinica')->name('organizacija.jedinica.edit');


    /*
     * Organizaciona jedinica
     */

    Route::put('jedinica/store', 'OrganizacionaJedinicaController@store')->name('organizaciona.jedinica.store');
    Route::post('jedinica/edit', 'OrganizacionaJedinicaController@edit')->name('organizaciona.jedinica.edit');
    Route::delete('jedinica/delete', 'OrganizacionaJedinicaController@delete')->name('organizaciona.jedinica.delete');
    Route::post('jedinica/api/getOrgBroj', 'OrganizacionaJedinicaController@getOrgBroj');
});



/*
 * Registar ugovora
 */

Route::prefix('ugovori')->group(function () {

    /*
     * Radni status i raspored na radno mjesto
     *
     */

    Route::get('index',                     'UgovorController@index')->name('ugovor.index');
    Route::get('radni-status/create',       'UgovorController@createRadniStatus')->name('ugovor.radni_status.create');
    Route::get('radni-status/destroy/{id}', 'UgovorController@destroyRadniStatus')->name('ugovor.radni_status.destroy');
    Route::put('radni-status/store',        'UgovorController@storeRadniStatus')->name('ugovor.radni_status.store');
    Route::get('radni-status/edit/{id}',    'UgovorController@editRadniStatus')->name('ugovor.radni_status.edit');
    Route::patch('radni-status/edit/{id}',  'UgovorController@updateRadniStatus')->name('ugovor.radni_status.update');

    Route::get('mjesto-rada/index',         'UgovorController@indexMjestoRada')->name('ugovor.mjesto_rada.index');
    Route::get('mjesto-rada/destroy/{id}',  'UgovorController@destroyMjestoRada')->name('ugovor.mjesto_rada.destroy');
    Route::get('mjesto-rada/create',        'UgovorController@createMjestoRada')->name('ugovor.mjesto_rada.create');
    Route::put('mjesto-rada/create',        'UgovorController@storeMjestoRada')->name('ugovor.mjesto_rada.store');
    Route::get('mjesto-rada/edit/{id}',     'UgovorController@editMjestoRada')->name('ugovor.mjesto_rada.edit');
    Route::patch('mjesto-rada/edit/{id}',   'UgovorController@updateMjestoRada')->name('ugovor.mjesto_rada.update');

    Route::get('privremeno/index',          'UgovorController@indexPrivremeno')->name('ugovor.privremeno.index');
    Route::get('privremeno/destroy/{id}',   'UgovorController@destroyPrivremeno')->name('ugovor.privremeno.destroy');
    Route::get('privremeno/create',         'UgovorController@createPrivremeno')->name('ugovor.privremeno.create');
    Route::post('privremeno/radna_mjesta',  'UgovorController@radnaMjesta')->name('ugovor.privremeno.radnamjesta');
    Route::put('privremeno/create',         'UgovorController@storePrivremeno')->name('ugovor.privremeno.store');
    Route::get('privremeno/edit/{id}',      'UgovorController@editPrivremeno')->name('ugovor.privremeno.edit');
    Route::patch('privremeno/edit/{id}',    'UgovorController@updatePrivremeno')->name('ugovor.privremeno.update');

    /*
     * Evidencija prestanka radnog odnosa
     */

    Route::get('prestanak/index',          'UgovorController@indexPrestanak')->name('ugovor.prestanak.index');
    Route::get('prestanak/destroy/{id}',   'UgovorController@destroyPrestanak')->name('ugovor.prestanak.destroy');
    Route::get('prestanak/create',         'UgovorController@createPrestanak')->name('ugovor.prestanak.create');
    Route::put('prestanak/create',         'UgovorController@storePrestanak')->name('ugovor.prestanak.store');
    Route::get('prestanak/edit/{id}',      'UgovorController@editPrestanak')->name('ugovor.prestanak.edit');
    Route::patch('prestanak/edit/{id}',    'UgovorController@updatePrestanak')->name('ugovor.prestanak.update');

    /*
     * Evidencija o dodatnim djelatnostima
     */

    Route::get('dodatno/index',            'UgovorController@indexDodatno')->name('ugovor.dodatno.index');
    Route::get('dodatno/destroy/{id}',     'UgovorController@destroyDodatno')->name('ugovor.dodatno.destroy');
    Route::get('dodatno/create',           'UgovorController@createDodatno')->name('ugovor.dodatno.create');
    Route::put('dodatno/create',           'UgovorController@storeDodatno')->name('ugovor.dodatno.store');
    Route::get('dodatno/edit/{id}',        'UgovorController@editDodatno')->name('ugovor.dodatno.edit');
    Route::patch('dodatno/edit/{id}',      'UgovorController@updateDodatno')->name('ugovor.dodatno.update');


});



//Drzavni sluzbenici
Route::get('/hr/sluzbenici/dodaj', function () {
    return view('hr/sluzbenici/dodaj');
});


//Radna mjesta
//Route::get('/hr/radna_mjesta/home', function () {
//    return view('hr/radna_mjesta/home');
//});

Route::get('/hr/radna_mjesta/view', function () {
    return view('hr/radna_mjesta/view');
});

Route::get('/hr/radna_mjesta/add', function () {
    return view('hr/radna_mjesta/add');
});

//Ugovori
/*
Route::get('/hr/ugovori2/ugovori2', function () {
    return view('hr/ugovori2/ugovori2');
});
Route::get('/hr/ugovori2/pregled', function () {
    return view('hr/ugovori2/pregled');
});
Route::get('/hr/ugovori2/novi', function () {
    return view('hr/ugovori2/novi');
});
Route::get('/hr/ugovori2/novi-korak2', function () {
    return view('hr/ugovori2/novi-korak2');
});
Route::get('/hr/ugovori2/novi-korak3', function () {
    return view('hr/ugovori2/novi-korak3');
});
Route::get('/hr/ugovori2/novi-korak4', function () {
    return view('hr/ugovori2/novi-korak4');
});
Route::get('/hr/ugovori2/novi-korak5', function () {
    return view('hr/ugovori2/novi-korak5');
});
*/
//Organ javne uprave
Route::get('/hr/organ_javne_uprave/home', function () {
    return view('hr/organ_javne_uprave/home');
});

Route::get('/hr/organ_javne_uprave/view', function () {
    return view('hr/organ_javne_uprave/view');
});


Route::resource('hr/organ_javne_uprave/home', 'UpravaController');

Route::post('/hr/uprava/store',                 'UpravaController@storeUprava')->name('uprava.store');
Route::get('/hr/uprava/viewUprava/{id}',        'UpravaController@show');
Route::get('/hr/uprava/editUprava/{id}',        'UpravaController@edit');
Route::post('/hr/uprava/updateUprava/{id}',     'UpravaController@update');
Route::get('/hr/uprava/delete/{id}',            'UpravaController@destroy');
Route::get('/hr/organ_javne_uprave/add',        'UpravaController@create')->name('novi-organ-javne-uprave');




//NAPOMENA
Route::post('/napomenaSubmit', 'NapomenaController@submit');
Route::get('/napomena', 'NapomenaController@index');
Route::get('/napomenaCount', 'NapomenaController@no');
Route::get('/napomenaDelete/{id}', 'NapomenaController@delete');




//HISTORIZACIJA
Route::get('/ostalo/historizacija/home',          'ActivityLogController@index');
Route::get('/ostalo/historizacija/detalji/{id}',  'ActivityLogController@show');




//OSPOSOBLJAVANJE I USAVRŠAVANJE


Route::prefix('/osposobljavanje_i_usavrsavanje')->group(function(){
    Route::get('/obuke/add',                       'ObukaController@novaObuka');
    Route::get('/obuke/addInstancu/{id}',          'ObukaController@dodajInstancuObuke')->name('dodaj-instancu-obuke');
    Route::post('/spremi-instancu-obuke',          'ObukaController@spremiInstancuObuke')->name('spremi-instancu-obuke');
    Route::post('/spremi-obuke',                   'ObukaController@spremiObuku')->name('spremi-obuke');

    Route::get('pregled-obuke/{id}',               'ObukaController@pregledObuke')->name('pregled-obuke');
    Route::get('uredite-obuke/{id}',               'ObukaController@urediObuku')->name('uredi-obuku');
    Route::post('azurirajte-obuke',                'ObukaController@azurirajObuku')->name('azuriraj-obuku');

    Route::get('pregled-instanci-obuke/{id}',      'ObukaController@pregledInstanciObuke')->name('pregled-instanci-obuke');
    Route::get('pregleda-instancu/{id}',           'ObukaController@pregledajInstancuObuke')->name('pregledaj-instancu-obuke');
    Route::post('ocijenu-predavaca',               'ObukaController@ocijeniPredavaca')->name('ocijeni-predavaca');
    Route::get('pregleda-ocjena-predavaca/{id}',   'ObukaController@ocjenePredavaca')->name('ocjene-predavaca');
});

//OBUKE

Route::get('/osposobljavanje_i_usavrsavanje/obuke/home',          'ObukaController@index')->name('sve-obuke');
Route::get('/osposobljavanje_i_usavrsavanje/obuke/view/{id}',     'ObukaController@show');
//Route::get('/osposobljavanje_i_usavrsavanje/obuke/add',           'ObukaController@create');
Route::post('/osposobljavanje_i_usavrsavanje/obuke/add',          'ObukaController@store');
Route::get('/osposobljavanje_i_usavrsavanje/obuke/delete/{id}',   'ObukaController@destroy');
Route::get('/osposobljavanje_i_usavrsavanje/obuke/edit/{id}',     'ObukaController@edit');
Route::post('/osposobljavanje_i_usavrsavanje/obuke/update/{id}',  'ObukaController@update');

//Route::get('/osposobljavanje_i_usavrsavanje/obuke/addInstancu/{id}',          'ObukaController@addInstancu');




Route::get('/osposobljavanje_i_usavrsavanje/obuke/prikazocjenaInstance/{id}', 'ObukaController@pregledInstance');
Route::get('/osposobljavanje_i_usavrsavanje/obuke/ocjenaInstance/{id}',       'ObukaController@ocjenaInstance');
Route::get('/osposobljavanje_i_usavrsavanje/obuke/ocjenaInstance/{id}/{sl}',  'ObukaController@ocjenaInstance');
Route::post('/osposobljavanje_i_usavrsavanje/obuke/addInstancu',              'ObukaController@addInstancu');
Route::post('/osposobljavanje_i_usavrsavanje/obuke/storeInstancu',            'ObukaController@storeInstancu');
Route::get('/osposobljavanje_i_usavrsavanje/obuke/instance/{id}',             'ObukaController@instance');
Route::get('/osposobljavanje_i_usavrsavanje/obuke/deleteInstance/{id}',       'ObukaController@deleteInstance');

Route::post('/osposobljavanje_i_usavrsavanje/obuke/ocjeni', 'ObukaController@ocjeni');


//AJAX
Route::get('/osposobljavanje_i_usavrsavanje/obuke/ajax', 'ObukaController@ajaxrequest');
Route::post('/osposobljavanje_i_usavrsavanje/obuke/ajax2', 'ObukaController@loadPodteme')->name('loadPodteme');


//predavači

Route::get('/osposobljavanje_i_usavrsavanje/predavaci/home', function () {
    return view('osposobljavanje_i_usavrsavanje/predavaci/home');
});

Route::get('/osposobljavanje_i_usavrsavanje/predavaci/view', function () {
    return view('osposobljavanje_i_usavrsavanje/predavaci/view');
});

Route::get('/osposobljavanje_i_usavrsavanje/predavaci/add', function () {
    return view('osposobljavanje_i_usavrsavanje/predavaci/add');
});

Route::resource('osposobljavanje_i_usavrsavanje/predavaci/home', 'PredavaciController');
Route::post('/osposobljavanje_i_usavrsavanje/predavaci/store', 'PredavaciController@storePredavaci')->name('predavac.store');
Route::get('/osposobljavanje_i_usavrsavanje/predavaci/viewPredavac/{id}', 'PredavaciController@show');
Route::get('/osposobljavanje_i_usavrsavanje/predavaci/editPredavac/{id}', 'PredavaciController@edit')->name('uredi-predavaca');
Route::post('/osposobljavanje_i_usavrsavanje/predavaci/updatePredavac/{id}', 'PredavaciController@update');
Route::get('/osposobljavanje_i_usavrsavanje/predavaci/delete/{id}', 'PredavaciController@destroy')->name('obrisi-predavaca');
Route::get('/osposobljavanje_i_usavrsavanje/predavaci/add', 'PredavaciController@create');
Route::get('/osposobljavanje_i_usavrsavanje/predavaci/index', 'PredavaciController@index');

//teme za obuku

Route::get('/osposobljavanje_i_usavrsavanje/teme/home', function () {
    return view('osposobljavanje_i_usavrsavanje/teme/home');
});

Route::get('/osposobljavanje_i_usavrsavanje/teme/view', function () {
    return view('osposobljavanje_i_usavrsavanje/teme/view');
});

Route::get('/osposobljavanje_i_usavrsavanje/teme/add', function () {
    return view('osposobljavanje_i_usavrsavanje/teme/add');
});

Route::resource('osposobljavanje_i_usavrsavanje/teme/home', 'TemeController');
Route::post('/osposobljavanje_i_usavrsavanje/teme/store', 'TemeController@storeTeme')->name('tema.store');
Route::get('/osposobljavanje_i_usavrsavanje/teme/viewTema/{id}', 'TemeController@show');
Route::get('/osposobljavanje_i_usavrsavanje/teme/editTema/{id}', 'TemeController@edit');
Route::post('/osposobljavanje_i_usavrsavanje/teme/updateTema/{id}', 'TemeController@update');
Route::get('/osposobljavanje_i_usavrsavanje/teme/delete/{id}', 'TemeController@destroy');
Route::get('/osposobljavanje_i_usavrsavanje/teme/add', 'TemeController@create');
Route::get('/osposobljavanje_i_usavrsavanje/teme/index', 'TemeController@index');





Route::group(['prefix'=>'hr/odsustva','as'=>'odsustva'], function() {


    Route::get('', function () {
        return view('/hr/odsustva/home');
    });

    Route::get('/odsustva', function () {
        return view('hr/odsustva/odsustva');
    });

//    Route::get('/view', function () {
//        return view('hr/odsustva/view');
//    });

    Route::get('/add', function () {
        return view('hr/odsustva/add');
    });

    Route::post('/pregled', function () {
        return view('hr/odsustva/pregled');
    });

//    Route::get('/limit', function () {
//        return view('hr/odsustva/limit');
//    });

    Route::get('/edit', function () {
        return view('hr/odsustva/edit');
    });



});

//UPRAVLJANJE UČINKOM

Route::prefix('/hr/upravljanje_ucinkom/')->group(function() {
    Route::get('home',                       'UpravljanjeUcinkomController@index')->name('upravljanje-ucinkom-pregled');
    Route::get('add',                        'UpravljanjeUcinkomController@create')->name('upravljanje-ucinkom-dodaj');
    Route::get('viewUcinak/{id}',            'UpravljanjeUcinkomController@show')->name('upravljanje-ucinkom-pregledaj');

    Route::get('pregled-izvjestaja',         'UpravljanjeUcinkomController@pregledIzvjestaja')->name('upravljanje-ucinkom.pregled-izvjestaja');
});



Route::post('/hr/upravljanje_ucinkom/store',             'UpravljanjeUcinkomController@storeUcinci')->name('ucinak.store');
Route::get('/hr/upravljanje_ucinkom/editUcinak/{id}',    'UpravljanjeUcinkomController@edit')->name('ucinak.uredite');
Route::post('/hr/upravljanje_ucinkom/updateUcinak/{id}', 'UpravljanjeUcinkomController@update');
Route::get('/hr/upravljanje_ucinkom/delete/{id}',        'UpravljanjeUcinkomController@destroy')->name('ucinak.obrisi');
Route::get('/hr/upravljanje_ucinkom/add',                'UpravljanjeUcinkomController@create');
Route::get('/hr/upravljanje_ucinkom/index',              'UpravljanjeUcinkomController@index');

Route::get('/hr/upravljanje_ucinkom/pregled-probnih',           'UpravljanjeUcinkomController@pregledProbnih')->name("probni-rad.pregled");
Route::get('/hr/upravljanje_ucinkom/dodaj-probni',              'UpravljanjeUcinkomController@dodajProbni')->name('probni-rad.dodaj');
Route::post('/hr/upravljanje_ucinkom/spremi-probni',            'UpravljanjeUcinkomController@spremiProbni')->name('probni-rad.spremi');
Route::get('/hr/upravljanje_ucinkom/pregledaj-probni/{id}',     'UpravljanjeUcinkomController@pregledajProbni')->name('probni-rad.pregledaaj');
Route::get('/hr/upravljanje_ucinkom/uredi-probni/{id}',         'UpravljanjeUcinkomController@urediProbni')->name('probni-rad.uredii');
Route::post('/hr/upravljanje_ucinkom/azuriraj-probni',          'UpravljanjeUcinkomController@azurirajProbni')->name('probni-rad.azuriraj');


//Disciplinska odgovornost

Route::prefix('hr/disciplinska_odgovornost/')->group(function (){
    Route::get('home',                       'DisciplinskaOdgovornostController@index')    ->name('disciplinska.pregled');
    Route::get('add',                        'DisciplinskaOdgovornostController@create')   ->name('disciplinska.dodaj');
    Route::post('storeOdgovornost',          'DisciplinskaOdgovornostController@store')    ->name('disciplinska.spremi');

    Route::get('pregled/{id}',               'DisciplinskaOdgovornostController@show')     ->name('disciplinska.pregledaj');
    Route::get('uredite/{id}',               'DisciplinskaOdgovornostController@edit')     ->name('disciplinska.uredite');
    Route::post('azuriraj',                  'DisciplinskaOdgovornostController@update')   ->name('disciplinska.azuriraj');
    Route::get('obrisi/{id}',                'DisciplinskaOdgovornostController@destroy')  ->name('disciplinska.obrisi');



    /*******************************************************************************************************************
     *
     *      Žalbe - CRUD sa žalbama
     *
     ******************************************************************************************************************/

    Route::get('/pregled_zalbi',             'DisciplinskaOdgovornostController@pregledZalbi')->name('zalbe.pregled');
    Route::get('/unos_zalbe',                'DisciplinskaOdgovornostController@unosZalbe')->name('zalbe.unos');
    Route::post('/spremi_zalbu',             'DisciplinskaOdgovornostController@spremiZalbu')->name('zalbe.spremi');
    Route::get('/pregledajte_zalbu/{id}',    'DisciplinskaOdgovornostController@pregledajZalbu')->name('zalbe.pregledaj');
    Route::get('/uredite_zalbu/{id}',        'DisciplinskaOdgovornostController@urediZalbu')->name('zalba.uredi');
    Route::post('/azuriraj_zalbu',           'DisciplinskaOdgovornostController@azurirajZalbu')->name('zalba.azuriraj');
    Route::get('/obrisite_zalbu/{id}',       'DisciplinskaOdgovornostController@obrisiZalbu')->name('zalba.obrisi');


    /*******************************************************************************************************************
     *
     *      Suspenzije - CRUD sa žalbama
     *
     ******************************************************************************************************************/

    Route::get('/pregled_suspenzija',             'DisciplinskaOdgovornostController@pregledSuspenzija')  ->name('suspenzije.pregled');
    Route::get('/unos_suspenzija',                'DisciplinskaOdgovornostController@unosSuspenzija')     ->name('suspenzije.unos');
    Route::post('/spremi_suspenzija',             'DisciplinskaOdgovornostController@spremiSuspenziju')   ->name('suspenzije.spremi');
    Route::get('/pregledajte_suspenzija/{id}',    'DisciplinskaOdgovornostController@pregledajSuspenziju')->name('suspenzije.pregledaj');
    Route::get('/uredite_suspenzija/{id}',        'DisciplinskaOdgovornostController@urediSuspenziju')    ->name('suspenzije.uredi');
    Route::post('/azuriraj_suspenzija',           'DisciplinskaOdgovornostController@azurirajSuspenziju') ->name('suspenzije.azuriraj');
    Route::get('/obrisite_suspenziju/{id}',       'DisciplinskaOdgovornostController@obrisiSuspenziju')   ->name('suspenzije.obrisi');

});

/*******************************************************************************************************************
 *
 *      HR Aktivnosti
 *          -Obavijesti
 *
 ******************************************************************************************************************/

Route::get('/obavijesti/pregled', 'ObavijestController@index');
Route::post('/obavijesti/ajaxpregled', 'ObavijestController@ajaxRead');

Route::get('/import', 'ImportController@handle');

/*************************************************** Ugovori  *****************************************************/

Route::get('/uvjerenje_rm',                  'UgovoriController@uvjerenje_rm')->name('uvjerenje_rm');
Route::get('/placeno_odsustvo',              'UgovoriController@placeno_odsustvo')->name('placeno_odsustvo');
Route::get('/go',                            'UgovoriController@go')->name('godisnji_odmor');
Route::get('/rjesenje_plata',                'UgovoriController@rjesenje_plata')->name('rjesenje_plata');
Route::get('/prestanak_ro',                  'UgovoriController@prestanak_ro')->name('prestanak_ro');

