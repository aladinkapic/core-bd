<form method="POST" @if(isset($edit))  action="{{route('drzavni-sluzbenici.strucna-sprema.azuriraj')}}" @else action="{{ route('drzavni-sluzbenici.strucna-sprema.spremi') }}" @endif>
    @csrf

    @if(isset($edit))
        {!! Form::hidden('id', $strucna_sprema->id ?? '', ['class' => 'form-control']) !!}
    @endif
    {!! Form::hidden('id_sluzbenika', $sluzbenik->id ?? '', ['class' => 'form-control']) !!}

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="stepen_s_s">Stepen stručne spreme</label>
                {!! Form::select('stepen_s_s', $stepen_ss, $strucna_sprema->stepen_s_s ?? '', ['class' => 'form-control'.((!isset($preview)) ? ' select-2' : '') , 'id' => 'stepen_s_s', 'required' => 'required', isset($preview) ? 'disabled => true' : '']) !!}
                @if(!isset($preview))
                    <small id="stepen_s_s" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="vrsta_s_s">Stručno zvanje</label>
                {!! Form::text('vrsta_s_s', $strucna_sprema->vrsta_s_s ?? '', ['class' => 'form-control', 'id' => 'vrsta_s_s', 'required' => 'required', isset($preview) ? 'readonly' : '']) !!}
                @if(!isset($preview))
                    <small id="vrsta_s_s" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="komenta_o_diplomi">Komentar o diplomi</label>
                {!! Form::text('komenta_o_diplomi', $strucna_sprema->komenta_o_diplomi ?? '', ['class' => 'form-control', 'id' => 'komenta_o_diplomi', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="datum_zavrsetka">Datum završetka</label>
                {!! Form::text('datum_zavrsetka', isset($strucna_sprema) ? $strucna_sprema->datumZavrsetka() ?? '' : '', ['class' => 'form-control datepicker-2', 'id' => 'datum_zavrsetka', 'required' => 'required', isset($preview) ? 'readonly' : '']) !!}

                @if(!isset($preview))
                    <small id="datum_zavrsetka" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="obrazovna_institucija">Obrazovna institucija</label>
                {!! Form::select('obrazovna_institucija', $ob_inst, $strucna_sprema->obrazovna_institucija ?? '', ['class' => 'form-control'.((!isset($preview)) ? ' select-2' : ''), 'id' => 'obrazovna_institucija', 'required' => 'required', isset($preview) ? 'disabled => true' : '']) !!}
                @if(!isset($preview))
                    <small id="obrazovna_institucija" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="nostrifikacija">Broj nostrifikacije</label>
                {!! Form::text('nostrifikacija', $strucna_sprema->nostrifikacija ?? '', ['class' => 'form-control', 'id' => 'nostrifikacija', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="diploma_poslana_na_provjeru">Diploma poslana na provjeru</label>
                {!! Form::select('diploma_poslana_na_provjeru', $da_ne, $strucna_sprema->diploma_poslana_na_provjeru ?? '', ['class' => 'form-control', 'id' => 'diploma_poslana_na_provjeru', isset($preview) ? 'disabled => true' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="diploma_vracena_sa_provjere">Diploma vraćena sa provjere</label>
                {!! Form::select('diploma_vracena_sa_provjere', $da_ne, $strucna_sprema->diploma_vracena_sa_provjere ?? '', ['class' => 'form-control', 'id' => 'diploma_vracena_sa_provjere', isset($preview) ? 'disabled => true' : '']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="broj_obavijestenja_provjere">Broj obavještenja</label>
                {!! Form::text('broj_obavijestenja_provjere', $strucna_sprema->broj_obavijestenja_provjere ?? '', ['class' => 'form-control', 'id' => 'broj_obavijestenja_provjere', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="datum_dostavljanja_diplome">Datum dostavljanja diplome u toku radnog odnosa</label>
                {!! Form::text('datum_dostavljanja_diplome', isset($strucna_sprema) ? $strucna_sprema->datumDostavljanja() ?? '' : '', ['class' => 'form-control datepicker-2', 'id' => 'datum_dostavljanja_diplome', isset($preview) ? 'readonly' : '']) !!}
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
