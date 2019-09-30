@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/hr/upravljanje_ucinkom/home' => 'Upravljanje učinkom',
    ]) !!}
@stop

@section('content')
    <div class="container">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif
            @if(session()->get('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div><br />
            @endif
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
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="form-group row">
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
                                                    {!! Form::number('godina', isset($ucinak) ? $ucinak->godina : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'godina', 'autocomplete' => 'off']) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('godina'))<div class="notificaiton_area alert-danger"><p> {{ $errors->first('godina')}}</p></div>@endif
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Ocjena')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::number('ocjena', isset($ucinak) ? round($ucinak->ocjena) : '', ['class' => 'form-control','step'=>'any','min'=>1,'max'=>3, 'rows' => 1, 'id' => 'ocjena', 'autocomplete' => 'off']) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('ocjena'))<div class="notificaiton_area alert-danger"><p> {{ $errors->first('ocjena')}}</p></div>@endif
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label">{{__('Opisna ocjena')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::select('opisna_ocjena',[
                                                    "Ne zadovoljava očekivanja"=>"Ne zadovoljava očekivanja",
                                                    "Zadovoljava očekivanja"  => "Zadovoljava očekivanja",
                                                      "Nadmašuje očekivanja" => "Nadmašuje očekivanja"],
                                                       isset($ucinak) ? $ucinak->opisna_ocjena : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'opisna_ocjena', 'autocomplete' => 'off']) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('opisna_ocjena'))<div class="notificaiton_area alert-danger"><p> {{ $errors->first('opisna_ocjena')}}</p></div>@endif

                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Kategorija')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::select('kategorija', $kategorija, isset($ucinak) ? $ucinak->kategorija : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'kategorija', 'autocomplete' => 'off']) !!}
                                                </div>
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
            <input class="btn btn-primary" form="form123" type="submit" value="Spasi">
        </div>

    </div>

@endsection

