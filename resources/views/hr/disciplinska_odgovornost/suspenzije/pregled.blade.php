@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('suspenzije.pregled') => __('Lista suspenzija'),
    ]) !!}

@stop


@section('content')
    <div class="container">
        @include('hr.disciplinska_odgovornost.fajlovi.menu')

        <div class="fine-header">
            <h4>{{__('Lista suspenzija')}}</h4>

            <div class="buttons">
                <a href="{{route('home')}}" title="Nazad">
                    <div class="small-button small-button-border small-button-edit">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </a>
                <a href="/hr/disciplinska_odgovornost/unos_suspenzija">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-plus-square"></i>
                        </div>
                        <p>{{__('Unesite novu suspenziju')}}</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var'  => $suspenzije])
            <table id="filtering" class="table table-condensed table-bordered">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    @include('template.snippets.filters_header')
                    <th style="text-align:center;" class="akcije" style="width: 15%;">{{__('Akcija')}}</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1; @endphp
                @foreach($suspenzije as $suspenzija)
                    <tr>
                        <td class="text-center">{{$i++}}</td>
                        <td>{{$suspenzija->disciplinskaOdgovornost->sluzbenik->ime_prezime ?? ''}}</td>
                        <td>{{$suspenzija->disciplinskaOdgovornost->sluzbenik->radnoMjesto->naziv_rm ?? ''}}</td>
                        <td>{{$suspenzija->disciplinskaOdgovornost->opis_disciplinske_mjere ?? ''}}</td>
                        <td>{{$suspenzija->broj_rjesenja ?? '/'}}</td>
                        <td>{{$suspenzija->razlog_udaljenja ?? '/'}}</td>
                        <td>{{$suspenzija->datum_udaljenja ?? '/'}}</td>
                        <td style="text-align:center;" class="akcije">
                            <a href="{{ '/hr/disciplinska_odgovornost/pregledajte_suspenzija/' . $suspenzija->id ?? '1'}}">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ '/hr/disciplinska_odgovornost/uredite_suspenzija/' . $suspenzija->id ?? '1'}}" style="margin-left:10px;">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ '/hr/disciplinska_odgovornost/obrisite_suspenziju/' . $suspenzija->id ?? '1'}}"
                               style="margin-left:10px;">
                                <i class="fa fa-times"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop