@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        '/hr/disciplinska_odgovornost/home' => __('Lista disciplinskih odgovornosti'),
    ]) !!}

@stop


@section('content')
    <div class="container">
        @include('hr.disciplinska_odgovornost.fajlovi.menu')

        <div class="fine-header">
            <h4>{{__('Lista disciplinskih odgovornosti')}}</h4>

            <div class="buttons">
                <a href="{{route('home')}}" title="Nazad">
                    <div class="small-button small-button-border small-button-edit">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </a>
                <a href="/hr/disciplinska_odgovornost/add">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-plus-square"></i>
                        </div>
                        <p>{{__('Nova disciplinska odgovornost')}}</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var'  => $odgovornosti])
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
                @foreach($odgovornosti as $odgovornost)
                    <tr>
                        <td class="text-center">{{$i++}}</td>
                        <td>{{$odgovornost->sluzbenik->ime_prezime ?? ''}}</td>
                        <td>{{$odgovornost->sluzbenik->radnoMjesto->naziv_rm ?? ''}}</td>
                        <td>{{$odgovornost->datumPovrede() ?? '/'}}</td>
                        <td>{{$odgovornost->opis_povrede ?? '/'}}</td>
                        <td>{{$odgovornost->vrsta_disciplinske ?? '/'}}</td>
                        <td>{{$odgovornost->opis_disciplinske_mjere ?? '/'}}</td>
                        <td>{{$odgovornost->broj_rjesenja_zabrane ?? '/'}}</td>
                        <td>{{$odgovornost->datumZabrane() ?? '/'}}</td>
                        <td>{{$odgovornost->datumZavrsetka() ?? '/'}}</td>

                        <td class="text-center">
                            <a href="{{Route('disciplinska.pregledaj', ['id' => $odgovornost->id ?? '1'])}}"
                               title="Pregledajte disciplinsku odgovornost">
                                <button class="btn my-button">{{__('Pregled')}}</button>
                            </a>
{{--                            <a href="{{Route('disciplinska.uredite', ['id' => $odgovornost->id ?? '1'])}}" style="margin-left:10px;"--}}
{{--                               title="Uredite  disciplinsku odgovornost">--}}
{{--                                <i class="fas fa-edit"></i>--}}
{{--                            </a>--}}
{{--                            <a href="{{ '/hr/disciplinska_odgovornost/obrisi/' . $odgovornost->id ?? '1'}}"--}}
{{--                               style="margin-left:10px;">--}}
{{--                                <i class="fa fa-times"></i>--}}
{{--                            </a>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
