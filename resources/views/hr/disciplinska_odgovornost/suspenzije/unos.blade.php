@extends('template.main')
@section('title') Unos žalbe @endsection
@section('breadcrumbs')
    {!! \App\Http\Controllers\HelpController::breadcrumbs([
            route('home') => __('Početna stranica'),
            route('suspenzije.pregled') => __('Lista suspenzija'),
            route('suspenzije.unos') => __('Unos suspenzije'),
        ]) !!}
@endsection

@section('content')
    <div class="container">
        @include('hr.disciplinska_odgovornost.fajlovi.add_5')
    </div>
@endsection