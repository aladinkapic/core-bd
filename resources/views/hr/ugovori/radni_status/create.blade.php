@extends('template.main')
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('ugovor.index') => 'Radni status i raspored na radno mjesto',
        route('ugovor.radni_status.create') => 'Dodavanje ugovora',
    ]) !!}

@stop
@section('content')

    <div class="container ">
        @include('hr.ugovori.snippets.menu')

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Dodavanje novog ugovora o rasporedu na radno mjesto
                    </div>
                    <div class="card-body">

                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach

                        <form method="POST" action="{{ route('ugovor.radni_status.store') }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-5">
                                    Broj ugovora/odluke
                                </div>
                                <div class="col-md-7">
                                    <input required="required" class="form-control" type="text" name="broj"
                                           placeholder="Unesite broj ugovora..." />
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    Službenik
                                </div>
                                <div class="col-md-7">
                                    <select class="form-control" name="sluzbenik">
                                        @foreach($sluzbenici as $sluzbenik)
                                            <option value="{{ $sluzbenik->id ?? '1'}}">{{ $sluzbenik->ime ?? '/'}} {{ $sluzbenik->prezime ?? '/'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    Datum ugovora/odluke
                                </div>
                                <div class="col-md-7">
                                    <input required="required" class="form-control datepicker" id="datum1" type="text" name="datum"
                                           placeholder="Datum ugovora/odluke..."/>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    Datum isteka ugovora/odluke
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control datepicker" type="text" id="datum2" name="datum_isteka"
                                           placeholder="Datum isteka ugovora/odluke..."/>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    Datum isteka probnog perioda
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control datepicker" type="text" id="datum3" name="datum_isteka_probni"
                                           placeholder="Datum isteka probnog perioda..."/>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    Broj sati
                                </div>
                                <div class="col-md-7">
                                    <input required="required" class="form-control" type="text" name="broj_sati"
                                           placeholder="Broj sati..."/>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">

                                </div>
                                <div class="col-md-7">
                                    <button class="btn btn-success">
                                        <i class="fa fa-plus"></i> Dodaj
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>




@endsection