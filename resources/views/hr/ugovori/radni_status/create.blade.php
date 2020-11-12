@extends('template.main')
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('ugovor.index') => __('Radni status i raspored na radno mjesto'),
        route('ugovor.radni_status.create') => __('Dodavanje ugovora'),
    ]) !!}

@stop

@section('content')

    <div class="container ">
        <div class="" style="margin-left:20px; width:calc(100% - 46px); padding-left:4px;">
            <section class="multi_step_form">
                <div id="msform">

                    <div class="tittle">
                        <h2>
                            {{__('Dodavanje novog ugovora o rasporedu na radno mjesto')}}
                        </h2>
                        <p>{{__('Molimo Vas da popunite sva potrebna polja za unos. Sve aktivnosti na ovoj stranici će biti zabilježene.')}}</p>
                        <br />
                    </div>

                </div>
            </section>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach

                            <form method="POST" action="{{ route('ugovor.radni_status.store') }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Broj ugovora/odluke')}}
                                    </div>
                                    <div class="col-md-7">
                                        <input required="required" class="form-control" type="text" name="broj"
                                               placeholder="Unesite broj ugovora..." />
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Službenik')}}
                                    </div>
                                    <div class="col-md-7">
                                        <select class="form-control" name="sluzbenik">
                                            @foreach($sluzbenici as $sluzbenik)
                                                <option value="{{ $sluzbenik->id ?? '1'}}">{{ $sluzbenik->ime ?? '/'}} {{ $sluzbenik->prezime ?? '/'}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Organ javne uprave')}}
                                    </div>
                                    <div class="col-md-7">
                                        {!! Form::select('organ', $organi, '', ['class' => 'form-control radna-mjesta-organa',]) !!}
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Radno mjesto')}}
                                    </div>
                                    <div class="col-md-7">
                                        <select class="form-control select-2" name="radno_mjesto" id="privremeno_radno_mjesto">
                                            <option value="1">{{__('Aktivna radna mjesta iz organa javne uprave')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Datum ugovora/odluke')}}
                                    </div>
                                    <div class="col-md-7">
                                        <input required="required" class="form-control datepicker-2" id="datum1" type="text" name="datum"
                                               placeholder="Datum ugovora/odluke..."/>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Datum isteka ugovora/odluke')}}
                                    </div>
                                    <div class="col-md-7">
                                        <input class="form-control datepicker-2" type="text" id="datum2" name="datum_isteka"
                                               placeholder="Datum isteka ugovora/odluke..."/>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Datum isteka probnog perioda')}}
                                    </div>
                                    <div class="col-md-7">
                                        <input class="form-control datepicker-2" type="text" id="datum3" name="datum_isteka_probni"
                                               placeholder="Datum isteka probnog perioda..."/>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Broj sati')}}
                                    </div>
                                    <div class="col-md-7">
                                        {!! Form::select('broj_sati', $radno_v, '', ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Datum početka rada')}}
                                    </div>
                                    <div class="col-md-7">
                                        <input class="form-control datepicker-3" type="text" id="datum_pocetka_rada" name="datum_pocetka_rada"
                                               placeholder="Datum početka rada..."/>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">

                                    </div>
                                    <div class="col-md-7">
                                        <button class="btn btn-primary">
                                            {{__('Spremite')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
