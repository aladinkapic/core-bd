@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
    ]) !!}
@stop

@section('content')
    <style>
        .mybtn{
            background-color: DodgerBlue;
            border: none;
            color: white;
            padding: 12px 30px;
            cursor: pointer;
            font-size: 20px;
        }
        .mybtn:hover {
            background-color: RoyalBlue;
            color: white;
        }
    </style>
    <div class="container pt-2">
        <h3>{{__('Administratorska uputstva')}}</h3>

        <br>

        <div class="row">
            <div class="single-saved-file">
                <a href="{{ asset('uputstva/Administratorsko uputstvo BD - BIH-converted.pdf') }}" class="mybtn" download="Administratorsko uputstvo BD">
                    <i class="fa fa-download"></i>
                    Preuzmite dokument: Administratorsko uputstvo BD
                </a>
            </div>
        </div>
    </div>
@endsection
