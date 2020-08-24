<form method="POST" @if(isset($edit))  action="{{route('drzavni-sluzbenici.clanovi-porodice.azuriraj')}}" @else action="{{ route('drzavni-sluzbenici.clanovi-porodice.spremi') }}" @endif>
    @csrf

    @if(isset($edit))
        {!! Form::hidden('id', $clan_porodice->id ?? '', ['class' => 'form-control']) !!}
    @endif
    {!! Form::hidden('id_sluzbenika', $sluzbenik->id ?? '', ['class' => 'form-control']) !!}

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="srodstvo">Srodstvo</label>
                {!! Form::select('srodstvo', $srodstvo, $clan_porodice->srodstvo ?? '', ['class' => 'form-control', 'id' => 'srodstvo', 'required' => 'required', isset($preview) ? 'disabled => true' : '']) !!}
                @if(!isset($preview))
                    <small id="srodstvo" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="datum_rodjenja">Datum rođenja</label>
                {!! Form::text('datum_rodjenja', isset($clan_porodice) ? $clan_porodice->datumRodjenja() ?? '' : '', ['class' => 'form-control datepicker-2', 'id' => 'datum_rodjenja', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="napomena">Napomena</label>
                {!! Form::textarea('napomena', $clan_porodice->napomena ?? '', ['class' => 'form-control', 'id' => 'napomena', isset($preview) ? 'readonly' : '', 'style' => 'height:120px;']) !!}
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
