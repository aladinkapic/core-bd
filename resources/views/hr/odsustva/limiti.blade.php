@extends('template.main')
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        '#' => __('Postavke'),
        route('limiti.pregledlimita') => __('Pregled svih limita'),
    ]) !!}

@stop
@section('content')

    <div class="container container_block">
        <div class="card" style="width:100%;">
            <div class="card-header ads-darker">
                <button style="float:right;" onClick="window.location='/hr/odsustva/postavi_limit_svima';" class="btn btn-light" ><i class="fas fa-plus"></i> {{__('Postavite novi limit')}}</button>
                <h4>{{__('Opšti limiti odsustva - svi službenici')}}</h4>
            </div>
        </div>

        @foreach($svi_limiti as $limit)
            <div class="split_container" style="width:100%; margin-top:30px;">

                <div class="limits_edit_delete">
                    <a href="/hr/odsustva/uredi_limite/{{$limit->id}}">
                        <div class="icon_wrapper">
                            <i class="fas fa-edit"></i>
                        </div>
                    </a>
                    <a href="{{asset('/hr/odsustva/obrisi_limite/'.$limit->id)}}" title="Obrišite limit odsustva">
                        <div class="icon_wrapper">
                            <i class="fas fa-trash"></i>
                        </div>
                    </a>
                </div>

                <div class="form-group row">
                    <div class="col">
                        {!! Form::label('prezime', 'Vrsta odsustva : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!!  Form::select('vrsta_odsustva', $odsustva, $limit->odsustvo ,['class' => 'form-control',  'id' => 'vrsta_odsustva', 'disabled' => 'true']) !!}
                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col">
                        {!! Form::label('username', 'Ukupno trajanje odsustva : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('korisnicko_ime', $limit->ukupno.' radnih dana', ['class' => 'form-control', 'rows' => 1, 'placeholder' => '', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col">
                        {!! Form::label('email', 'Godina : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!!  Form::select('godina', [(date('Y') - 1) => (date('Y') - 1), date('Y') => date('Y'), (date('Y') + 1) => (date('Y') + 1), (date('Y') + 2     ) => (date('Y') + 2) ], isset($limit->godina) ? $limit->godina  : date('Y') ,['class' => 'form-control',  'id' => 'godina', 'disabled' => 'true']) !!}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


        {{--<div class="split_container" style="width:100%; margin-top:30px;">--}}
            {{--<div class="form-group row">--}}
                {{--<div class="col">--}}
                    {{--{!! Form::label('prezime', 'Vrsta odsustva : ', ['class' => 'control-label']) !!}--}}
                    {{--<div class="col-lg-12">--}}
                        {{--{!!  Form::select('vrsta_odsustva', $odsustva, '0' ,['class' => 'form-control',  'id' => 'vrsta_odsustva']) !!}--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}


            {{--<div class="form-group row">--}}
                {{--<div class="col">--}}
                    {{--{!! Form::label('username', 'Ukupno trajanje odsustva : ', ['class' => 'control-label']) !!}--}}
                    {{--<div class="col-lg-12">--}}
                        {{--{!! Form::text('korisnicko_ime', '', ['class' => 'form-control', 'rows' => 1, ]) !!}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col">--}}
                    {{--{!! Form::label('email', 'Godina : ', ['class' => 'control-label']) !!}--}}
                    {{--<div class="col-lg-12">--}}
                        {{--{!! Form::text('email', date('Y'), ['class' => 'form-control', 'rows' => 1, 'id' => 'email', 'autocomplete' => 'off', 'readonly']) !!}--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>
@endsection

