@extends('template.main')
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/osposobljavanje_i_usavrsavanje/obuke/home' => 'Katalog obuka',
        route('pregled-instanci-obuke', ['id' => $instanca->obuka->id ?? '1']) => 'Pregled instanci obuke',
        route('pregledaj-instancu-obuke', ['id' => $instanca->id]) => 'Instanca sa predavačima'
    ]) !!}
@stop

@section('content')
    <div class="container" style="min-height:600px">
        <div class="row">

            <!-- POP UP Za ocjenjivanje obuke -->

            <div class="col-3">
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"
                                    id="exampleModalLabel">{{__('Ocjenjivanje instance')}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" id="ocjena" action="{{route('ocijeni-predavaca')}}">
                                    @csrf
                                    {{Form::hidden('instanca_id', $instanca->id)}}
                                    <h6> {{__('Molimo vas da izaberete službenika:')}} </h6>
                                    <select name="predavac_id" id="" class="form-control">
                                        @foreach($instanca->predavaci as $predavac)
                                            <option value="{{$predavac->imePredavaca->id ?? ''}}">
                                                {{$predavac->imePredavaca->ime ?? ''}} {{$predavac->imePredavaca->prezime ?? ''}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <h6> {{__('Molimo vas da izaberete ocjenu za ovu obuku:')}} </h6>
                                    {!!  Form::text('ocjena', '' ,['class' => 'form-control',  'id' => 'ocjena']) !!}
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Zatvori')}}</button>
                                <button type="submit" value="Submit" class="btn btn-primary" form="ocjena">{{__('Spasi!')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <section class="multi_step_form">
            <div id="msform">
                <div class="tittle">
                    <h2>
                        {{$instanca->obuka->naziv ?? 'Naziv nije unesen !'}}
                    </h2>
                    <p>Pregled instance obuke iz perioda {{$instanca->pocetak_obuke ?? ''}} - {{$instanca->kraj_obuke ?? ''}}. Odabrana instanca je "{{$instanca->status ?? ''}}".</p>
                    <br/>
                </div>
                    @include('osposobljavanje_i_usavrsavanje.obuke.instance.instanca-header')
                    <form method="POST" id="kreiranje" action="{{route('spremi-instancu-obuke')}}" enctype="multipart/form-data">
                        @csrf
                        <section class="active">
                            <div class="container_block obuke-custom-calendar" >
                                <div class="split_container" style="width: 100%;">
                                    <div class="row">
                                        <div class="col text-left">
                                            {!! Form::label('pocetak_obuke', 'Početak obuke : ', ['class' => 'control-label', 'style' => 'margin-left:15px']) !!}
                                            <div class="col-lg-12">
                                                {!! Form::text('pocetak_obuke', isset($instanca) ? $instanca->pocetak_obuke : '', ['class' => 'form-control datepicker', 'rows' => 1, 'id' => 'pocetak_obuke', 'autocomplete' => 'off']) !!}
                                            </div>
                                        </div>
                                        <div class="col">
                                            {!! Form::label('kraj_obuke', 'Kraj obuke : ', ['class' => 'control-label', 'style' => 'margin-left:15px']) !!}
                                            <div class="col-lg-12">
                                                {!!  Form::text('kraj_obuke', isset($instanca) ? $instanca->kraj_obuke : '' ,['class' => 'form-control datepicker', 'id' => 'kraj_obuke', 'autocomplete' => 'off']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top:15px;">
                                        <div class="col">
                                            {!! Form::label('datum_zatvaranja', 'Datum zatvaranja za prijave : ', ['class' => 'control-label', 'style' => 'margin-left:15px']) !!}
                                            <div class="col-lg-12">
                                                {!!  Form::text('datum_zatvaranja', isset($instanca) ? $instanca->datum_zatvaranja : '' ,['class' => 'form-control datepicker', 'id' => 'datum_zatvaranja', 'autocomplete' => 'off']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="">
                            <div class="container_block" >
                                <table class="table table-condensed table-bordered">
                                    <thead>
                                    <tr style="text-align:left;">
                                        <th class="text-center"width="80px">#</th>
                                        <th>Ime i prezime</th>
                                        <th>Email</th>
                                        <th width="150px" class="text-center">Ocjena instance</th>
                                        <th class="text-center" width="150px">{{__('Akcije')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i=1; @endphp
                                        @foreach($instanca->predavaci as $predavac)
                                            <tr style="text-align:left;">
                                                <td class="text-center">{{$i++}}</td>
                                                <td>
                                                    <a href="{{route('ocjene-predavaca', ['id' => $predavac->predavac_id ?? ''])}}">
                                                        {{$predavac->imePredavaca->ime ?? ''}} {{$predavac->imePredavaca->prezime ?? ''}}
                                                    </a>
                                                </td>
                                                <td>{{$predavac->imePredavaca->mail}}</td>
                                                <td class="text-center">{{$predavac->ocjena ?? 'Nije ocijenjen/a !'}}</td>
                                                <td class="text-center">
                                                    <a href="###" class="btn my-button" data-toggle="modal" data-target="#exampleModal" data-whatever="{{$predavac->imePredavaca->id ?? '/'}}" id="1">
                                                        Ocijenite
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
                    </div>
                </div>
            </div>
        </section>
    </div>
    @if (isset($obuka))
        <div id="maxsluz" hidden>{{$obuka -> broj_polaznika ?? '/'}}</div>
    @endif

@stop
