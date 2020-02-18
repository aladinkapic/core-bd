@extends('template.main')
<?php
if (isset($instanca) and ($instanca === 'new')) {
    $save = true;
    $naslov = __('Pregled obuke');
    $naslov2 = __('Dodavanje instance obuke');
} else if (isset($pregled) and $pregled === true) {
    $naslov = __('Pregled obuke');
    $save = false;
} else {
    $save = true;
    if (isset($obuka)) {
        $naslov = __('Uređivanje obuke');
    } else {
        $naslov = __('Nova obuka');
    }
}

if (isset($instanca) and ($instanca) === 'new') {
    $formlink = "/osposobljavanje_i_usavrsavanje/obuke/storeInstancu";
} else if (isset($obuka)) {
    $formlink = '/osposobljavanje_i_usavrsavanje/obuke/update/' . $obuka->id;
} else $formlink = "/osposobljavanje_i_usavrsavanje/obuke/add";

if (isset($naslov2) and ($naslov2 === 'Dodavanje instance obuke')) $naslov = $naslov2;

if (isset($instanca) and $instanca != 'new') {
    $naslov = 'Pregled instance obuke';
    $save = false;
}

?>
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        '/osposobljavanje_i_usavrsavanje/obuke/home' => __('Katalog obuka'),
    ]) !!}
@stop

@section('content')
    <div class="container">
        <section class="multi_step_form">
            <div id="msform">
                <div id="steps-window">
                    <ul>
                        <li class="active">
                            <div class="list_div">
                                <div class="back_div"></div>
                                <div class="icon_circle">
                                    <i class="fab fa-leanpub"></i>
                                </div>
                                <p>
                                    @if(isset($obuka))
                                        {{$obuka->naziv}}
                                    @else
                                        {{__('Nova obuka')}}
                                    @endif
                                </p>
                            </div>
                        </li>
                    </ul>
                    <form method="POST" id="kreiranje" action="@if(isset($edit)) {{route('azuriraj-obuku')}} @else {{route('spremi-obuke')}} @endif" enctype="multipart/form-data">
                        @csrf
                        @if(isset($obuka)) {!! Form::hidden('id_obuke', $obuka->id) !!} @endif


                        <section class="active">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label"> {{__('Naziv obuke')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::text('naziv', isset($obuka) ? $obuka->naziv : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'naziv', 'autocomplete' => 'off', isset($preview) ? 'readonly' : '']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Vrsta obuke')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::text('vrsta', isset($obuka) ? $obuka->vrsta : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'vrsta', 'autocomplete' => 'off', isset($preview) ? 'readonly' : '']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Oblast obuke')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::select('oblast',$oblasti, isset($obuka) ? $obuka->oblast : '', ['class' => 'form-control', 'rows' => 3, 'id' => 'oblast', 'autocomplete' => 'off', isset($preview) ? 'disabled => true' : '']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Tema obuke')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::select('podtema', $niztema, isset($obuka) ? $obuka->podtema : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'podtema', 'autocomplete' => 'off', isset($preview) ? 'disabled => true' : '']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Organizator obuke')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::text('organizator', isset($obuka) ? $obuka->organizator : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'organizator', 'autocomplete' => 'off', isset($preview) ? 'readonly' : '']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Sjedište organizatora obuke')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::text('sjediste', isset($obuka) ? $obuka->sjediste : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'sjediste', 'autocomplete' => 'off', isset($preview) ? 'readonly' : '']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{__('Zemlja organizatora')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::select('zemlja_organizatora', $drzava,isset($obuka) ? $obuka->zemlja_organizatora : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'zemlja_organizatora', 'autocomplete' => 'off', isset($preview) ? 'disabled => true' : '']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Izdavanje potvrde')}}</label>
                                                <div class="col-sm-9">
                                                    {!!  Form::select('potvrda',array('0' => 'NE', '1' => 'DA'),  isset($obuka) ? $obuka->potvrda : '' ,['class' => 'form-control',  'id' => 'potvrda', isset($preview) ? 'disabled => true' : '']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Stečena znanja')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::text('stecena_znanja', isset($obuka) ? $obuka->stecena_znanja : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'stecena_znanja', 'autocomplete' => 'off', isset($preview) ? 'readonly' : '']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Maksimalan broj polaznika')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::number('broj_polaznika', isset($obuka) ? $obuka->broj_polaznika : '', ['class' => 'form-control', 'max' => 100, 'min' => 1, 'id' => 'broj_polaznika', 'autocomplete' => 'off', isset($preview) ? 'readonly' : '']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Opis obuke')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::textarea('opis', isset($obuka) ? $obuka->opis : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'opis', 'autocomplete' => 'off', 'style' => 'height:200px; resize:none;', isset($preview) ? 'readonly' : '']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>
                    @if(isset($edit) || !isset($obuka))
                        <div class="buttons" style="text-align:center;">
                            <button class="btn btn-success" onclick="document.querySelector('#kreiranje').submit();">
                                <i class="fab fa-telegram"></i>
                                {{__('Spremite')}}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>

@stop
