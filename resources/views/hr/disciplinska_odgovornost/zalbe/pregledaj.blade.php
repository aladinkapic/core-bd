@extends('template.main')
@section('title') {{__('Pregledaj žalbu')}} @endsection
@section('breadcrumbs')
    {!! \App\Http\Controllers\HelpController::breadcrumbs([
            route('home') => __('Početna stranica'),
            route('zalbe.pregled') => __('Lista žalbi')
        ]) !!}
@endsection

@section('content')
    <div class="container">
        @include('hr.disciplinska_odgovornost.fajlovi.add_4')
    </div>
@endsection
