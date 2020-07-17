<form method="POST" @if(isset($edit))  action="{{route('drzavni-sluzbenici.prebivaliste.azuriraj')}}" @else action="{{ route('drzavni-sluzbenici.prebivaliste.spremi') }}" @endif>
    @csrf

    @if(isset($edit))
        {!! Form::hidden('id', $prebivaliste->id ?? '', ['class' => 'form-control']) !!}
    @endif
    {!! Form::hidden('id_sluzbenika', $sluzbenik->id ?? '', ['class' => 'form-control']) !!}

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="mjesto_prebivalista">Mjesto prebivališta</label>
                {!! Form::text('mjesto_prebivalista', $prebivaliste->mjesto_prebivalista ?? '', ['class' => 'form-control', 'id' => 'mjesto_prebivalista', 'required' => 'required', isset($preview) ? 'readonly' : '']) !!}
                @if(!isset($preview))
                    <small id="mjesto_prebivalista" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="prezime">Adresa prebivališta</label>
                {!! Form::text('adresa_prebivalista', $prebivaliste->adresa_prebivalista ?? '', ['class' => 'form-control', 'id' => 'adresa_prebivalista', 'required' => 'required', isset($preview) ? 'readonly' : '']) !!}
                @if(!isset($preview))
                    <small id="adresa_prebivalista" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="adresa_boravista">Adresa boravišta</label>
                {!! Form::text('adresa_boravista', $prebivaliste->adresa_boravista ?? '', ['class' => 'form-control', 'id' => 'adresa_boravista', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="datum_do">Datum od</label>
                {!! Form::text('datum_do', isset($prebivaliste) ? $prebivaliste->datumDo() ?? '' : '', ['class' => 'form-control datepicker-2', 'id' => 'datum_do', isset($preview) ? 'readonly' : '']) !!}
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
