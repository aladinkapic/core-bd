@extends('template.main')
@section('title'){{__(' E-Konkurs ')}}@endsection

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        "#" => __('eKonkurs')
    ]) !!}

@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="steps-wizard" style="width:100%; margin-left:10px;">
                <ul class="four">
                    <li class="{{ Request::path() == 'ekonkurs/request' ? 'active' : '' }} single_bar2">
                        <i class="fas fa-plus"></i>
                        <a href="{{route('ekonkurs.request')}}">{{__('Unos službenika')}}</a>
                    </li>
                    <li class="{{ Request::path() == 'ekonkurs/historija' ? 'active' : '' }} single_bar2">
                        <i class="fas fa-search"></i>
                        <a href="{{route('ekonkurs.historija')}}">{{__('Historija zahtjeva')}}</a>
                    </li>
                </ul>
            </div>
        </div>


        <div class="full_container container_block">
            @if(Request::path() == 'ekonkurs/request')
                @include('ekonkurs/fajlovi/request')

                {{--<div class="sluzbenik_osnovne_info">--}}
                    {{--@include('ekonkurs/fajlovi/dodaj_sluz')--}}
                {{--</div>--}}
            @else
                @include('ekonkurs/fajlovi/historija')
            @endif
        </div>
    </div>
@endsection
