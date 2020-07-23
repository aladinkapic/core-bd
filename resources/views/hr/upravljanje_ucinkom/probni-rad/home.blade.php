@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('upravljanje-ucinkom-pregled') => 'Upravljanje učinkom',
        route('probni-rad.pregled') => 'Probni rad'
    ]) !!}
@stop

@section('content')
    <div class="container">

        <div class="fine-header">
            <h4>{{__('Upravljanje učinkom - probni rad')}}</h4>

            <div class="buttons">
                <a href="{{route('upravljanje-ucinkom-pregled')}}">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-angle-left"></i>
                        </div>
                        <p>{{__('Nazad')}}</p>
                    </div>
                </a>
                <a href="{{route('probni-rad.dodaj')}}">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-plus"></i>
                        </div>
                        <p>{{__('Dodajte')}}</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var'  => $sviProbni])
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
                @foreach($sviProbni as $probni)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$probni->usluzbenik->ime_prezime ?? '/'}}</td>
                        <td>{{$probni->godina ?? '/'}}</td>
                        <td>{{$probni->prviClan->ime_prezime ?? '/'}}</td>
                        <td>{{$probni->drugiClan->ime_prezime ?? '/'}}</td>
                        <td>{{$probni->treciClan->ime_prezime ?? '/'}}</td>
                        <td>{{$probni->ocjena ?? '/'}}</td>
                        <td>{{$probni->opisna_ocjena ?? '/'}}</td>
                        <td class="text-center">
                            <a href="{{route('probni-rad.pregledaaj', ['id' => $probni->id])}}">
                                <button class="btn my-button">Pregled</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
{{--                @foreach($ucinci as $ucinak)--}}
{{--                    <tr>--}}
{{--                        <td class="text-center">{{$i++}}</td>--}}
{{--                        <td>--}}
{{--                            <a href="{{route('sluzbenik.dodatno', ['id' => $ucinak -> usluzbenik->id ?? '1'])}}">--}}
{{--                                {{$ucinak -> usluzbenik->ime_prezime ?? ''}}--}}
{{--                            </a>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <a href="{{route('radnamjesta.pregledaj', ['id' => $ucinak -> mjesto->rm->id ?? '1'])}}">--}}
{{--                                {{ $ucinak -> mjesto->rm->naziv_rm ?? '/' }}--}}
{{--                            </a>--}}
{{--                        </td>--}}
{{--                        <td>{{$ucinak -> kategorija_ocjene->name ?? '/'}}</td>--}}
{{--                        <td>{{$ucinak -> godina ?? '/'}}</td>--}}
{{--                        <td>{{$ucinak -> ocjena ?? '/'}}</td>--}}
{{--                        <td>{{$ucinak -> opisna_ocjena ?? '/'}}</td>--}}
{{--                        <td class="text-center">--}}
{{--                            <a href="/hr/upravljanje_ucinkom/viewUcinak/{{$ucinak -> id ?? '1'}}">--}}
{{--                                <i class="fa fa-eye"></i>--}}
{{--                            </a>--}}
{{--                            <a href="/hr/upravljanje_ucinkom/editUcinak/{{$ucinak -> id ?? '1'}}" style="margin-left:10px;">--}}
{{--                                <i class="fas fa-edit"></i>--}}
{{--                            </a>--}}
{{--                            <a href="/hr/upravljanje_ucinkom/delete/{{$ucinak -> id ?? '1'}}" style="margin-left:10px;">--}}
{{--                                <i class="fas fa-times"></i>--}}
{{--                            </a>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
                </tbody>
            </table>
        </div>
    </div>
@stop
