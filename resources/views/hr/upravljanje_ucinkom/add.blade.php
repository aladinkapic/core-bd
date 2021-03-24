@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/hr/upravljanje_ucinkom/home' => 'Upravljanje učinkom',
    ]) !!}
@stop

@section('content')
    <div class="container">
        <section class="multi_step_form">
            <div id="msform">
                <!-- Tittle -->
                <div class="tittle">
                    <h2>{{isset($ucinak) ?  __('Uređivanje upravljanja učinkom') : __('Ocjenjivanje državnog službenika') }}</h2>
                    <p>{{__('Molimo Vas da popunite sva potrebna polja za unos. Sve aktivnosti na ovoj stranici će biti
                            zabilježene.')}}</p>
                    <br />
                </div>

                <form method="POST" id="form123" action=" {{isset($ucinak) ?  '/hr/upravljanje_ucinkom/updateUcinak/'.$ucinak->id : route('ucinak.store') }}">
                    @csrf

                    <div id="steps-window">

                        <section class="active">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="form-group row" style="height: 38px;">
                                                <label for="staticEmail" class="col-sm-3 col-form-label"> {{__('Službenik')}}</label>
                                                <div class="col-sm-9">
                                                    <select class="js-example-basic-single form-control" name="sluzbenik">
                                                        @foreach($niz_sluzbenika as $key => $value)
                                                            <option value="{{$key}}" @if(isset($ucinak)) @if ($ucinak->sluzbenik == $key) selected @endif  @endif>{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Godina')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::number('godina', isset($ucinak) ? $ucinak->godina : date('Y'), ['class' => 'form-control', 'rows' => 1, 'id' => 'godina', 'autocomplete' => 'off']) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('godina'))<div class="notificaiton_area alert-danger"><p> {{ $errors->first('godina')}}</p></div>@endif

                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Ocjena')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::number('ocjena', isset($ucinak) ? $ucinak->ocjena : '', ['class' => 'form-control','step'=>'any','min'=>1,'max'=>3, 'rows' => 1, 'id' => 'ocjena', 'autocomplete' => 'off', 'step' => '0.01']) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('ocjena'))<div class="notificaiton_area alert-danger"><p> {{ $errors->first('ocjena')}}</p></div>@endif

                                            <div class="form-group row" style="height: 38px;">
                                                <label for="staticEmail" class="col-sm-3 col-form-label"> {{__('Ocjenivač')}}</label>
                                                <div class="col-sm-9">
                                                    <select class="js-example-basic-single form-control" name="ocjenjivac">
                                                        @foreach($niz_sluzbenika as $key => $value)
                                                            <option value="{{$key}}" @if(isset($ucinak)) @if ($ucinak->ocjenjivac == $key) selected @endif  @endif>{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Nije ocijenjen')}}</label>
                                                <div class="col-sm-9 text-left">
                                                    <div class="form-check mt-0">
                                                        <input class="form-check-input mt-2 pt-0" type="checkbox" name="nije_ocjenjen" value="1" id="nije_ocjenjen">
                                                    </div>
                                                </div>
                                            </div>

{{--                                            <div class="form-group row" style="height: 38px;">--}}
{{--                                                <label for="staticEmail" class="col-sm-3 col-form-label"> {{__('Ocjenivač')}}</label>--}}
{{--                                                <div class="col-sm-9">--}}
{{--                                                    <select class="js-example-basic-single form-control" name="ocjenjivac">--}}
{{--                                                        @foreach($niz_sluzbenika as $key => $value)--}}
{{--                                                            <option value="{{$key}}" @if(isset($ucinak)) @if ($ucinak->ocjenjivac == $key) selected @endif  @endif>{{$value}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
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
            <input class="btn btn-primary" form="form123" type="submit" value="Spremite">
        </div>
    </div>
@endsection

