@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('sluzbenik.pregled') => __('Lista državnih službenika'),
    ]) !!}

@stop

@section('content')

    <div class="container ">

        <div class="" style="margin-left:20px; width:calc(100% - 46px); padding-left:4px;">
            <section class="multi_step_form">
                <div id="msform">

                    <div class="tittle">
                        <h2>
                            {{__('Radni staž kod prethodnih poslodavaca')}}
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
                            @include('hr.sluzbenici.new.forme.forme-includes.prethodni-rs')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
