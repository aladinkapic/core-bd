@extends('template.main')

@section('content')

    <div class="container ">
        @include('hr.ugovori.snippets.menu')

        <div class="" style="margin-left:20px; width:calc(100% - 46px); padding-left:4px;">
            <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{__('Izmjena ugovora o rasporedu na radno mjesto')}}
                    </div>
                    <div class="card-body">

                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach

                            <form method="POST" action="{{ route('ugovor.privremeno.update', ['id' => $ugovor->id]) }}">
                                @csrf
                                @method('PATCH')

                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Službenik')}}
                                    </div>
                                    <div class="col-md-7">
                                        <select class="form-control" name="sluzbenik">
                                            <option selected="selected" value="{{ $sluzbenik->id ?? '1'}}">{{$sluzbenik->ime ?? '/'}} {{$sluzbenik->prezime ?? '/'}}</option>
                                        </select>

                                        {{--<input required="required" readonly value="" class="form-control" type="text" name="sluzbenik"/>--}}
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Privremeno radno mjesto')}}
                                    </div>
                                    <div class="col-md-7">
                                        <select class="form-control" name="privremeno_radno_mjesto">
                                            @foreach($radnaMjesta as $radnoMjesto)
                                                <option value="{{ $radnoMjesto->id ?? '1'}}">{{ $radnoMjesto->naziv_rm ?? '/'}}</option>
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
                                        <input required="required" value="@if($sluzbenik->radnoMjesto) {{$sluzbenik->radnoMjesto->naziv_rm ?? '/'}} @endif" class="form-control" type="text" name="radno_mjesto"/>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Broj rješenja')}}
                                    </div>
                                    <div class="col-md-7">
                                        <input value="{{ $ugovor->broj_rjesenja }}" class="form-control" type="text" name="broj_rjesenja" placeholder="Broj rješenja..."/>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Datum rješenja')}}
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" value="{{ \App\Http\Controllers\HelpController::obrniDatum($ugovor->datum_rjesenja) }}" class="form-control datepicker" id="datum_rjesenja" name="datum_rjesenja" placeholder="Datum rješenja..." >
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Datum od')}}
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" value="{{ \App\Http\Controllers\HelpController::obrniDatum($ugovor->datum_od) }}" class="form-control datepicker" id="datum_od" name="datum_od" placeholder="Datum od..." >
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Datum do')}}
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" value="{{ \App\Http\Controllers\HelpController::obrniDatum($ugovor->datum_do) }}" class="form-control datepicker" id="datum_do" name="datum_do" placeholder="Datum do..." >
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">

                                    </div>
                                    <div class="col-md-7">
                                        <button class="btn btn-success">
                                            <i class="fa fa-plus"></i> {{__('Ažurirajte')}}
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