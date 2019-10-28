@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/hr/upravljanje_ucinkom/home' => 'Upravljanje učinkom detaljno',
    ]) !!}
@stop


@section('content')
    <div class="container">

    </div>
@endsection