@extends('template.main')

@section('breadcrumbs')
    {!! \App\Http\Controllers\HelpController::breadcrumbs([
            route('home') => __('Početna stranica'),
            route('zalbe.pregled') => __('Lista žalbi'),
            route('zalbe.unos') => __('Unos žalbe'),
        ]) !!}
@endsection

@section('content')
    <div class="container">
        @include('hr.disciplinska_odgovornost.fajlovi.add_4')
    </div>
@endsection