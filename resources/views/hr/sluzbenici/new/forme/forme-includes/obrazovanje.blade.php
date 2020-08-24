<form method="POST" @if(isset($edit))  action="{{route('drzavni-sluzbenici.obrazovanje.azuriraj')}}" @else action="{{ route('drzavni-sluzbenici.obrazovanje.spremi') }}" @endif>
    @csrf

    @if(isset($edit))
        {!! Form::hidden('id', $obrazovanje->id ?? '', ['class' => 'form-control']) !!}
    @endif
    {!! Form::hidden('id_sluzbenika', $sluzbenik->id ?? '', ['class' => 'form-control']) !!}

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="naziv_ustanove">Naziv ustanove</label>
                {!! Form::select('naziv_ustanove', $ustanova, $obrazovanje->naziv_ustanove ?? '', ['class' => 'form-control'.((!isset($preview)) ? ' select-2' : ''), 'id' => 'naziv_ustanove', 'required' => 'required', isset($preview) ? 'disabled => true' : '']) !!}
                @if(!isset($preview))
                    <small id="naziv_ustanove" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="sjediste_ustanove">Sjedište ustanove</label>
                {!! Form::text('sjediste_ustanove', $obrazovanje->sjediste_ustanove ?? '', ['class' => 'form-control', 'id' => 'sjediste_ustanove', 'required' => 'required', isset($preview) ? 'readonly' : '']) !!}
                @if(!isset($preview))
                    <small id="sjediste_ustanove" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="broj_diplome">Broj diplome</label>
                {!! Form::text('broj_diplome', $obrazovanje->broj_diplome ?? '', ['class' => 'form-control', 'id' => 'broj_diplome', 'required' => 'required', isset($preview) ? 'readonly' : '']) !!}
                @if(!isset($preview))
                    <small id="broj_diplome" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="vrsta_obrazovanja">Vrsta obrazovanja</label>
                {!! Form::text('vrsta_obrazovanja', $obrazovanje->vrsta_obrazovanja ?? '', ['class' => 'form-control', 'id' => 'vrsta_obrazovanja', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="datum_izdavanja_dipl">Datum izdavanja diplome</label>
                {!! Form::text('datum_izdavanja_dipl', isset($obrazovanje) ? $obrazovanje->datumIzdavanjaDiplome() ?? '' : '', ['class' => 'form-control datepicker-2', 'id' => 'datum_izdavanja_dipl', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="datum_diplomiranja">Datum diplomiranja</label>
                {!! Form::text('datum_diplomiranja', isset($obrazovanje) ? $obrazovanje->datumDiplomiranja() ?? '' : '', ['class' => 'form-control datepicker-2', 'id' => 'datum_diplomiranja', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="ciklus_obrazovanja">Ciklus obrazovanja</label>
                {!! Form::select('ciklus_obrazovanja', $ciklus, $obrazovanje->ciklus_obrazovanja ?? '', ['class' => 'form-control', 'id' => 'ciklus_obrazovanja', 'required' => 'required', isset($preview) ? 'disabled => true' : '']) !!}
                @if(!isset($preview))
                    <small id="broj_diplome" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="strucno_zvanje">Stručno zvanje</label>
                {!! Form::text('strucno_zvanje', $obrazovanje->strucno_zvanje ?? '', ['class' => 'form-control', 'id' => 'strucno_zvanje', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="odsjek">Odsjek</label>
                {!! Form::text('odsjek', $obrazovanje->odsjek ?? '', ['class' => 'form-control', 'id' => 'odsjek', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="rjesenje_izdato_od">Rješenje izdato od</label>
                {!! Form::text('rjesenje_izdato_od', $obrazovanje->rjesenje_izdato_od ?? '', ['class' => 'form-control', 'id' => 'rjesenje_izdato_od', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="broj_nostrifikacije">Broj nostrifikacije</label>
                {!! Form::text('broj_nostrifikacije', $obrazovanje->broj_nostrifikacije ?? '', ['class' => 'form-control', 'id' => 'broj_nostrifikacije', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="datum_nostrifikacije">Datum nostrifikacije</label>
                {!! Form::text('datum_nostrifikacije', isset($obrazovanje) ? $obrazovanje->datumNostrifikacije() ?? '' : '', ['class' => 'form-control datepicker-2', 'id' => 'datum_nostrifikacije', isset($preview) ? 'readonly' : '']) !!}
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
