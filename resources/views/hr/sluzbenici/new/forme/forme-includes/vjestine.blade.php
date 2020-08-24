<form method="POST" @if(isset($edit))  action="{{route('drzavni-sluzbenici.vjestine.azuriraj')}}" @else action="{{ route('drzavni-sluzbenici.vjestine.spremi') }}" @endif>
    @csrf

    @if(isset($edit))
        {!! Form::hidden('id', $vjestina->id ?? '', ['class' => 'form-control']) !!}
    @endif
    {!! Form::hidden('id_sluzbenika', $sluzbenik->id ?? '', ['class' => 'form-control']) !!}

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="vrsta_vjestine">Vrsta vještine</label>
                {!! Form::select('vrsta_vjestine', $vrsta_vje, $vjestina->vrsta_vjestine ?? '', ['class' => 'form-control', 'id' => 'vrsta_vjestine', 'required' => 'required', isset($preview) ? 'disabled => true' : '']) !!}
                @if(!isset($preview))
                    <small id="vrsta_vjestine" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="nivo_vjestine">Nivo vještine</label>
                {!! Form::select('nivo_vjestine', $nivo_vje, $vjestina->nivo_vjestine ?? '', ['class' => 'form-control', 'id' => 'nivo_vjestine', isset($preview) ? 'disabled => true' : '']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="institucija">Institucija</label>
                {!! Form::text('institucija', $vjestina->institucija ?? '', ['class' => 'form-control', 'id' => 'institucija', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="broj_uvjerenja">Broj uvjerenja</label>
                {!! Form::text('broj_uvjerenja', $vjestina->broj_uvjerenja ?? '', ['class' => 'form-control', 'id' => 'broj_uvjerenja', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="datum_uvjerenja">Datum uvjerenja</label>
                {!! Form::text('datum_uvjerenja', isset($vjestina) ? $vjestina->datumUvjerenja() ?? '' : '', ['class' => 'form-control datepicker-2', 'id' => 'datum_uvjerenja', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="komentar">Komentar</label>
                {!! Form::text('komentar', $vjestina->komentar ?? '', ['class' => 'form-control', 'id' => 'komentar', isset($preview) ? 'readonly' : '']) !!}
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
