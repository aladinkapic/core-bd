@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('ugovor.privremeno.index') => 'Privremeni premještaj',
    ]) !!}

@stop
@section('content')


    <div class="container">

        @include('hr.ugovori.snippets.menu')
        <hr />
        <br />
        <div class="row">
            <div class="col-md-10">
                <h4>{{__('Privremeni premještaj ')}}</h4>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success" style="float:right;" v-on:click="url('{{ route('ugovor.privremeno.create') }}')"> <i class="fa fa-plus fa-1x"></i>{{__('Novi unos')}}</button>
            </div>
        </div>

        <br />

        @if(isset($success))
            <div class="alert alert-success">{{ $success }}</div>
        @endif

        <table id="filtering" class="table table-condensed table-bordered">
            <thead>
            <tr>
                @include('template.snippets.filters_header')
                <th style="text-align:center;" class="akcije" style="width: 15%;">{{__('Akcija')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($ugovori as $ugovor)
                <tr>
                    <td><a href="{{route('sluzbenik.dodatno', ['id_sluzbenika'=>$ugovor->sluzbenik])}}">{{$ugovor->usluzbenik->ime_prezime ?? ''}}</a></td>
                    <td>{{$ugovor->mjesto->naziv_rm ?? ''}}</td>
                    <td>{{$ugovor->privremeno_mjesto->naziv_rm ?? ''}}</td>
                    <td>{{$ugovor->broj_rjesenja}}</td>
                    <td>{{$ugovor->datum_rjesenja}}</td>
                    <td>{{$ugovor->datum_od}}</td>
                    <td>{{$ugovor->datum_do}}</td>
                    <td style="text-align:center;" class="akcije">
                        <a href="{{ '/ugovori/privremeno/edit/' . $ugovor->id }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{ '/ugovori/privremeno/destroy/' . $ugovor->id }}"
                           style="margin-left:10px;">
                            <i class="fa fa-times"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
        {{--<table id="filtering" class="table table-condensed table-bordered">--}}
            {{--<thead>--}}
            {{--<th>Službenik</th>--}}
            {{--<th>Redovno radno mjesto</th>--}}
            {{--<th>Privremeno radno mjesto</th>--}}
            {{--<th>Broj rješenja</th>--}}
            {{--<th>Datum rješenja</th>--}}
            {{--<th>Datum od</th>--}}
            {{--<th>Datum do</th>--}}
            {{--<th class="akcije" style="width: 15%;">Akcija</th>--}}
            {{--</thead>--}}
            {{--<tbody>--}}
            {{--<tr class="org-row" v-if="ugovor.usluzbenik" v-for="(ugovor, index) in items" v-bind:style=" index > 10 ? 'display: none;' : 'display: table-row;'">--}}
                {{--<td>@{{ ugovor.usluzbenik.ime }} @{{ ugovor.usluzbenik.prezime }}</td>--}}
                {{--<td>@{{ ugovor.radno_mjesto }}</td>--}}
                {{--<td>@{{ ugovor.privremeno_radno_mjesto }}</td>--}}
                {{--<td>@{{ ugovor.broj_rjesenja}}</td>--}}
                {{--<td>@{{ ugovor.datum_rjesenja | formatDate }}</td>--}}
                {{--<td>@{{ ugovor.datum_od | formatDate }}</td>--}}
                {{--<td>@{{ ugovor.datum_do | formatDate }}</td>--}}

                {{--<td class="akcije">--}}
                    {{--<a class="btn btn-primary btn-xs" v-bind:href="'/ugovori/privremeno/edit/'+ ugovor.id">--}}
                        {{--<i class="fa fa-pen"></i> Izmjena--}}
                    {{--</a>--}}

                    {{--<form style="display: inline-block;" method="POST" v-bind:action="'/ugovori/privremeno/destroy/'+ ugovor.id">--}}
                        {{--{{ method_field('DELETE') }}--}}
                        {{--@csrf--}}
                        {{--<button style="display: none;" class="btn btn-danger btn-xs remove-org">--}}
                            {{--<i class="fa fa-times"></i>--}}
                        {{--</button>--}}
                    {{--</form>--}}

                {{--</td>--}}
            {{--</tr>--}}
            {{--</tbody>--}}
        {{--</table>--}}
    {{--</div>--}}
{{--@stop--}}