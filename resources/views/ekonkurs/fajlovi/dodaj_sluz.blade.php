<div class="split_container">
    <div class="form-group row">
    {!! Form::hidden('id_sluzbenika', isset($sluzbenik) ? $sluzbenik->id : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'id_sluzbenika']) !!}

    <!-- Ime -->
        <div class="col">
            {!! Form::label('ime', __('Ime').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('ime', isset($sluzbenik) ? $sluzbenik->ime : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'ime', 'onkeyup' => 'kreirajKorisnickoIme(), verifikuj_string("ime", "Ime službenika ne smije sadržavati brojeve !", "ima_li_brojeva")', 'autocomplete' => 'off']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('prezime', __('Prezime').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('prezime', isset($sluzbenik) ? $sluzbenik->prezime : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'prezime', 'onkeyup' => 'kreirajKorisnickoIme(), verifikuj_string("prezime", "Prezime službenika ne smije sadržavati brojeve !", "ima_li_brojeva")', 'autocomplete' => 'off']) !!}
            </div>
        </div>
    </div>

    <div class="notificaiton_area" id="ime_not"> <p id="ime_not_v"></p> </div> <!-- obavijest za ime -->
    <div class="notificaiton_area" id="prezime_not"> <p id="prezime_not_v"></p> </div> <!-- obavijest za prezime -->

    <div class="form-group row">
        <div class="col">
            {!! Form::label('username', __('Korisničko ime').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('[korisnicko_ime]', isset($sluzbenik) ? $sluzbenik->korisnicko_ime : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'korisnicko_ime', 'readonly']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('email', __('Email').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('email', isset($sluzbenik) ? $sluzbenik->email : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'email', 'autocomplete' => 'off', 'onkeyup' => 'verifikuj_string("email", "Uneseni podaci nemaju formu maila. Jeste li zaboravili -@- ?", "email")']) !!}
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col">
            {!! Form::label('jmbg', __('JMBG').' : ', ['class' => ' control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('jmbg', isset($sluzbenik) ? $sluzbenik->jmbg : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'jmbg', 'onkeyup' => 'provjeriPodatke(this, "jmbg", "jmbg"), verifikuj_string("jmbg", "JMBG ne smije sadržavati ništa osim brojeva. Molimo provjerite !", "ima_li_slova")', 'autocomplete' => 'off']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('ime_roditelja', __('Ime roditelja').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('ime_roditelja', isset($sluzbenik) ? $sluzbenik->ime_roditelja : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'ime_roditelja', 'autocomplete' => 'off']) !!}
            </div>
        </div>
    </div>

    <div class="notificaiton_area" id="jmbg_not"> <p id="jmbg_not_v"></p> </div> <!-- DA li je forma email-a ? -->

    <div class="form-group row">
        <div class="col">
            {!! Form::label('pol', __('Spol').': ', ['class' => ' control-label'] )  !!}

            <div class="col-lg-12">
                {!!  Form::select('pol', ['0' => 'Muško', '1' => 'Žensko'], isset($sluzbenik) ? $sluzbenik->pol : '' ,['class' => 'form-control', 'onchange' => 'djevojacko_prezime(this)', 'id' => 'pol']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('kategorija', __('Kategorija').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!!  Form::select('kategorija', ['0' => 'Prva kategorija', '1' => 'Druga kategorija'], isset($sluzbenik) ? $sluzbenik->kategorija : '' ,['class' => 'form-control',  'id' => 'kategorija']) !!}
            </div>
        </div>
    </div>

    <div class="notificaiton_area" id="jmbg_not"> <p id="jmbg_not_v"></p> </div> <!-- Da  -->

    <div class="form-group row">
        <div class="col djevojacko_prezime_input">
            {!! Form::label('djevojacko_prezime', __('Djevojačko prezime').' : ', ['class' => 'control-label djevojacko_prezime hidden']) !!}
            <div class="col-lg-12">
                {!! Form::text('djevojacko_prezime', isset($sluzbenik) ? $sluzbenik->djevojacko_prezime : '', ['class' => 'form-control hidden', 'id' => 'djevojacko_prezime', 'onkeyup' => 'verifikuj_string("djevojacko_prezime", "Djevojačko prezime ne smije sadržavati brojeve !", "ima_li_brojeva")']) !!}
            </div>
        </div>
    </div>

    <div class="notificaiton_area" id="djevojacko_prezime_not"> <p id="djevojacko_prezime_not_v"></p> </div> <!-- obavijest za djevojacko_prezime -->

    <div class="form-group row">
        <div class="col">
            {!! Form::label('drzavljanstvo_1', __('Državljanstvo 1').' : ', ['class' => ' control-label'] )  !!}
            <div class="col-lg-12">
                {!! Form::text('drzavljanstvo_1', isset($sluzbenik) ? $sluzbenik->drzavljanstvo_1 : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'drzavljanstvo_1', 'autocomplete' => 'off', 'onkeyup' => 'verifikuj_string("drzavljanstvo_1", "Državljanstvo ne smije sadržavati brojeve !", "ima_li_brojeva")']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('drzavljanstvo_2', __('Državljanstvo 2').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('drzavljanstvo_2', isset($sluzbenik) ? $sluzbenik->drzavljanstvo_2 : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'drzavljanstvo_2', 'autocomplete' => 'off', 'onkeyup' => 'verifikuj_string("drzavljanstvo_2", "Državljanstvo ne smije sadržavati brojeve !", "ima_li_brojeva")']) !!}
            </div>
        </div>
    </div>

    <div class="notificaiton_area" id="drzavljanstvo_1_not"> <p id="drzavljanstvo_1_not_v"></p> </div> <!-- obavijest za drzavljanstvo_1 -->
    <div class="notificaiton_area" id="drzavljanstvo_2_not"> <p id="drzavljanstvo_2_not_v"></p> </div> <!-- obavijest za drzavljanstvo_2 -->

    <div class="form-group row">
        <div class="col">
            {!! Form::label('nacionalnost', __('Nacionalnost').' : ', ['class' => ' control-label'] )  !!}
            <div class="col-lg-12">
                {!!  Form::select('nacionalnost', ['0' => 'Bošnjak', '1' => 'Srbin' ], isset($sluzbenik) ? $sluzbenik->nacionalnost : '' ,['class' => 'form-control', 'id' => 'nacionalnost']) !!}
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col">
            {!! Form::label('bracni_status', __('Bračni status').' : ', ['class' => ' control-label'] )  !!}
            <div class="col-lg-12">
                {!!  Form::select('bracni_status', ['0' => 'Slobodan', '1' => 'Oženjen'], isset($sluzbenik) ? $sluzbenik->bracni_status : '' ,['class' => 'form-control', 'id' => 'bracni_status']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('mjesto_rodjenja', __('Mjesto rođenja').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('mjesto_rodjenja', isset($sluzbenik) ? $sluzbenik->mjesto_rodjenja : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'mjesto_rodjenja', 'autocomplete' => 'off', 'onkeyup' => 'verifikuj_string("mjesto_rodjenja", "Mjesto rođenja ne smije sadržavati brojeve !", "ima_li_brojeva")']) !!}
            </div>
        </div>
    </div>

    <div class="notificaiton_area" id="mjesto_rodjenja_not"> <p id="mjesto_rodjenja_not_v"></p> </div> <!-- obavijest za mjesto_rodjenja -->

    <div class="dates">
        {!! Form::label('usrl', __('Datum rođenja').' : ', ['class' => 'control-label']) !!}
        <input type="text" class="form-control" id="usr1" name="datum_rođenja" value="{{isset($sluzbenik) ? \App\Http\Controllers\HelpController::obrniDatum($sluzbenik->datum_rodjenja) : ''}}" placeholder="" autocomplete="off">
    </div>
</div>
<div class="split_container">
    <div class="slika_sluzbenika">
        @php isset($sluzbenik) ? $url = 'slike/slike_sluzbenika/'.$sluzbenik->fotografija : $url = '' @endphp

        <img src="{{asset($url) }}" id="slika_sluz" alt="">
        <input type="hidden" name="fotografija" id="fotografija" value="{{isset($sluzbenik->fotografija) ? $sluzbenik->fotografija : '' }}">

        <form enctype="multipart/form-data">
        @csrf <!-- {{ csrf_field() }} -->
            <label for="sluzbenik_slika">
                <div class="slika_sluzbenika_sjena" title="Izaberite sliku službenika">
                    <i class="fas fa-camera-retro"></i>
                </div>
            </label>
            <input type="file" onchange="upload_slider_image('sluzbenik_slika', 'slika_sluz', '/slike/slike_sluzbenika/', 'fotografija');" name="sluzbenik_slika" id="sluzbenik_slika" class="hidden">
        </form>
    </div>

    <div class="form-group row">
        <div class="col">
            {!! Form::label('licna_karta', __('Lična karta').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('licna_karta', isset($sluzbenik) ? $sluzbenik->licna_karta : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'licna_karta', 'onkeyup' => 'provjeriPodatke(this, "licna_karta", "licna_karta")', 'autocomplete' => 'off']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('mjesto_izdavanja_lk', __('Mjesto izdavanja LK').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('mjesto_izdavanja_lk', isset($sluzbenik) ? $sluzbenik->mjesto_izdavanja_lk : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'mjesto_izdavanja_lk', 'autocomplete' => 'off', 'onkeyup' => 'verifikuj_string("mjesto_izdavanja_lk", "Mjesto izdavalja lične karte ne smije sadržavati brojeve !", "ima_li_brojeva")']) !!}
            </div>
        </div>
    </div>

    <div class="notificaiton_area" id="mjesto_izdavanja_lk_not"> <p id="mjesto_izdavanja_lk_not_v"></p> </div> <!-- obavijest za mjesto_izdavanja_lk -->

    <div class="form-group row">
        <div class="col">
            {!! Form::label('PIO', __('PIO').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('PIO', isset($sluzbenik) ? $sluzbenik->PIO : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'PIO', 'autocomplete' => 'off']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('trenutno_radi', __('Trenutno zaposlen').' : ', ['class' => ' control-label'] )  !!}
            <div class="col-lg-12">
                {!!  Form::select('trenutno_radi', ['1' => 'Zaposlen', '0' => 'Dobio otkaz'], isset($sluzbenik) ? $sluzbenik->trenutno_radi : '' ,['class' => 'form-control', 'id' => 'trenutno_radi']) !!}
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col">
            <!-------------------------------------------------------------------------------------------------
                    ako koristimo formu za unos, u requestu nije ništa proslijeđeno te će parametar funkcije
                    biti null vrijednost. Međutim, ako hoćemo da uredimo tog istog korisnika, kao parametar
                    proslijedimo true , što implicira da mijenjamo url odnosno da ne spašavamo već uređujemo
                    korisnika !!!
            --------------------------------------------------------------------------------------------------->
            @php if(isset($sluzbenik)){$uređujemo = true;} else{$uređujemo = false;} @endphp

            <div class="col-lg-12" onclick="spremi_sluzbenika('{{$uređujemo}}');">
                {!! Form::submit(__('Spasite službenika'), ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    </div>
</div>
</div>