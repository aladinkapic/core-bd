@extends('template.main')
@section('title') Dodajte / Pregledajte praznike @stop

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '#' => 'Postavke',
        route('odsustva.dodajpraznik') => 'Dodajte - uredite praznik',
    ]) !!}

@stop

@section('content')
    <div class="container container_block">

        <div class="row" style="display:initial; width:100%;">
            <div class="steps-wizard" style="width:100%; margin-left:10px;">
                <ul class="four">
                    <li class="{{ Request::path() == 'hr/odsustva/praznici/dodaj' ? 'active' : '' }} single_bar ">
                        <i class="far fa-plus-square"></i>
                        <a href="{{asset('/hr/odsustva/praznici/dodaj')}}">Dodajte novi praznik</a>
                    </li>
                    <li class="{{ Request::path() == 'hr/odsustva/uredi_praznik' ? 'active' : '' }} single_bar ">
                        <i class="fas fa-edit"></i>
                        <a href="/hr/odsustva/uredi_praznik">Uredite praznike</a>
                    </li>
                    <li class="{{ Request::path() == 'hr/odsustva/pregled_praznika' ? 'active' : '' }} single_bar ">
                        <i class="far fa-calendar-alt"></i>
                        <a href="/hr/odsustva/pregled_praznika">Pregled svih praznika</a>
                    </li>
                </ul>
            </div>
        </div>


        @if((Request::path() == 'hr/odsustva/praznici/dodaj'))
            <div class="card " style=" margin-left:-5px; width:calc(100% - 20px);">
                <div class="card-body hr-activity tab">

                    <div class="row">
                        <form action="{{asset('/hr/odsustva/spremi_praznik')}}" method="POST">
                        @csrf <!-- {{ csrf_field() }} -->
                            <div class="col-md-12">
                                <table class="table table-sm">
                                    <tbody>
                                    <tr>
                                        <td><b>Naziv praznika:</b></td>
                                        <td>
                                            {!! Form::text('naziv_praznika', $value = null, ['class' => 'form-control read_stuffs', 'rows' => 1, 'id' => 'naziv_praznika', 'autocomplete' => 'off', ]) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Datum praznika:</b></td>
                                        <td>
                                            {!! Form::text('datum_praznika', $value = null, ['class' => 'form-control read_stuffs datepicker', 'rows' => 1, 'id' => 'dodaj_datum_praznika', 'autocomplete' => 'off', ]) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            {{ Form::checkbox('agree', 'value', ['class' => 'form-control', 'readonly', 'disabled' => 'true']) }}
                                            Upisom podataka i spremanjem u bazu podataka potvrđujem da su svi uneseni podaci tačni te ne utiču na stabilnost, konzistentnost i integritet sistema i podataka. Svaka izmjena je zapisana.
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <button style="float:right;" class="btn btn-dark" ><i class="fa fa-plus"></i> Dodajte praznik</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        @elseif(Request::path() == 'hr/odsustva/uredi_praznik/'.(isset($praznik->id) ? $praznik->id : '0'))
            <div class="card " style=" margin-left:-5px; width:calc(100% - 20px);">
                <div class="card-body hr-activity tab">
                    <div class="row">
                        <form action="{{asset('/hr/odsustva/azuriraj_praznik')}}" method="POST">
                        @csrf <!-- {{ csrf_field() }} -->
                            <div class="col-md-12">
                                <table class="table table-sm">
                                    <tbody>
                                    <tr>
                                        <td><b>Naziv praznika:</b></td>
                                        <td>
                                            {!! Form::hidden('id_praznika', $praznik->id, ['class' => 'form-control']) !!}
                                            {!! Form::text('naziv_praznika', $praznik->naziv_praznika, ['class' => 'form-control read_stuffs', 'rows' => 1, 'id' => 'naziv_praznika', 'autocomplete' => 'off', ]) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Datum praznika:</b></td>
                                        <td>
                                            {!! Form::text('datum_praznika', \App\Http\Controllers\HelpController::obrniDatum($praznik->datum_praznika), ['class' => 'form-control read_stuffs datepicker', 'rows' => 1, 'id' => 'dodaj_datum_praznika', 'autocomplete' => 'off', ]) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            {{ Form::checkbox('agree', 'value', ['class' => 'form-control', 'readonly', 'disabled' => 'true']) }}
                                            Upisom podataka i spremanjem u bazu podataka potvrđujem da su svi uneseni podaci tačni te ne utiču na stabilnost, konzistentnost i integritet sistema i podataka. Svaka izmjena je zapisana.
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <button style="float:right;" class="btn btn-dark" ><i class="fas fa-edit"></i> Ažurirajte praznik</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @elseif(Request::path() == 'hr/odsustva/uredi_praznik')
            @foreach($praznici as $praznik)
                <div class="split_container" style="width:calc(100% - 20px); margin-left:-6px; margin-top:30px;">

                    <div class="limits_edit_delete">
                        <a href="/hr/odsustva/uredi_praznik/{{$praznik->id ?? '1'}}" title="Uredite praznik {{$praznik->naziv_praznika ?? '/'}}">
                            <div class="icon_wrapper">
                                <i class="fas fa-edit"></i>
                            </div>
                        </a>
                        <a href="{{asset('/hr/odsustva/obrisi_praznik/'.$praznik->id ?? '1')}}" title="Obrišite limit odsustva">
                            <div class="icon_wrapper" title="Izbrišite praznik {{$praznik->naziv_praznika ?? '/'}}">
                                <i class="fas fa-trash"></i>
                            </div>
                        </a>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            {!! Form::label('prezime', 'Naziv praznika : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!!  Form::text('vrsta_odsustva', $praznik->naziv_praznika ,['class' => 'form-control',  'id' => 'vrsta_odsustva', 'disabled' => 'true']) !!}
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col">
                            {!! Form::label('datum_praznika', 'Datum praznika : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('datum_praznika',  \App\Http\Controllers\HelpController::obrniDatum($praznik->datum_praznika), ['class' => 'form-control read_stuffs', 'rows' => 1, 'id' => '', 'autocomplete' => 'off','readonly' ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="calendar"> </div>


            <script>
                window.onload = function(){
                    init_calendar(true, true);
                }
            </script>
        @endif

    </div>
@endsection



{{--mstsc -v 192.168.14.14--}}