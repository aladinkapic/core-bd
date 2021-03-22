@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('upravljanje-ucinkom-pregled') => 'Upravljanje učinkom',
    ]) !!}
@stop

@section('content')
    <div class="container">
        <div class="fine-header">
            <h4>{{__('Upravljanje učinkom')}}</h4>

            <div class="buttons">
                <a href="{{route('home')}}" title="Nazad">
                    <div class="small-button small-button-border small-button-edit">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </a>
                <a href="/hr/upravljanje_ucinkom/add">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-plus-square"></i>
                        </div>
                        <p>{{__('Izvršite ocjenjivanje')}}</p>
                    </div>
                </a>
                <a href="{{route('upravljanje-ucinkom.pregled-izvjestaja')}}">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-chart-area"></i>
                        </div>
                        <p>{{__('Izvještaji')}}</p>
                    </div>
                </a>
                <a href="{{route('probni-rad.pregled')}}">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <p>{{__('Probni rad')}}</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var'  => $ucinci])
            <table id="filtering" class="table table-condensed table-bordered">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    @include('template.snippets.filters_header')
                    <th style="text-align:center;" class="akcije" width="120px">{{__('Akcija')}}</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1; @endphp
                @foreach($ucinci as $ucinak)
                    <tr>
                        <td class="text-center">{{$i++}}</td>
                        <td>
                            <a href="{{route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $ucinak -> usluzbenik->id ?? '1'])}}">
                                {{$ucinak -> usluzbenik->ime_prezime ?? ''}}
                            </a>
                        </td>
                        <td>
                            <a href="{{route('radnamjesta.pregledaj', ['id' => $ucinak -> mjesto->rm->id ?? '1'])}}">
                                {{ $ucinak -> mjesto->rm->naziv_rm ?? '/' }}
                            </a>
                        </td>
                        <td>{{$ucinak -> godina ?? '/'}}</td>
                        <td>{{$ucinak -> ocjena ?? '/'}}</td>
                        <td>{{$ucinak -> opisna_ocjena ?? '/'}}</td>
                        <td>
                            <a href="{{route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $ucinak -> ocjenjivacRel->id ?? '1'])}}">
                                {{$ucinak -> ocjenjivacRel->ime_prezime ?? ''}}
                            </a>
                        </td>

                        <td class="text-center">
                            <a href="/hr/upravljanje_ucinkom/viewUcinak/{{$ucinak -> id ?? '1'}}">
                                <button class="btn my-button">Pregled</button>
                            </a>
{{--                            <a href="/hr/upravljanje_ucinkom/editUcinak/{{$ucinak -> id ?? '1'}}" style="margin-left:10px;">--}}
{{--                                <i class="fas fa-edit"></i>--}}
{{--                            </a>--}}
{{--                            <a href="/hr/upravljanje_ucinkom/delete/{{$ucinak -> id ?? '1'}}" style="margin-left:10px;">--}}
{{--                                <i class="fas fa-times"></i>--}}
{{--                            </a>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
