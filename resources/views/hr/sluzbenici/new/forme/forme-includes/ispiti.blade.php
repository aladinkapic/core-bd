<form method="POST" @if(isset($edit))  action="{{route('drzavni-sluzbenici.ispit.azuriraj')}}" @else action="{{ route('drzavni-sluzbenici.ispit.spremi') }}" @endif>
    @csrf

    @if(isset($edit))
        {!! Form::hidden('id', $ispit->id ?? '', ['class' => 'form-control']) !!}
    @endif
    {!! Form::hidden('id_sluzbenika', $sluzbenik->id ?? '', ['class' => 'form-control']) !!}

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="kategorija_ispita">Kategorija ispita</label>
                {!! Form::select('kategorija_ispita', $ispit_k, $ispit->kategorija_ispita ?? '', ['class' => 'form-control', 'id' => 'kategorija_ispita', 'required' => 'required', isset($preview) ? 'disabled => true' : '']) !!}
                @if(!isset($preview))
                    <small id="kategorija_ispita" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="prezime">Broj uvjerenja</label>
                {!! Form::text('broj_uvjerenja', $ispit->broj_uvjerenja ?? '', ['class' => 'form-control', 'id' => 'broj_uvjerenja', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="nostrifikacija">Nostrifikacija</label>
                {!! Form::text('nostrifikacija', $ispit->nostrifikacija ?? '', ['class' => 'form-control', 'id' => 'nostrifikacija', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="datum_polaganja">Datum polaganja</label>
                {!! Form::text('datum_polaganja', isset($ispit) ? $ispit->datumPolaganja() ?? '' : '', ['class' => 'form-control datepicker-2', 'id' => 'datum_polaganja', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="napomena">Napomena</label>
                {!! Form::textarea('napomena', $ispit->napomena ?? '', ['class' => 'form-control', 'id' => 'napomena', isset($preview) ? 'readonly' : '', 'style' => 'height:120px;']) !!}
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
