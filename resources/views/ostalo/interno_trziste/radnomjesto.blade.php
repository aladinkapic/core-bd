@extends('template.main')
@section('title') Upražnjena radna mjesta @endsection

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('internotrziste.radnomjesto', ['id' => 'id']) => 'Pregled upražnjenog radno mjesta i rješenja',
    ]) !!}

@stop

@section('content')
    <div class="container">
        @include('ostalo/interno_trziste/fajlovi/menu')
        @include('ostalo/interno_trziste/fajlovi/forma')



    </div>
@endsection
