@extends('template.main')

@section('breadcrumbs')
{!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        '/hr/organ_javne_uprave/home' => __('Organ javne uprave'),
        '/hr/organ_javne_uprave/add' => __('Dodajte - uredite Organ javne uprave'),
    ]) !!}
    @endsection

@section('content')
    <div class="container">
        <div class="card-body hr-activity tab full_container">
            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div><br />
            @endif
            <section class="multi_step_form">
                <div id="msform">
                    <!-- Tittle -->
                    <div class="tittle">
                        <h2>
                            @if(isset($uprava))
                                {{$uprava->naziv ?? '/'}}
                            @else
                                {{__('Novi organ javne uprave')}}
                            @endif
                        </h2>
                        <p>{{__('Molimo Vas da popunite sva potrebna polja za unos. Sve aktivnosti na ovoj stranici će biti zabilježene.')}}</p>
                        <br />
                    </div>

                    <form method="POST" id="form123" action=" {{isset($uprava) ?  '/hr/uprava/updateUprava/'.$uprava->id : route('uprava.store') }}">
                        @csrf
                        <div id="steps-window">
                            <section class="active">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label"> {{__('Naziv organa javne uprave')}}</label>
                                                    <div class="col-sm-9">
                                                        {!! Form::text('naziv', isset($uprava) ? $uprava->naziv : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'naziv', 'autocomplete' => 'off', 'style' => 'height:90px;']) !!}
                                                    </div>
                                                </div>
                                                @if ($errors ->has('naziv'))<div class="notificaiton_area alert-danger"><p> {{ $errors->first('naziv')}}</p></div>@endif

                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Kod')}}</label>
                                                    <div class="col-sm-9">
                                                        {!! Form::text('kod', isset($uprava) ? $uprava->kod : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'kod', 'autocomplete' => 'off']) !!}
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">{{__('Tip organa javne uprave')}}</label>
                                                    <div class="col-sm-9">
                                                        {!! Form::select('tip', $tipovi, isset($uprava) ? $uprava->tip : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'tip', 'autocomplete' => 'off']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Ulica')}}</label>
                                                    <div class="col-sm-9">
                                                        {!! Form::text('ulica', isset($uprava) ? $uprava->ulica : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'ulica', 'autocomplete' => 'off']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                @if ($errors ->has('ulica'))<div class="notificaiton_area alert-danger"><p> {{ $errors->first('ulica')}}</p></div>@endif
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Broj')}}</label>
                                                    <div class="col-sm-9">
                                                        {!! Form::text('broj', isset($uprava) ? $uprava->broj : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'broj', 'autocomplete' => 'off']) !!}
                                                    </div>
                                                </div>
                                                @if ($errors ->has('broj'))<div class="notificaiton_area alert-danger"><p> {{ $errors->first('broj')}}</p></div>@endif

                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">{{__('Telefon')}}</label>
                                                    <div class="col-sm-9">
                                                        {!! Form::text('telefon', isset($uprava) ? $uprava->telefon : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'telefon', 'autocomplete' => 'off']) !!}
                                                    </div>
                                                </div>
                                                @if ($errors ->has('telefon'))<div class="notificaiton_area alert-danger"><p> {{ $errors->first('telefon')}}</p></div>@endif

                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Fax')}}</label>
                                                    <div class="col-sm-9">
                                                        {!!  Form::text('fax',isset($uprava) ? $uprava->fax : '' ,['class' => 'form-control', 'id' => 'fax','autocomplete' => 'off']) !!}
                                                    </div>
                                                </div>
                                                @if ($errors ->has('fax'))<div class="notificaiton_area alert-danger"><p> {{ $errors->first('fax')}}</p></div>@endif

                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Web')}}  </label>
                                                    <div class="col-sm-9">
                                                        {!!  Form::text('web',  isset($uprava) ? $uprava->web : '' ,['class' => 'form-control',  'id' => 'web','autocomplete' => 'off']) !!}
                                                    </div>
                                                </div>
                                                @if ($errors ->has('web'))<div class="notificaiton_area alert-danger"><p> {{ $errors->first('web')}}</p></div>@endif

                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Email')}} </label>
                                                    <div class="col-sm-9">
                                                        {!! Form::text('email', isset($uprava) ? $uprava->email : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'email', 'autocomplete' => 'off']) !!}
                                                    </div>
                                                </div>
                                                @if ($errors ->has('email'))<div class="notificaiton_area alert-danger"><p> {{ $errors->first('email')}}</p></div>@endif

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
                <input class="btn btn-primary" form="form123" type="submit" value="{{__("Spasite")}}">
            </div>
        </div>
    </div>
@endsection

