@extends('template.main')
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/osposobljavanje_i_usavrsavanje/obuke/home' => 'Katalog obuka',
    ]) !!}
@stop

@section('content')
    <div class="container" style="min-height:600px">
        <section class="multi_step_form">
            <div id="msform">
                <div class="tittle">
                    <h2>
                        {{$obuka->naziv ?? 'Naziv nije unesen !'}}
                    </h2>
                    <p>{{__('Molimo Vas da popunite sva potrebna polja za unos. Sve aktivnosti na ovoj stranici će biti
                        zabilježene.')}}</p>
                    <br/>
                </div>
                @include('osposobljavanje_i_usavrsavanje.obuke.instance.instanca-header')
                    <form method="POST" id="kreiranje" action="{{route('spremi-instancu-obuke')}}" enctype="multipart/form-data">
                        @csrf
                        <section class="active">

                            {{Form::hidden('obuka_id', $obuka->id, ['class' => 'form-control'])}}

                            <div class="container_block obuke-custom-calendar" >
                                <div class="split_container" style="width: 100%;">
                                    <div class="row">
                                        <div class="col text-left">
                                            {!! Form::label('pocetak_obuke', 'Početak obuke : ', ['class' => 'control-label', 'style' => 'margin-left:15px']) !!}
                                            <div class="col-lg-12">
                                                {!! Form::text('pocetak_obuke', isset($radno_mjesto) ? $radno_mjesto->naziv_rm : '', ['class' => 'form-control datepicker', 'rows' => 1, 'id' => 'pocetak_obuke', 'autocomplete' => 'off']) !!}
                                            </div>
                                        </div>
                                        <div class="col">
                                            {!! Form::label('kraj_obuke', 'Kraj obuke : ', ['class' => 'control-label', 'style' => 'margin-left:15px']) !!}
                                            <div class="col-lg-12">
                                                {!!  Form::text('kraj_obuke', '' ,['class' => 'form-control datepicker', 'id' => 'kraj_obuke', 'autocomplete' => 'off']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top:15px;">
                                        <div class="col">
                                            {!! Form::label('datum_zatvaranja', 'Datum zatvaranja za prijave : ', ['class' => 'control-label', 'style' => 'margin-left:15px']) !!}
                                            <div class="col-lg-12">
                                                {!!  Form::text('datum_zatvaranja', '' ,['class' => 'form-control datepicker', 'id' => 'datum_zatvaranja', 'autocomplete' => 'off']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section>
                            <div class="container_block" >
                                <div class="split_container">
                                    <div class="copied_form" id="nekaamo">
                                        {!! Form::hidden('predavac_id_inp[]', 'empty', ['class' => 'form-control']) !!}
                                        <div class="form-group row">
                                            <div class="col">
                                                {!! Form::label('ime_sluzbenika', 'Ime i prezime službenika : ', ['class' => 'control-label']) !!}
                                                <div class="col-lg-12">
                                                    {!!  Form::select('predavac_id[]', $predavaci, '' ,['class' => 'form-control', 'id' => 'tip_inp']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" style="text-align:right; padding-right:16px; margin-top:30px;">
                                        <button type="button" class="btn btn-dark btn-sm" id="custom_button" onclick="createNewDomElements('korisnici', 'nekaamo');">
                                            {{__('Dodajte predavača')}}
                                        </button>
                                    </div>
                                </div>


                                <div class="split_container" style="padding:0px;">
                                    <div id="korisnici">

                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>
                    <div class="buttons" style="text-align:center;">
                        <button class="btn btn-dark">
                            <i class="fas fa-chevron-left"></i>
                            {{__('Nazad')}}
                        </button>
                        <button style="" class="btn btn-blue">
                            {{__('Dalje')}}
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <button class="btn btn-success" onclick="document.querySelector('#kreiranje').submit();">
                            <i class="fab fa-telegram"></i>
                            {{__('Spremi')}}
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @if (isset($obuka))
        <div id="maxsluz" hidden>{{$obuka -> broj_polaznika ?? '/'}}</div>
    @endif

@stop
