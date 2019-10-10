@extends('template.main')

@section('other_js_links')
    <script src="{{ asset('js/organizacija.js') }}"></script>
@stop
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('organizacija.index') => 'Unutrašnja organizacija',
        route('organizacija.edit', ['id' => $organizacija->id]) => $organizacija->naziv,
        route('organizacija.radna-mjesta', ['id' => $organizacija->id]) => 'Radna mjesta',
    ]) !!}

@stop
@section('content')

    <div class="container">

        <h4>{{ $organizacija->naziv }}</h4>



        <div class="row">
            <div class="col-md-9">
                @include('hr.organizacija.snippets.menu')

                @include('hr.radna_mjesta.fajlovi.sva_radna_mjesta')

                <button class="btn btn-success" v-on:click="toggle('#dodaj')">
                    <i class="fa fa-plus"></i> {{__('Dodaj radno mjesto')}}
                </button>

                <div id="dodaj" style="display: none;">
                    @include('hr.radna_mjesta.fajlovi.dodaj')
                </div>
            </div>
            <div class="col-md-3">

                @include('hr.organizacija.snippets.sidebar')

            </div>
        </div>
    </div>


@stop