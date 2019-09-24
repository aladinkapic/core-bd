@extends('template.main')

<?php
if (isset($predavac)) $naslov = 'Uređivanje Predavača'; else $naslov = 'Novi Predavač';
?>
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/osposobljavanje_i_usavrsavanje/predavaci/home' => 'Lista predavača',
        '/osposobljavanje_i_usavrsavanje/predavaci/add' => $naslov ,
    ]) !!}
@stop

@section('content')
    <div class="container">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br/>
        @endif
        <section class="multi_step_form">
            <div id="msform">
                <!-- Tittle -->
                <div class="tittle">
                    <h2>{{$naslov }}</h2>
                    <p>{{__('Molimo Vas da popunite sva potrebna polja za unos. Sve aktivnosti na ovoj stranici će biti
                            zabilježene.')}}</p>
                    <br/>
                </div>

                <form method="POST" id="form123"
                      action=" {{isset($predavac) ?  '/osposobljavanje_i_usavrsavanje/predavaci/updatePredavac/'.$predavac->id : route('predavac.store') }}">
                    @csrf

                    <div id="steps-window">

                        <section class="active">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label"> {{__('Ime predavača')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::text('ime', isset($predavac) ? $predavac->ime : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'ime', 'autocomplete' => 'off']) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('ime'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('ime')}}</p></div>@endif
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Prezime predavača')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::text('prezime', isset($predavac) ? $predavac->prezime : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'prezime', 'autocomplete' => 'off']) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('prezime'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('prezime')}}</p></div>@endif
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Telefon')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::text('telefon', isset($predavac) ? $predavac->telefon : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'telefon', 'autocomplete' => 'off']) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('telefon'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('telefon')}}</p></div>@endif
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('E-mail')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::text('mail', isset($predavac) ? $predavac->mail : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'mail', 'autocomplete' => 'off']) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('mail'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('mail')}}</p></div>@endif
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Napomena')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::textarea('napomena', isset($predavac) ? $predavac->napomena : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'napomena', 'autocomplete' => 'off']) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('napomena'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('napomena')}}</p></div>@endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <label for="staticEmail"
                                                   class="col-sm-3 col-form-label">{{__('Oblasti obuka')}}</label>
                                            <select class="js-example-basic-multiple form-control"
                                                    style="width: 100%;" name="teme[]" multiple="multiple">
                                                @foreach($oblasti as $key => $value)
                                                    <option value="{{$key}}"
                                                            @if (isset($selected)) @if(in_array($key, $selected)) selected @endif @endif>{{$value}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors ->has('teme'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('teme')}}</p></div>@endif
                                            <br>
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
        <input class="btn btn-primary" form="form123" type="submit"
               value="{{isset($predavac) ?  __('Uređivanje Predavača') : __('Dodajte predavača') }}">
    </div>

    </div>

@endsection

