<div class="split_container">
    <div class="form-group row">
    {!! Form::hidden('id_sluzbenika', isset($sluzbenik) ? $sluzbenik->id : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'id_sluzbenika']) !!}

    <!-- Ime -->
        <div class="col">
            {!! Form::label('ime', __('Ime').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('ime', isset($sluzbenik) ? $sluzbenik->ime : '', ['class' => 'form-control required', 'rows' => 1, 'id' => 'ime', 'onkeyup' => 'kreirajKorisnickoIme(), verifikuj_string("ime", "Ime službenika ne smije sadržavati brojeve !", "ima_li_brojeva")', 'autocomplete' => 'off', 'maxlength' => 50]) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('prezime', __('Prezime').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('prezime', isset($sluzbenik) ? $sluzbenik->prezime : '', ['class' => 'form-control required', 'rows' => 1, 'id' => 'prezime', 'onkeyup' => 'kreirajKorisnickoIme(), verifikuj_string("prezime", "Prezime službenika ne smije sadržavati brojeve !", "ima_li_brojeva")', 'autocomplete' => 'off', 'maxlength' => 100]) !!}
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
        @if(isset($unos))
            <div class="col">
                {!! Form::label('email', __('Email').' : ', ['class' => 'control-label']) !!}
                <div class="col-lg-12">
                    {!! Form::select('email', $domena, '0', ['class' => 'form-control', 'rows' => 1, 'id' => 'email', 'autocomplete' => 'off', 'maxlength' => 50]) !!}
                </div>
            </div>
        @else
            <div class="col">
                {!! Form::label('email', __('Email').' : ', ['class' => 'control-label']) !!}
                <div class="col-lg-12">
                    {!! Form::text('email', isset($sluzbenik) ? $sluzbenik->email : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'email', 'autocomplete' => 'off', 'onkeyup' => 'verifikuj_string("email", "Uneseni podaci nemaju formu maila. Jeste li zaboravili -@- ?", "email")', 'maxlength' => 50]) !!}
                </div>
            </div>
        @endif

    </div>

    <div class="notificaiton_area" id="email_not"> <p id="email_not_v"></p> </div> <!-- obavijest za prezime -->

    <div class="form-group row">
        <div class="col">
            {!! Form::label('jmbg', __('JMBG').' : ', ['class' => ' control-label']) !!}
            <div class="col-lg-12">
                {!! Form::number('jmbg', isset($sluzbenik) ? $sluzbenik->jmbg : '', ['class' => 'form-control required', 'rows' => 1, 'id' => 'jmbg', 'onkeyup' => 'provjeriPodatke(this, "jmbg", "jmbg"), verifikuj_string("jmbg", "JMBG treba da sadržava tačno 13 karaktera (brojeva).", "jmbg")', 'autocomplete' => 'off', 'min' => 0, 'maxlength' => 13]) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('ime_roditelja', __('Ime roditelja').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('ime_roditelja', isset($sluzbenik) ? $sluzbenik->ime_roditelja : '', ['class' => 'form-control required', 'rows' => 1, 'id' => 'ime_roditelja', 'autocomplete' => 'off', 'maxlength' => 50]) !!}
            </div>
        </div>
    </div>

    <div class="notificaiton_area" id="jmbg_not"> <p id="jmbg_not_v"></p> </div> <!-- DA li je forma email-a ? -->

    <div class="form-group row">
        <div class="col">
            {!! Form::label('pol', __('Spol').': ', ['class' => ' control-label'] )  !!}

            <div class="col-lg-12">
                {!!  Form::select('pol', $spol, isset($sluzbenik) ? $sluzbenik->pol : '' ,['class' => 'form-control', 'onchange' => 'djevojacko_prezime(this)', 'id' => 'pol']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('kategorija', __('Kategorija').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!!  Form::select('kategorija', $kategorija, isset($sluzbenik) ? $sluzbenik->kategorija : '' ,['class' => 'form-control',  'id' => 'kategorija']) !!}
            </div>
        </div>
    </div>

    <div class="notificaiton_area" id="jmbg_not"> <p id="jmbg_not_v"></p> </div> <!-- Da  -->

    <div class="form-group row">
        <div class="col djevojacko_prezime_input">
            {!! Form::label('djevojacko_prezime', __('Djevojačko prezime').' : ', ['class' => 'control-label djevojacko_prezime hidden']) !!}
            <div class="col-lg-12">
                {!! Form::text('djevojacko_prezime', isset($sluzbenik) ? $sluzbenik->djevojacko_prezime : '', ['class' => 'form-control hidden', 'id' => 'djevojacko_prezime', 'onkeyup' => 'verifikuj_string("djevojacko_prezime", "Djevojačko prezime ne smije sadržavati brojeve !", "ima_li_brojeva")', 'maxlength' => 50]) !!}
            </div>
        </div>
    </div>

    <div class="notificaiton_area" id="djevojacko_prezime_not"> <p id="djevojacko_prezime_not_v"></p> </div> <!-- obavijest za djevojacko_prezime -->

    <div class="form-group row">
        <div class="col">
            {!! Form::label('drzavljanstvo_1', __('Državljanstvo 1').' : ', ['class' => ' control-label'] )  !!}
            <div class="col-lg-12">
                {!! Form::select('drzavljanstvo_1', $drzava, isset($sluzbenik) ? $sluzbenik->drzavljanstvo_1 : '', ['class' => 'form-control required', 'rows' => 1, 'id' => 'drzavljanstvo_1', 'autocomplete' => 'off']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('drzavljanstvo_2', __('Državljanstvo 2').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::select('drzavljanstvo_2', $drzava, isset($sluzbenik) ? $sluzbenik->drzavljanstvo_2 : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'drzavljanstvo_2', 'autocomplete' => 'off']) !!}
            </div>
        </div>
    </div>

    <div class="notificaiton_area" id="drzavljanstvo_1_not"> <p id="drzavljanstvo_1_not_v"></p> </div> <!-- obavijest za drzavljanstvo_1 -->
    <div class="notificaiton_area" id="drzavljanstvo_2_not"> <p id="drzavljanstvo_2_not_v"></p> </div> <!-- obavijest za drzavljanstvo_2 -->

    <div class="form-group row">
        <div class="col">
            {!! Form::label('nacionalnost', __('Nacionalnost').' : ', ['class' => ' control-label'] )  !!}
            <div class="col-lg-12">
                {!!  Form::select('nacionalnost', $nacionalnost, isset($sluzbenik) ? $sluzbenik->nacionalnost : '' ,['class' => 'form-control', 'id' => 'nacionalnost']) !!}
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col">
            {!! Form::label('bracni_status', __('Bračni status').' : ', ['class' => ' control-label'] )  !!}
            <div class="col-lg-12">
                {!!  Form::select('bracni_status', $bracni_status, isset($sluzbenik) ? $sluzbenik->bracni_status : '' ,['class' => 'form-control', 'id' => 'bracni_status']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('mjesto_rodjenja', __('Mjesto rođenja').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('mjesto_rodjenja', isset($sluzbenik) ? $sluzbenik->mjesto_rodjenja : '', ['class' => 'form-control required', 'rows' => 1, 'id' => 'mjesto_rodjenja', 'autocomplete' => 'off', 'onkeyup' => 'verifikuj_string("mjesto_rodjenja", "Mjesto rođenja ne smije sadržavati brojeve !", "ima_li_brojeva")', 'maxlength' => 100]) !!}
            </div>
        </div>
    </div>

    <div class="notificaiton_area" id="mjesto_rodjenja_not"> <p id="mjesto_rodjenja_not_v"></p> </div> <!-- obavijest za mjesto_rodjenja -->

    <div class="form-group row">
        <div class="col">
            {!! Form::label('usrl', __('Datum rođenja').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('datum_rođenja', isset($sluzbenik) ? \App\Http\Controllers\HelpController::obrniDatum($sluzbenik->datum_rodjenja) : '' , ['class' => 'form-control datepicker required', 'id' => 'usr1']) !!}
            </div>
        </div>
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
                {!! Form::text('licna_karta', isset($sluzbenik) ? $sluzbenik->licna_karta : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'licna_karta', 'onkeyup' => 'provjeriPodatke(this, "licna_karta", "licna_karta")', 'autocomplete' => 'off', 'maxlength' => 12]) !!}
            </div>
        </div>

        <div class="col">
            {!! Form::label('mjesto_izdavanja_lk', __('Mjesto izdavanja LK').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('mjesto_izdavanja_lk', isset($sluzbenik) ? $sluzbenik->mjesto_izdavanja_lk : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'mjesto_izdavanja_lk', 'autocomplete' => 'off', 'onkeyup' => 'verifikuj_string("mjesto_izdavanja_lk", "Mjesto izdavalja lične karte ne smije sadržavati brojeve !", "ima_li_brojeva")', 'maxlength' => 50]) !!}
            </div>
        </div>
    </div>

    <div class="notificaiton_area" id="mjesto_izdavanja_lk_not"> <p id="mjesto_izdavanja_lk_not_v"></p> </div> <!-- obavijest za mjesto_izdavanja_lk -->

    <div class="form-group row">
        <div class="col">
            {!! Form::label('PIO', __('Poreska uprava').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::select('PIO', $pio, isset($sluzbenik) ? $sluzbenik->PIO : '', ['class' => 'form-control required', 'rows' => 1, 'id' => 'PIO', 'autocomplete' => 'off', 'maxlength' => 50]) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('trenutno_radi', __('Trenutno zaposlen').' : ', ['class' => ' control-label'] )  !!}
            <div class="col-lg-12">
                {!!  Form::select('trenutno_radi', $trenutno_radi, isset($sluzbenik) ? $sluzbenik->trenutno_radi : '' ,['class' => 'form-control required', 'id' => 'trenutno_radi']) !!}
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

            @if(isset($sluzbenik))
                <div class="col-lg-12" onclick="spremi_sluzbenika('{{$uređujemo}}');">
                    {!! Form::submit(__('Sačuvajte izmjene'), ['class' => 'btn btn-primary']) !!}
                </div>
            @else
                <div class="col-lg-12" onclick="spremi_sluzbenika('{{$uređujemo}}');">
                    {!! Form::submit(__('Nastavite sa unosom'), ['class' => 'btn btn-primary']) !!}
                </div>
            @endif
        </div>
    </div>
</div>
</div>