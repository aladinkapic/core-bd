@extends('template.main')

@section('content')

    <div class="container ">
        @include('hr.ugovori.snippets.menu')

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Privremeni premještaj državnog službenika
                    </div>
                    <div class="card-body">

                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach

                        <form method="POST" action="{{ route('ugovor.prestanak.store') }}">
                            @csrf
                            @method('PUT')

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
                                    Razlog
                                </div>
                                <div class="col-md-7">
                                    <textarea class="form-control"  name="razlog"></textarea>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    Radno mjesto
                                </div>
                                <div class="col-md-7">
                                    <input required="required" class="form-control" type="hidden" name="radno_mjesto"
                                           placeholder="Sprat..."/> Viši stručni saradnik za pitanja
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    Broj rješenja
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="rjesenje" placeholder="Broj rješenja..."/>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    Datum rješenja
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="nek" class="form-control" name="datum_rjesenja datepicker" placeholder="Datum rješenja..." >
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