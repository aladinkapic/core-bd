@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('ugovor.privremeno.index') => __('Privremeni premještaj'),
    ]) !!}

@stop

@section('content')
    <div class="container ">

        <div class="" style="margin-left:20px; width:calc(100% - 46px); padding-left:4px;">
            <div class="" style="margin-left:20px; width:calc(100% - 46px); padding-left:4px;">
                <section class="multi_step_form">
                    <div id="msform">

                        <div class="tittle">
                            <h2>
                                {{__('Privremeni premještaj državnog službenika')}}
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

                        <form method="POST" action="{{ route('ugovor.privremeno.store') }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Službenik')}}
                                </div>

                                <!-- pozivat ćemo funkciju privremeniPremjestaj iz all_functions.js -->

                                <div class="col-md-7">
                                    <select class="form-control" id="trenutni_sluzbenik" name="sluzbenik" onchange="privremeniPremjestaj();">
                                        <option value="">Izaberite službenika</option>
                                        @foreach($sluzbenici as $sluzbenik)
                                            <option value="{{ $sluzbenik->id ?? '1'}}">{{ $sluzbenik->ime ?? '/'}} {{ $sluzbenik->prezime ?? '/'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Redovno radno mjesto')}}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::text('radno_mjesto_naziv', '', ['class' => 'form-control', 'readonly', 'id' => 'redovno_radno_mjesto_naziv']) !!}
                                    {!! Form::hidden('radno_mjesto', '', ['class' => 'form-control', 'id' => 'redovno_radno_mjesto_id']) !!}
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
                                    {{__('Privremeno radno mjesto')}}
                                </div>
                                <div class="col-md-7">
                                    <select class="form-control select-2" name="privremeno_radno_mjesto" id="privremeno_radno_mjesto">
                                        <option value="1">{{__('Aktivna radna mjesta iz organa javne uprave')}}</option>
                                    </select>
                                </div>
                            </div>
                           <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Broj rješenja')}}
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="broj_rjesenja" placeholder="Broj rješenja..."/>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Datum rješenja')}}
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="datum_rjesenja" class="form-control datepicker" name="datum_rjesenja" placeholder="Datum rješenja..." >
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Datum od')}}
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="datum_od" class="form-control datepicker" name="datum_od" placeholder="Datum od..." >
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Datum do')}}
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="datum_do" class="form-control datepicker" name="datum_do" placeholder="Datum do..." >
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Platni razred')}}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::text('platni_razred', '', ['class' => 'form-control']) !!}
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
