@extends('template.main')

@section('content')

    <div class="container ">
        @include('hr.ugovori.snippets.menu')

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        {{__('Izmjena evidencije o prestanku radnog odnosa')}}
                    </div>
                    <div class="card-body">

                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach

                            <form method="POST" action="{{ route('ugovor.dodatno.update', ['id' => $ugovor->id]) }}">
                                @csrf
                                @method('PATCH')

                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Službenik')}}
                                    </div>
                                    <div class="col-md-7">
                                        <select disabled class="form-control" name="sluzbenik">
                                            @foreach($sluzbenici as $sluzbenik)
                                                <option @if($sluzbenik->id == $ugovor->sluzbenik) selected="selected" @endif value="{{ $sluzbenik->id ?? '1'}}">{{ $sluzbenik->ime ?? '/'}} {{ $sluzbenik->prezime ?? '/'}}</option>
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
                                        <textarea class="form-control" name="razlog">{{ $ugovor->razlog ?? '/'}}</textarea>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Broj rješenja')}}
                                    </div>
                                    <div class="col-md-7">
                                        <input value="{{ $ugovor->rjesenje ?? '/'}}" class="form-control" type="text" name="rjesenje" placeholder="Broj rješenja..."/>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Datum rješenja')}}
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="sef" value="{{ \App\Http\Controllers\HelpController::obrniDatum($ugovor->datum_rjesenja) }}" class="form-control datepicker" name="datum_rjesenja" placeholder="Datum rješenja..." >
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