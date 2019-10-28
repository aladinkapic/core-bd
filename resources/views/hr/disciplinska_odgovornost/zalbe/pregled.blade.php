@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('zalbe.pregled') => __('Lista žalbi'),
    ]) !!}

@stop


@section('content')
    <div class="container">
        @include('hr.disciplinska_odgovornost.fajlovi.menu')

        <div class="fine-header">
            <h4>{{__('Lista žalbi')}}</h4>

            <div class="buttons">
                <a href="{{route('home')}}" title="Nazad">
                    <div class="small-button small-button-border small-button-edit">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </a>
                <a href="/hr/disciplinska_odgovornost/unos_zalbe">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-plus-square"></i>
                        </div>
                        <p>{{__('Unesite novu žalbu')}}</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var'  => $zalbe])
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
                @foreach($zalbe as $zalba)
                    <tr>
                        <td class="text-center">{{$i++}}</td>
                        <td>{{$zalba->disciplinskaOdgovornost->sluzbenik->ime_prezime ?? ''}}</td>
                        <td>{{$zalba->disciplinskaOdgovornost->sluzbenik->radnoMjesto->naziv_rm ?? ''}}</td>
                        <td>{{$zalba->disciplinskaOdgovornost->opis_disciplinske_mjere ?? ''}}</td>
                        <td>{{$zalba->broj_ulozene_zalbe ?? '/'}}</td>
                        <td>{{$zalba->datumUlozene() ?? '/'}}</td>
                        <td>{{$zalba->broj_odluke_zalbe ?? '/'}}</td>
                        <td>{{$zalba->datumOdluke() ?? '/'}}</td>
                        <td style="text-align:center;" class="akcije">
                            <a href="{{ '/hr/disciplinska_odgovornost/pregledajte_zalbu/' . $zalba->id ?? '1'}}" style="margin-left:10px;">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ '/hr/disciplinska_odgovornost/uredite_zalbu/' . $zalba->id ?? '1'}}" style="margin-left:10px;">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ '/hr/disciplinska_odgovornost/obrisite_zalbu/' . $zalba->id ?? '1'}}"
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