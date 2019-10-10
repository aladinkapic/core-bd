@extends('template.main')

@section('content')

    <div class="container ">
        @include('hr.ugovori.snippets.menu')

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        {{__('Evidencija o dodatnim djelatnostima')}}
                    </div>
                    <div class="card-body">

                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach

                        <form method="POST" action="{{ route('ugovor.dodatno.store') }}">
                            @csrf
                            @method('PUT')

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
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Razlog')}}
                                </div>
                                <div class="col-md-7">
                                    <textarea class="form-control"  name="razlog" autocomplete="off"></textarea>
                                </div>
                            </div>

                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Broj rješenja')}}
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="rjesenje" placeholder="Broj rješenja..." autocomplete="off">
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Datum rješenja')}}
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id=nekiid" class="form-control datepicker" name="datum_rjesenja" placeholder="Datum rješenja..." autocomplete="off">
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">

                                </div>
                                <div class="col-md-7">
                                    <button class="btn btn-success">
                                        <i class="fa fa-plus"></i> {{__('Dodaj')}}
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