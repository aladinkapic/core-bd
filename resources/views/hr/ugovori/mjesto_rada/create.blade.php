@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('ugovor.index') => __('Radni status i raspored na radno mjesto'),
    ]) !!}

@stop

@section('content')

    <div class="container ">

        <div class="" style="margin-left:20px; width:calc(100% - 46px); padding-left:4px;">
            <section class="multi_step_form">
                <div id="msform">

                    <div class="tittle">
                        <h2>
                            {{__('Dodavanje novog ugovora o mjestu rada')}}
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

                        <form method="POST" action="{{ route('ugovor.mjesto_rada.store') }}">
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
                                    {{__('Adresa')}}
                                </div>
                                <div class="col-md-7">
                                    <input required="required" class="form-control" type="text" name="adresa"
                                           placeholder="Unesite adresu..." />
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Sprat')}}
                                </div>
                                <div class="col-md-7">
                                    <input required="required" class="form-control" type="text" name="sprat"
                                           placeholder="Sprat..."/>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Broj kancelarije')}}
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="broj_kancelarije"
                                           placeholder="Broj kancelarije..."/>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Službeno auto na raspolaganju')}}
                                </div>
                                <div class="col-md-7">
                                    <input type="checkbox" value="1" name="sluzbeno_auto"
                                              placeholder="Službeno auto na raspolaganju..." >
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Povjerena stalna sredstva')}}
                                </div>
                                <div class="col-md-7">
                                    <textarea class="form-control"  name="povjerena_stalna_sredstva"
                                              placeholder="Povjerena stalna sredstva..." ></textarea>
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
