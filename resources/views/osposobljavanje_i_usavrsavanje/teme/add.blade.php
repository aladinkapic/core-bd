@extends('template.main')
<?php
if(isset($tema)) $naslov = 'Uređivanje teme za obuku'; else $naslov = 'Nova tema za obuku';
?>
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        '/osposobljavanje_i_usavrsavanje/teme/home' => __('Lista tema'),
        '/osposobljavanje_i_usavrsavanje/teme/add' => '',
    ]) !!}
@stop

@section('content')
    <div class="container">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif
        <section class="multi_step_form">
            <div id="msform">
                <!-- Tittle -->
                <div class="tittle">
                    <h2>{{__($naslov) ?? '/'}}</h2>
                    <p>{{__('Molimo Vas da popunite sva potrebna polja za unos. Sve aktivnosti na ovoj stranici će biti zabilježene.')}}</p>
                    <br />
                </div>

                <form method="POST" id="form123" action=" {{isset($tema) ?  '/osposobljavanje_i_usavrsavanje/teme/updateTema/'.$tema->id : route('tema.store') }}">
                    @csrf

                    <div id="steps-window">

                        <section class="active">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label"> {{__('Naziv teme za obuku')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::text('naziv', isset($tema) ? $tema->naziv : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'naziv', 'autocomplete' => 'off']) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('naziv'))<div class="notificaiton_area alert-danger"><p> {{ $errors->first('naziv')}}</p></div>@endif
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label">{{__('Oblast')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::select('oblast', $oblasti, isset($tema) ? $tema->oblast : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'oblast', 'autocomplete' => 'off']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Napomena')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::textarea('napomena', isset($tema) ? $tema->napomena : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'napomena', 'autocomplete' => 'off']) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('napomena'))<div class="notificaiton_area alert-danger"><p> {{ $errors->first('napomena')}}</p></div>@endif
                                        </div>

                                    </div>
                                </div>

                            </div>
                    </div>
        </section>
    </div>

    </form>
    </div>
    </section>
    <br>
    <div class="buttons" style="text-align:center;">
        <input class="btn btn-primary" form="form123" type="submit" value="{{__('Spremite')}}">
    </div>

    </div>

@endsection

