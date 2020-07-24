<form method="POST" @if(isset($edit))  action="{{route('drzavni-sluzbenici.prestanak-ro.azuriraj')}}" @else action="{{ route('drzavni-sluzbenici.prestanak-ro.spremi') }}" @endif>
    @csrf

    @if(isset($edit))
        {!! Form::hidden('id', $prestanak->id ?? '', ['class' => 'form-control']) !!}
    @endif
    {!! Form::hidden('id_sluzbenika', $sluzbenik->id ?? '', ['class' => 'form-control']) !!}

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="osnov_za_prestanak">Osnov za prestanak</label>
                {!! Form::select('osnov_za_prestanak', $osnov, $prestanak->osnov_za_prestanak ?? '', ['class' => 'form-control', 'id' => 'osnov_za_prestanak', 'required' => 'required', isset($preview) ? 'disabled => true' : '']) !!}
                @if(!isset($preview))
                    <small id="osnov_za_prestanak" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="datum_prestanka">Datum prestanka</label>
                {!! Form::text('datum_prestanka', isset($prestanak) ? $prestanak->datumPrestanka() ?? '' : '', ['class' => 'form-control datepicker-2', 'id' => 'datum_prestanka', 'required' => 'required', isset($preview) ? 'readonly' : '']) !!}
                @if(!isset($preview))
                    <small id="datum_prestanka" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="napomena">Napomena</label>
                {!! Form::textarea('napomena', $prestanak->napomena ?? '', ['class' => 'form-control', 'id' => 'napomena', isset($preview) ? 'readonly' : '', 'style' => 'height:120px;']) !!}
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
