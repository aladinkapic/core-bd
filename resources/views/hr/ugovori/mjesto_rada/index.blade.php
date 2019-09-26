@extends('template.main')

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
                <h4>{{__('Mjesto rada državnog službenika')}} </h4>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success" style="float:right;" v-on:click="url('{{ route('ugovor.mjesto_rada.create') }}')"> <i class="fa fa-plus fa-1x"></i>{{__('Novi unos')}}</button>
            </div>
        </div>

        <br />

        @if(isset($success))
            <div class="alert alert-success">{{ $success }}</div>
        @endif

        @include('template.snippets.filters', ['var'  => $ugovori])


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
                    <td>{{$ugovor->usluzbenik->ime_prezime ?? ''}}</td>
                    <td>{{$ugovor->adresa}}</td>
                    <td>{{$ugovor->sprat}}</td>
                    <td>{{$ugovor->broj_kancelarije}}</td>
                    <td>{{$ugovor->sluzbeno_autoq->name ?? ''}}</td>
                    <td>{{$ugovor->povjerena_stalna_sredstva}}</td>
                    <td>{{$ugovor->rm->naziv_rm ?? ''}}</td>
                    <td style="text-align:center;" class="akcije">
                        <a href="{{ '/ugovori/mjesto-rada/edit/' . $ugovor->id }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{ '/ugovori/mjesto-rada/destroy/' . $ugovor->id }}"
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