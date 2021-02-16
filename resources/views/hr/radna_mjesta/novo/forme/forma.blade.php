<form method="POST" @if(isset($edit))  action="{{route('rm.azuriraj-radno-mjesto')}}" @else action="{{ route('rm.spremi-radno-mjesto') }}" @endif>
    @csrf

    @if(isset($edit))
        {!! Form::hidden('id', $rm->id ?? '', ['class' => 'form-control']) !!}
    @endif

    {!! Form::hidden('organ_id', $organ_id ?? '', ['class' => 'form-control']) !!}

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="naziv_rm">{{__('Naziv radnog mjesta')}}</label>
                {!! Form::text('naziv_rm', $rm->naziv_rm ?? '', ['class' => 'form-control', 'id' => 'naziv_rm', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="opis_rm">{{__('Opis poslova radnog mjesta i odgovornosti')}}</label>
                {!! Form::textarea('opis_rm', $rm->opis_rm ?? '', ['class' => 'form-control', 'id' => 'opis_rm', 'style' => 'height:120px;', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="broj_izvrsilaca">{{__('Broj izvršilaca')}}</label>
                {!! Form::number('broj_izvrsilaca', $rm->broj_izvrsilaca ?? '', ['class' => 'form-control', 'id' => 'broj_izvrsilaca', isset($preview) ? 'readonly' : '', 'min' => 1]) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="platni_razred">{{__('Platni razred')}}</label>
                {!! Form::text('platni_razred', $rm->platni_razred ?? '', ['class' => 'form-control', 'id' => 'platni_razred', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="stepen">{{__('Stepen stručne spreme za radno mjesto propisano OP')}}</label>
                {!! Form::select('stepen', $stepenSS, $rm->stepen ?? '', ['class' => 'form-control datepicker-2', 'id' => 'stepen', isset($preview) ? 'disabled => true' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="kategorija_rm">{{__('Kategorija radnog mjesta')}}</label>
                {!! Form::select('kategorija_rm', $kategorija, $rm->kategorija_rm ?? '', ['class' => 'form-control', 'id' => 'kategorija_rm', isset($preview) ? 'disabled => true' : '']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="id_oj">{{__('Organizaciona jedinica')}}</label>
                {!! Form::select('id_oj', $orgJed, $rm->id_oj ?? '', ['class' => 'form-control datepicker-2', 'id' => 'id_oj', isset($preview) ? 'disabled => true' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="strucna_sprema">{{__('Kompetencije')}}</label>
                {!! Form::select('strucna_sprema', $kompetencije, $rm->strucna_sprema ?? '', ['class' => 'form-control', 'id' => 'strucna_sprema', isset($preview) ? 'disabled => true' : '']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="stepen__ss__">{{__('Stepen/Vrsta stručne spreme za radno mjesto propisano OP')}}</label>
                {!! Form::textarea('stepen__ss__', $rm->stepen__ss__ ?? '', ['class' => 'form-control', 'id' => 'stepen__ss__', 'style' => 'height:120px', isset($preview) ? 'readonly' : '']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="ostale_kvalifikacije">{{__('Ostale kvalifikacije za radno mjesto iz OP')}}</label>
                {!! Form::textarea('ostale_kvalifikacije',$rm->ostale_kvalifikacije ?? '', ['class' => 'form-control', 'id' => 'ostale_kvalifikacije', 'style' => 'height:120px', isset($preview) ? 'readonly' : '']) !!}
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
