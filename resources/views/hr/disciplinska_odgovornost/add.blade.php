@extends('template.main')

@section('breadcrumbs')
    {!! \App\Http\Controllers\HelpController::breadcrumbs([
            route('home') => __('Početna stranica'),
            '/hr/disciplinska_odgovornost/home' => __('Disciplinske odgovornosti'),
            '/hr/disciplinska_odgovornost/add' => __('Dodavanje disciplinske odgovornosti'),
        ]) !!}
@endsection

@section('content')
    <div class="container">
        <div class="card-body hr-activity tab full_container">
            @include('hr.disciplinska_odgovornost.fajlovi.add_2')
        </div>
    </div>
@endsection