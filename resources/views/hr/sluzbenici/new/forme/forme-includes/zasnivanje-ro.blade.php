<form method="POST" @if(isset($edit))  action="{{route('drzavni-sluzbenici.zasnivanje-ro.azuriraj')}}" @else action="{{ route('drzavni-sluzbenici.zasnivanje-ro.spremi') }}" @endif>
    @csrf

    @if(isset($edit))
        {!! Form::hidden('id', $radni_odnos->id ?? '', ['class' => 'form-control']) !!}
    @endif
    {!! Form::hidden('id_sluzbenika', $sluzbenik->id ?? '', ['class' => 'form-control']) !!}

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="vrsta_r_o">Vrsta radnog odnosa</label>
                {!! Form::select('vrsta_r_o', $vrsta_ro, $radni_odnos->vrsta_r_o ?? '', ['class' => 'form-control', 'id' => 'vrsta_r_o', 'required' => 'required', isset($preview) ? 'disabled => true' : '']) !!}
                @if(!isset($preview))
                    <small id="vrsta_r_o" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="nacin_zasnivanja_r_o">Način zasnivanja radnog odnosa</label>
                {!! Form::select('nacin_zasnivanja_r_o', $nacin_zas, $radni_odnos->nacin_zasnivanja_r_o ?? '', ['class' => 'form-control', 'required' => 'required', 'id' => 'nacin_zasnivanja_r_o', isset($preview) ? 'disabled => true' : '']) !!}
                @if(!isset($preview))
                    <small id="nacin_zasnivanja_r_o" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="datum_zasnivanja_o">Datum zasnivanja radnog odnosa</label>
                {!! Form::text('datum_zasnivanja_o', isset($radni_odnos) ? $radni_odnos->datumZasnivanjaRO() : '', ['class' => 'form-control datepicker-2', 'id' => 'datum_zasnivanja_o', 'required' => 'required', isset($preview) ? 'readonly' : '']) !!}
                @if(!isset($preview))
                    <small id="nacin_zasnivanja_r_o" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="datum_prestanka_ro">Datum prestanka radnog odnosa</label>
                {!! Form::text('datum_prestanka_ro', isset($radni_odnos) ? $radni_odnos->datumPrestankaRO() : '', ['class' => 'form-control datepicker-2', 'id' => 'datum_prestanka_ro', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="steceno_radno_iskustvo">Stečeno radno iskustvo</label>
                {!! Form::text('steceno_radno_iskustvo', $radni_odnos->steceno_radno_iskustvo ?? '', ['class' => 'form-control', 'id' => 'steceno_radno_iskustvo', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="radno_vrijeme">Radno vrijeme</label>
                {!! Form::select('radno_vrijeme', $radno_vr, isset($radni_odnos) ? $radni_odnos->radno_vrijeme ?? '' : '', ['class' => 'form-control', 'id' => 'radno_vrijeme', isset($preview) ? 'disabled => true' : '']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="koeficijent">Koeficijent</label>
                {!! Form::number('koeficijent', $radni_odnos->koeficijent ?? '', ['class' => 'form-control', 'id' => 'koeficijent ', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="datum_donosenja_dokumentacije">Datum donošenja potrebne dokumentacije</label>
                {!! Form::text('datum_donosenja_dokumentacije', isset($radni_odnos) ? $radni_odnos->datumDonosenjaDokumentacije() : '', ['class' => 'form-control datepicker-2', 'id' => 'datum_donosenja_dokumentacije', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
    </div>

    @if(isset($preview))
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="ors">Obračunati radni staž</label>
                    {!! Form::text('ors', ($radni_odnos->obracunati_r_s_god ?? '').' god '.($radni_odnos->obracunati_r_s_mje ?? '').' mj i '.($radni_odnos->obracunati_r_s_dan ?? '').' dana', ['class' => 'form-control', 'id' => 'ors ', isset($preview) ? 'readonly' : '']) !!}
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="napomena">Napomena</label>
                {!! Form::textarea('napomena', $radni_odnos->napomena ?? '', ['class' => 'form-control', 'id' => 'napomena', isset($preview) ? 'readonly' : '', 'style' => 'height:120px;']) !!}
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
