@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('upravljanje-ucinkom-pregled') => 'Upravljanje učinkom',
        route('probni-rad.pregled') => 'Probni rad'
    ]) !!}

@stop

{{--@section('other_css_links') <link href="{{ asset('css/select2.css') }}" rel="stylesheet"> @endsection--}}

@section('content')
    <div class="container">
        <div class="card-body hr-activity tab full_container">
            <section class="multi_step_form">
                <div id="msform">

                    @if(isset($preview))
                        <div id="steps-window">
                            <ul>
                                <li class="active">
                                    <div class="list_div">
                                        <div class="back_div"></div>
                                        <div class="icon_circle">
                                            <i class="fas fa-tasks"></i>
                                        </div>
                                        <p>
                                            {{__('Ocjenjivanje probnog rada')}}
                                        </p>

                                        <div class="iconsss">
                                            <div class="single-icon steps-going-to" goto="{{route('probni-rad.uredii', ['id' => $probni->id])}}">
                                                <i class="fas fa-edit"></i>
                                                <p>Uredite</p>
                                            </div>
                                            <div class="single-icon">
                                                <a href="/hr/upravljanje_ucinkom/delete/{{$ucinak -> id ?? '1'}}">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    @else
                    <!-- Tittle -->
                        <div class="tittle">
                            <h2>
                                {{__('Ocjenjivanje probnog rada')}}
                            </h2>
                            <p>{{__('Molimo Vas da popunite sva potrebna polja za unos. Sve aktivnosti na ovoj stranici će biti
                            zabilježene.')}}</p>
                            <br />
                        </div>
                    @endif

                    <form method="POST" id="formaaa" action="@if(isset($probni)) {{route('probni-rad.azuriraj')}} @else {{route('probni-rad.spremi') }} @endif">
                        @csrf

                        @if(isset($probni))
                            {!! Form::hidden('id', $probni->id) !!}
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group row" >
                                            <label for="staticEmail" class="col-sm-3 col-form-label"> {{__('Službenik')}}</label>
                                            <div class="col-sm-9">
                                                <div class="col-lg-12">
                                                    {!!  Form::select('sluzbenik_id', $sluzbenici, isset($probni) ? $probni->sluzbenik_id : '' ,['class' => 'form-control', 'id' => 'sluzbenik_id', isset($preview) ? 'disabled => true' : '']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row" >
                                            <label for="staticEmail" class="col-sm-3 col-form-label"> {{__('Prvi član')}}</label>
                                            <div class="col-sm-9">
                                                <div class="col-lg-12">
                                                    {!!  Form::select('prvi_ocjenjivac', $sluzbenici, isset($probni) ? $probni->prvi_ocjenjivac : '' ,['class' => 'form-control', 'id' => 'prvi_ocjenjivac', isset($preview) ? 'disabled => true' : '']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row" >
                                            <label for="staticEmail" class="col-sm-3 col-form-label"> {{__('Drugi član')}}</label>
                                            <div class="col-sm-9">
                                                <div class="col-lg-12">
                                                    {!!  Form::select('drugi_ocjenjivac', $sluzbenici, isset($probni) ? $probni->drugi_ocjenjivac : '' ,['class' => 'form-control', 'id' => 'drugi_ocjenjivac', isset($preview) ? 'disabled => true' : '']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row" >
                                            <label for="staticEmail" class="col-sm-3 col-form-label"> {{__('Treći član')}}</label>
                                            <div class="col-sm-9">
                                                <div class="col-lg-12">
                                                    {!!  Form::select('treci_ocjenjivac', $sluzbenici, isset($probni) ? $probni->treci_ocjenjivac : '' ,['class' => 'form-control', 'id' => 'treci_ocjenjivac', isset($preview) ? 'disabled => true' : '']) !!}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Godina')}}</label>
                                            <div class="col-sm-9">
                                                {!! Form::number('godina', isset($probni) ? $probni->godina : date('Y'), ['class' => 'form-control', 'rows' => 1, 'id' => 'godina','autocomplete' => 'off',  isset($preview) ? 'readonly' : '']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Ocjena')}}</label>
                                            <div class="col-sm-9">
                                                {!! Form::number('ocjena_prvi', isset($probni) ? $probni->ocjena_prvi : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'ocjena_prvi', 'min'=>0,'max'=>3, 'autocomplete' => 'off',  isset($preview) ? 'readonly' : '', 'step' => '0.01']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Ocjena')}}</label>
                                            <div class="col-sm-9">
                                                {!! Form::number('ocjena_drugi', isset($probni) ? $probni->ocjena_drugi : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'ocjena_drugi', 'min'=>0,'max'=>3, 'autocomplete' => 'off',  isset($preview) ? 'readonly' : '', 'step' => '0.01']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Ocjena')}}</label>
                                            <div class="col-sm-9">
                                                {!! Form::number('ocjena_treci', isset($probni) ? $probni->ocjena_treci : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'ocjena_treci', 'min'=>0,'max'=>3, 'autocomplete' => 'off',  isset($preview) ? 'readonly' : '', 'step' => '0.01']) !!}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(!isset($preview))
                            <br>
                            <div class="buttons" style="text-align:center;">
                                <input class="btn btn-primary" form="formaaa" type="submit" value="Spremite">
                            </div>
                        @endif
                    </form>
                </div>
            </section>
        </div>
    </div>
@endsection

