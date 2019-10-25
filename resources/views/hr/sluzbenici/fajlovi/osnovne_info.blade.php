<div class="split_container split_container2">
    <div class="form-group row">
        <div class="col">
            {!! Form::label('ime', __('Ime').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('ime', isset($sluzbenik) ? $sluzbenik->ime : '', ['class' => 'form-control', 'id' => 'ime', 'readonly']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('prezime', __('Prezime').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('prezime', isset($sluzbenik) ? $sluzbenik->prezime : '', ['class' => 'form-control', 'id' => 'prezime', 'readonly']) !!}
            </div>
        </div>
    </div>
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
                {!! Form::text('email', isset($sluzbenik) ? $sluzbenik->email : '', ['class' => 'form-control', 'id' => 'email', 'readonly']) !!}
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col">
            {!! Form::label('jmbg', __('JMBG').' : ', ['class' => ' control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('jmbg', isset($sluzbenik) ? $sluzbenik->jmbg : '', ['class' => 'form-control', 'id' => 'jmbg', 'readonly']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('ime_roditelja', __('Ime roditelja').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('ime_roditelja', isset($sluzbenik) ? $sluzbenik->ime_roditelja : '', ['class' => 'form-control', 'id' => 'ime_roditelja', 'readonly']) !!}
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col">
            {!! Form::label('pol', __('Spol').': ', ['class' => ' control-label'] )  !!}

            <div class="col-lg-12">
                {!!  Form::select('pol', $spol, isset($sluzbenik) ? $sluzbenik->pol : '' ,['class' => 'form-control', 'id' => 'pol', 'disabled' => 'true']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('kategorija', __('Kategorija').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!!  Form::select('kategorija', $kategorija, isset($sluzbenik) ? $sluzbenik->kategorija : '' ,['class' => 'form-control',  'id' => 'kategorija', 'disabled' => 'true']) !!}
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col djevojacko_prezime_input">
            {!! Form::label('djevojacko_prezime', __('Djevojačko prezime').' : ', ['class' => 'control-label djevojacko_prezime hidden']) !!}
            <div class="col-lg-12">
                {!! Form::text('djevojacko_prezime', isset($sluzbenik) ? $sluzbenik->djevojacko_prezime : '', ['class' => 'form-control hidden', 'id' => 'djevojacko_prezime', 'readonly']) !!}
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col">
            {!! Form::label('drzavljanstvo_1', __('Državljanstvo 1').' : ', ['class' => ' control-label'] )  !!}
            <div class="col-lg-12">
                {!! Form::text('drzavljanstvo_1', isset($sluzbenik) ? $sluzbenik->drzavljanstvo_1 : '', ['class' => 'form-control', 'id' => 'drzavljanstvo_1', 'autocomplete' => 'off', 'readonly']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('drzavljanstvo_2', __('Državljanstvo 2').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('drzavljanstvo_2', isset($sluzbenik) ? $sluzbenik->drzavljanstvo_2 : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'drzavljanstvo_2', 'autocomplete' => 'off' , 'readonly']) !!}
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col">
            {!! Form::label('nacionalnost', __('Nacionalnost').' : ', ['class' => ' control-label'] )  !!}
            <div class="col-lg-12">
                {!!  Form::select('nacionalnost', $nacionalnost, isset($sluzbenik) ? $sluzbenik->nacionalnost : '' ,['class' => 'form-control', 'id' => 'nacionalnost', 'disabled' => 'true']) !!}
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col">
            {!! Form::label('bracni_status', __('Bračni status').' : ', ['class' => ' control-label'] )  !!}
            <div class="col-lg-12">
                {!!  Form::select('bracni_status', $bracni_status, isset($sluzbenik) ? $sluzbenik->bracni_status : '' ,['class' => 'form-control', 'id' => 'bracni_status', 'disabled' => 'true']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('mjesto_rodjenja', __('Mjesto rođenja').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('mjesto_rodjenja', isset($sluzbenik) ? $sluzbenik->mjesto_rodjenja : '', ['class' => 'form-control', 'id' => 'mjesto_rodjenja', 'autocomplete' => 'off', 'readonly']) !!}
            </div>
        </div>
    </div>
    <div class="dates">
        {!! Form::label('usrl', __('Datum rođenja').' : ', ['class' => 'control-label']) !!}
        <input type="text" class="form-control" id="usr1" name="datum_rođenja" value="{{isset($sluzbenik) ? \App\Http\Controllers\HelpController::obrniDatum($sluzbenik->datum_rodjenja) : ''}}" placeholder="" autocomplete="off" readonly> <br>
    </div>
    <div class="form-group row">
        <div class="col">
            {!! Form::label('licna_karta', __('Lična karta').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('licna_karta', isset($sluzbenik) ? $sluzbenik->licna_karta : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'licna_karta', 'onkeyup' => 'provjeriPodatke(this, "licna_karta", "licna_karta")', 'autocomplete' => 'off', 'readonly']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('mjesto_izdavanja_lk', __('Mjesto izdavanja LK').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('mjesto_izdavanja_lk', isset($sluzbenik) ? $sluzbenik->mjesto_izdavanja_lk : '', ['class' => 'form-control', 'id' => 'mjesto_izdavanja_lk', 'autocomplete' => 'off', 'readonly']) !!}
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col">
            {!! Form::label('PIO', __('PIO').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('PIO', isset($sluzbenik) ? $sluzbenik->PIO : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'PIO', 'autocomplete' => 'off', 'readonly']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('trenutno_radi', __('Trenutno zaposlen').' : ', ['class' => ' control-label'] )  !!}
            <div class="col-lg-12">
                {!!  Form::select('trenutno_radi', $trenutno_radi, isset($sluzbenik) ? $sluzbenik->trenutno_radi : '' ,['class' => 'form-control', 'id' => 'trenutno_radi', 'disabled' => 'true']) !!}
            </div>
        </div>
    </div>


    <div class="form-group row">
        <div class="col">
            {!! Form::label('', __('Organ javne uprave').' : ', ['class' => ' control-label'] )  !!}
            <div class="col-lg-12">
                {!! Form::text('organ_ju', isset($organ_ju) ? $organ_ju : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'organ_ju', 'autocomplete' => 'off', 'readonly']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('organizaciona_jedinica', __('Organizaciona jedinica').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('organizaciona_jedinica', isset($organizaciona_jed->naziv) ? $organizaciona_jed->naziv : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'organizaciona_jedinica', 'autocomplete' => 'off', 'readonly']) !!}
            </div>
        </div>
    </div>


    <div class="form-group row">
        <div class="col">
            {!! Form::label('', __('Radno mjesto').' : ', ['class' => ' control-label'] )  !!}
            <div class="col-lg-12">
                {!! Form::text('radno_mjesto', isset($sluzbenik) ? $radno_mjesto : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'radno_mjesto', 'autocomplete' => 'off', 'readonly']) !!}
            </div>
        </div>
        <div class="col">
            {!! Form::label('privremeni_premjestaj', __('Privremeni premještaj').' : ', ['class' => 'control-label']) !!}
            <div class="col-lg-12">
                {!! Form::text('privremeni_premjestaj',  isset($sluzbenik->privremeniPremjestaj) ? $sluzbenik->privremeniPremjestaj->naziv_rm : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'privremeni_premjestaj', 'autocomplete' => 'off', 'readonly']) !!}
                    {{--{!!  Form::select('privremeni_premjestaj', ['1' => 'Premještaj 1', '2' => 'Premještaj 2'], isset($sluzbenik) ? $sluzbenik->privremeni_premjestaj : '' ,['class' => 'form-control', 'id' => 'privremeni_premjestaj', 'disabled' => 'true']) !!}--}}
            </div>
        </div>
    </div>

    @if(isset($pregled))
        <div class="form-group row">
            <div class="col">
                {!! Form::label('', __('Radni staž - godina').' : ', ['class' => ' control-label'] )  !!}
                <div class="col-lg-12">
                    {!! Form::text('radni_staz_godina', $godina .' godina', ['class' => 'form-control', 'rows' => 1, 'id' => 'radni_staz_godina', 'autocomplete' => 'off', 'readonly']) !!}
                </div>
            </div>
            <div class="col">
                {!! Form::label('radni_staz_mjeseci', __('Radni staž - mjeseci').' : ', ['class' => 'control-label']) !!}
                <div class="col-lg-12">
                    {!! Form::text('radni_staz_mjeseci',  $mjeseci. ' mjeseci', ['class' => 'form-control', 'rows' => 1, 'id' => 'radni_staz_mjeseci', 'autocomplete' => 'off', 'readonly']) !!}
                    {{--{!!  Form::select('privremeni_premjestaj', ['1' => 'Premještaj 1', '2' => 'Premještaj 2'], isset($sluzbenik) ? $sluzbenik->privremeni_premjestaj : '' ,['class' => 'form-control', 'id' => 'privremeni_premjestaj', 'disabled' => 'true']) !!}--}}
                </div>
            </div>
        </div>


        <div class="form-group row">
            <div class="col">
                {!! Form::label('', __('Radni staž - dana').' : ', ['class' => ' control-label'] )  !!}
                <div class="col-lg-12">
                    {!! Form::text('radni_staz_dana', $dana .' dana', ['class' => 'form-control', 'rows' => 1, 'id' => 'radni_staz_godina', 'autocomplete' => 'off', 'readonly']) !!}
                </div>
            </div>
        </div>


        <!-- Izrada svih kartona vezanih za službenike -->

        <table class="table-bordered well-dude">
            <thead class="table-my-header">
                <tr>
                    <th class="text-center" width="80px">#</th>
                    <th><p>VRSTA UGOVORA / RJEŠENJA</p></th>
                    <th class="text-center" width="120px">AKCIJE</th>
                </tr>
            </thead>
            <tbody class="table-my-body">
            <tr>
                <td class="text-center">1.</td>
                <td>
                    <a href="">
                        Uvjerenje
                    </a>
                </td>
                <td class="text-center">
                    <a href="{{route('uvjerenje_rm')}}">
                        <button class="my-extra-button">Pregled</button>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="text-center">2.</td>
                <td>
                    <a href="">
                        Rješenje o plaćenom odsustvu
                    </a>
                </td>
                <td class="text-center">
                    <a href="{{route('placeno_odsustvo')}}">
                        <button class="my-extra-button">Pregled</button>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="text-center">3.</td>
                <td>
                    <a href="">
                        Rješenje o korištenju godišnjeg odmora
                    </a>
                </td>
                <td class="text-center">
                    <a href="{{route('godisnji_odmor')}}">
                        <button class="my-extra-button">Pregled</button>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="text-center">4.</td>
                <td>
                    <a href="{{route('rjesenje_plata')}}">
                        Rješenje vezano za platu !?
                    </a>
                </td>
                <td class="text-center">
                    <a href="">
                        <button class="my-extra-button">Pregled</button>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="text-center">5.</td>
                <td>
                    <a href="">
                        Rješenje o prestanku radnog odnosa
                    </a>
                </td>
                <td class="text-center">
                    <a href="{{route('prestanak_ro')}}">
                        <button class="my-extra-button">Pregled</button>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>

    @endif



</div>