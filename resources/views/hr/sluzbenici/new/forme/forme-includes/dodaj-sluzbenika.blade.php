<form method="POST" @if(isset($edit))  action="{{route('drzavni-sluzbenici.azurirajte-sluzbenika')}}" @else action="{{ route('drzavni-sluzbenici.spremi-sluzbenika') }}" @endif>
    @csrf

    @if(isset($edit))
        {!! Form::hidden('id', $sluzbenik->id ?? '', ['class' => 'form-control']) !!}
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="ime">Ime</label>
                {!! Form::text('ime', $sluzbenik->ime ?? '', ['class' => 'form-control', 'id' => 'ime', 'required' => 'required', isset($preview) ? 'readonly' : '']) !!}
                @if(!isset($preview))
                    <small id="ime" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="prezime">Prezime</label>
                {!! Form::text('prezime', $sluzbenik->prezime ?? '', ['class' => 'form-control', 'id' => 'prezime', 'required' => 'required', isset($preview) ? 'readonly' : '']) !!}
                @if(!isset($preview))
                    <small id="ime" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="djevojacko_prezime">Djevojačko prezime</label>
                {!! Form::text('djevojacko_prezime', $sluzbenik->djevojacko_prezime ?? '', ['class' => 'form-control', 'id' => 'djevojacko_prezime', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="ekstenzija">Email</label>
                @if(isset($preview) or isset($edit))
                    {!! Form::text('email', $sluzbenik->email ?? '', ['class' => 'form-control', 'id' => 'ekstenzija', isset($preview) ? 'readonly' : '']) !!}
                @else
                    {!! Form::select('ekstenzija', $domena, $sluzbenik->email ?? '', ['class' => 'form-control', 'id' => 'ekstenzija', isset($preview) ? 'readonly' : '']) !!}
                @endif
                @if(!isset($preview))
                    <small id="ekstenzija" class="form-text text-muted">Obavezno polje. Napomena, email se formira na principu ime.prezime@odabranadomena.com</small>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="broj_telefona">Broj telefona</label>
                {!! Form::text('broj_telefona', $sluzbenik->broj_telefona ?? '', ['class' => 'form-control', 'id' => 'broj_telefona', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="jmbg">JMBG</label>
                {!! Form::number('jmbg', $sluzbenik->jmbg ?? '', ['class' => 'form-control', 'id' => 'jmbg', 'required' => 'required', isset($preview) ? 'readonly' : '']) !!}
                @if(!isset($preview))
                    <small id="ime" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
    </div>

    @if(isset($preview))
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="datum_rodjenja">Datum rođena</label>
                    {!! Form::text('datum_rodjenja', $sluzbenik->datumRodjenja() ?? '', ['class' => 'form-control', 'id' => 'datum_rodjenja', 'readonly']) !!}
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="ime_roditelja">Ime roditelja</label>
                {!! Form::text('ime_roditelja', $sluzbenik->ime_roditelja ?? '', ['class' => 'form-control', 'id' => 'ime_roditelja', 'required' => 'required', isset($preview) ? 'readonly' : '']) !!}
                @if(!isset($preview))
                    <small id="ime" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="pol">Spol</label>
                {!! Form::select('pol', $spol, $sluzbenik->pol ?? '', ['class' => 'form-control', 'id' => 'pol', isset($preview) ? 'disabled => true' : '']) !!}
                @if(!isset($preview))
                    <small id="ime" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="kategorija">Kategorija</label>
                {!! Form::select('kategorija', $kategorija, $sluzbenik->kategorija ?? '', ['class' => 'form-control', 'id' => 'kategorija', isset($preview) ? 'disabled => true' : '']) !!}
                @if(!isset($preview))
                    <small id="ime" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="nacionalnost">Nacionalnost</label>
                {!! Form::select('nacionalnost', $nacionalnost, $sluzbenik->nacionalnost ?? '', ['class' => 'form-control', 'id' => 'nacionalnost', isset($preview) ? 'disabled => true' : '']) !!}
                @if(!isset($preview))
                    <small id="ime" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="drzavljanstvo_1">Državljanstvo prvo</label>
                {!! Form::select('drzavljanstvo_1', $drzava, $sluzbenik->drzavljanstvo_1 ?? '', ['class' => 'form-control', 'id' => 'drzavljanstvo_1', 'required' => 'required', isset($preview) ? 'disabled => true' : '']) !!}
                @if(!isset($preview))
                    <small id="ime" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="drzavljanstvo_2">Državljanstvo drugo</label>
                {!! Form::select('drzavljanstvo_2', $drzava, $sluzbenik->drzavljanstvo_2 ?? '', ['class' => 'form-control', 'id' => 'drzavljanstvo_2', isset($preview) ? 'disabled => true' : '']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="bracni_status">Bračni status</label>
                {!! Form::select('bracni_status', $bracni_status, $sluzbenik->bracni_status ?? '', ['class' => 'form-control', 'id' => 'bracni_status', 'required' => 'required', isset($preview) ? 'disabled => true' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="mjesto_rodjenja">Mjesto rođenja</label>
                {!! Form::text('mjesto_rodjenja', $sluzbenik->mjesto_rodjenja ?? '', ['class' => 'form-control', 'id' => 'mjesto_rodjenja', 'required' => 'required', isset($preview) ? 'readonly' : '']) !!}
                @if(!isset($preview))
                    <small id="ime" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="licna_karta">Broj lične karte</label>
                {!! Form::text('licna_karta', $sluzbenik->licna_karta ?? '', ['class' => 'form-control', 'id' => 'licna_karta', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="mjesto_izdavanja_lk">Mjesto izdavanja lične karte</label>
                {!! Form::text('mjesto_izdavanja_lk', $sluzbenik->mjesto_izdavanja_lk ?? '', ['class' => 'form-control', 'id' => 'mjesto_izdavanja_lk', 'required' => 'required', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="PIO">Poreska uprava</label>
                {!! Form::select('PIO', $pio, $sluzbenik->PIO ?? '', ['class' => 'form-control', 'id' => 'PIO', 'required' => 'required', isset($preview) ? 'disabled => true' : '']) !!}
                @if(!isset($preview))
                    <small id="ime" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="trenutno_radi">Trenutno zaposlen</label>
                {!! Form::select('trenutno_radi', $trenutno_radi, $sluzbenik->trenutno_radi ?? '', ['class' => 'form-control', 'id' => 'trenutno_radi', isset($preview) ? 'disabled => true' : '']) !!}
                @if(!isset($preview))
                    <small id="ime" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
    </div>

    @if(isset($preview))
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="PIO">Obračunati radni staž</label>
                    {!! Form::text('ors', ($sluzbenik->staz_godina ?? '').' god '.($sluzbenik->staz_mjeseci ?? '').' mj i '.($sluzbenik->staz_dana ?? ''). ' dana', ['class' => 'form-control', 'id' => 'ors', 'required' => 'required', 'readonly']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="trenutno_radi">Minuli radni staž</label>
                    {!! Form::text('mrs', ($sluzbenik->mrs_g ?? '').' god '.($sluzbenik->mrs_m ?? '').' mj i '.($sluzbenik->mrs_d ?? ''). ' dana', ['class' => 'form-control', 'id' => 'mrs', 'readonly']) !!}
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="status">Status zaposlenika</label>
                {!! Form::select('status', array('Na službi' => 'Na službi', 'Van službe' => 'Van službe'), $sluzbenik->status ?? '', ['class' => 'form-control', 'id' => 'mrs', isset($preview) ? 'disabled => true' : '']); !!}
            </div>
        </div>
    </div>

    @if(!isset($preview))
        <div class="row">
            <div class="col-md-12 d-flex flex-row-reverse">
                <button class="btn btn-secondary">
                    {{__('Sačuvajte informacije')}}
                </button>
            </div>
        </div>
    @endif
</form>
