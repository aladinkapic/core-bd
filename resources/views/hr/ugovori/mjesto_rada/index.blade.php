@extends('template.main')


@section('other_js_links')
    <script>
        app.items = {!! $ugovori !!};
    </script>
@stop
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('ugovor.index') => 'Radni status i raspored na radno mjesto',
    ]) !!}

@stop
@section('content')


    <div class="container">

        @include('hr.ugovori.snippets.menu')
        <hr />
        <br />
        <div class="row">
            <div class="col-md-10">
                <h4>Mjesto rada državnog službenika </h4>
                <button v-on:click="fireTable()" class="btn btn-primary btn-xs"> <i class="fa fa-filter" style="font-size: 11px;"></i> Filteri</button>
                @include('snippets.buttons')
            </div>
            <div class="col-md-2">
                <button class="btn btn-success" style="float:right;" v-on:click="url('{{ route('ugovor.mjesto_rada.create') }}')"> <i class="fa fa-plus fa-1x"></i> Novi unos</button>
            </div>
        </div>

        <br />
        <br />

        @if(isset($success))
            <div class="alert alert-success">{{ $success }}</div>
        @endif

        <table id="filtering" class="table table-condensed table-bordered">
            <thead>
            <th>Službenik</th>
            <th>Adresa </th>
            <th>Sprat</th>
            <th>Broj kancelarije</th>
            <th>Službeno auto na raspolaganju</th>
            <th>Povjerena stalna sredstva</th>
            <th>Radno mjesto</th>
            <th style="width: 15%;" class="akcije">Akcija</th>
            </thead>
            <tbody>
            <tr class="org-row" v-if="ugovor.usluzbenik" v-for="(ugovor, index) in items" v-bind:style=" index > 10 ? 'display: none;' : 'display: table-row;'">
                <td>@{{ ugovor.usluzbenik.ime }} @{{ ugovor.usluzbenik.prezime }}</td>
                <td>@{{ ugovor.adresa }}</td>
                <td>@{{ ugovor.sprat }}</td>
                <td>@{{ ugovor.broj_kancelarije}}</td>
                <td>@{{ ugovor.sluzbeno_auto ? "Da" : "Ne" }}</td>
                <td>@{{ ugovor.povjerena_stalna_sredstva }}</td>
                <td>@{{ ugovor.usluzbenik.radno_mjesto }}</td>

                <td class="akcije">
                    <a class="btn btn-primary btn-xs" v-bind:href="'/ugovori/mjesto-rada/edit/'+ ugovor.id">
                        <i class="fa fa-pen"></i> Izmjena
                    </a>

                    <form style="display: inline-block;" method="POST" v-bind:action="'/ugovori/mjesto-rada/destroy/'+ ugovor.id">
                        {{ method_field('DELETE') }}
                        @csrf
                        <button style="display: none;" class="btn btn-danger btn-xs remove-org">
                            <i class="fa fa-times"></i>
                        </button>
                    </form>

                </td>
            </tr>
            </tbody>
        </table>
    </div>
@stop