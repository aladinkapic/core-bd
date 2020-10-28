<form method="POST" @if(isset($edit))  action="{{route('drzavni-sluzbenici.prethodni-rs.azuriraj')}}" @else action="{{ route('drzavni-sluzbenici.prethodni-rs.spremi') }}" @endif>
    @csrf

    @if(isset($edit))
        {!! Form::hidden('id', $prethodni->id ?? '', ['class' => 'form-control']) !!}
    @endif
    {!! Form::hidden('id_sluzbenika', $sluzbenik->id ?? '', ['class' => 'form-control']) !!}

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="poslodavac">Poslodavac</label>
                {!! Form::select('poslodavac', $poslodavac, $prethodni->poslodavac ?? '', ['class' => 'form-control', 'id' => 'poslodavac', 'required' => 'required', isset($preview) ? 'disabled => true' : '']) !!}
                @if(!isset($preview))
                    <small id="poslodavac" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="sjediste_poslodavca">Sjedište poslodavca</label>
                {!! Form::text('sjediste_poslodavca', $prethodni->sjediste_poslodavca ?? '', ['class' => 'form-control', 'id' => 'sjediste_poslodavca', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="period_zaposlenja_od">Datum početka rada</label>
                {!! Form::text('period_zaposlenja_od', isset($prethodni) ? $prethodni->datumPocetka() : '', ['class' => 'form-control datepicker-2', 'id' => 'period_zaposlenja_od', 'required' => 'required', isset($preview) ? 'readonly' : '']) !!}
                @if(!isset($preview))
                    <small id="period_zaposlenja_od" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="period_zaposlenja_do">Datum završetka rada</label>
                {!! Form::text('period_zaposlenja_do', isset($prethodni) ? $prethodni->datumZavrsetka() : '', ['class' => 'form-control datepicker-2', 'id' => 'period_zaposlenja_do', 'required' => 'required', isset($preview) ? 'readonly' : '']) !!}
                @if(!isset($preview))
                    <small id="period_zaposlenja_do" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="radno_vrijeme">Radno vrijeme</label>
                {!! Form::select('radno_vrijeme', $radno_vr, $prethodni->radno_vrijeme ?? '', ['class' => 'form-control', 'id' => 'radno_vrijeme', isset($preview) ? 'disabled => true' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="vrsta_staza">Vrsta staža</label>
                {!! Form::select('vrsta_staza', $vrsta_staza, $prethodni->vrsta_staza ?? '', ['class' => 'form-control', 'id' => 'vrsta_staza', 'required' => 'required', isset($preview) ? 'disabled => true' : '']) !!}
                @if(!isset($preview))
                    <small id="vrsta_staza" class="form-text text-muted">Obavezno polje</small>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="koeficijent">Koeficijent</label>
                {!! Form::number('koeficijent', $prethodni->koeficijent ?? '100', ['class' => 'form-control', 'id' => 'koeficijent', isset($preview) ? 'readonly' : '', 'min' => 0, 'max' => 100]) !!}
                <small id="koeficijent" class="form-text text-muted">Vrijednost koeficijenta za 8h rada je 100, dok je za 4h 50</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="staz_sa_uvecanim_trajanjem">Staž sa uvećanim trajanjem</label>
                {!! Form::select('staz_sa_uvecanim_trajanjem', $staz, $prethodni->staz_sa_uvecanim_trajanjem ?? '', ['class' => 'form-control', 'id' => 'staz_sa_uvecanim_trajanjem', isset($preview) ? 'disabled => true' : '']) !!}
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
