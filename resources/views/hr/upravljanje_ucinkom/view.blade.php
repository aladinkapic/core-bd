@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('upravljanje-ucinkom-pregled') => 'Upravljanje učinkom',
        route('upravljanje-ucinkom-pregledaj', ['id' => $ucinak->id]) => $sluzbenik ?? '/'
    ]) !!}

@stop


@section('content')
    <div class="container">
        <div class="card-body hr-activity tab full_container">
            <section class="multi_step_form">
                <div id="msform">
                    <div id="steps-window">
                        <ul>
                            <li class="active">
                                <div class="list_div">
                                    <div class="back_div"></div>
                                    <div class="icon_circle">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                    <p>
                                        {{__('Upravljanje učinkom')}}
                                    </p>

                                    <div class="iconsss">
                                        <div class="single-icon steps-going-to" goto="{{route('ucinak.uredite', ['id' => $ucinak->id ?? '/'])}}">
                                            <i class="fas fa-edit"></i>
                                            <p>Uredite</p>
                                        </div>
                                        <div class="single-icon">
                                            <a href="{{route('ucinak.obrisi', ['id' => $ucinak -> id ?? '/'])}}">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>


                <form method="POST" id="formaaa" action="@if(isset($probni)) {{route('probni-rad.azuriraj')}} @else {{route('probni-rad.spremi') }} @endif">
                    @csrf

                    @if(isset($probni))
                        {!! Form::hidden('id', $probni->id) !!}
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Službenik')}}</label>
                                        <div class="col-sm-9">
                                            {!! Form::text('godina', $sluzbenik ?? '/', ['class' => 'form-control', 'rows' => 1, 'id' => 'godina','autocomplete' => 'off',  isset($preview) ? 'readonly' : '']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Radno mjesto')}}</label>
                                        <div class="col-sm-9">
                                            {!! Form::text('godina', $radnoMjesto ?? '/', ['class' => 'form-control', 'rows' => 1, 'id' => 'godina','autocomplete' => 'off',  isset($preview) ? 'readonly' : '']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Godina')}}</label>
                                        <div class="col-sm-9">
                                            {!! Form::text('godina', $ucinak -> godina ?? '/', ['class' => 'form-control', 'rows' => 1, 'id' => 'godina','autocomplete' => 'off',  isset($preview) ? 'readonly' : '']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Ocjena')}}</label>
                                        <div class="col-sm-9">
                                            {!! Form::text('ocjena', $ucinak -> ocjena ?? '', ['class' => 'form-control', 'rows' => 1, 'id' => 'ocjena_prvi', 'min'=>0,'max'=>3, 'autocomplete' => 'off',  isset($preview) ? 'readonly' : '', 'step' => '0.01']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Opisna ocjena')}}</label>
                                        <div class="col-sm-9">
                                            {!! Form::text('opisnaOcjena', $ucinak -> opisna_ocjena ?? '', ['class' => 'form-control', 'rows' => 1, 'id' => 'ocjena_drugi', 'min'=>0,'max'=>3, 'autocomplete' => 'off',  isset($preview) ? 'readonly' : '', 'step' => '0.01']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="staticEmail" class="col-sm-3 col-form-label">{{ __('Ocjenjivač')}}</label>
                                        <div class="col-sm-9">
                                            {!! Form::text('ocjenjivac', $ocjenjivac ?? '', ['class' => 'form-control', 'rows' => 1, 'id' => 'ocjenjivac', 'min'=>0,'max'=>3, 'autocomplete' => 'off',  isset($preview) ? 'readonly' : '', 'step' => '0.01']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </form>

            </section>
        </div>
    </div>
@endsection
