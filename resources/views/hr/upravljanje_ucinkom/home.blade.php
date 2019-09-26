@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/hr/upravljanje_ucinkom/home' => 'Upravljanje učinkom',
    ]) !!}
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h4 >{{__("Upravljanje učinkom")}}</h4>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success" onClick="window.location='/hr/upravljanje_ucinkom/add';"> <i class="fa fa-plus fa-1x"></i> {{__("Izvrši ocjenjivanje")}}</button>
            </div>
        </div>
        <br />

        @if(isset($success))
            <div class="alert alert-success">{{ $success }}</div>
        @endif

        @include('template.snippets.filters', ['var'  => $ucinci])


        <table id="filtering" class="table table-condensed table-bordered">
            <thead>
            <tr>
                @include('template.snippets.filters_header')
                <th style="text-align:center;" class="akcije" style="width: 15%;">{{__('Akcija')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($ucinci as $ucinak)
                <tr>
                    <td>{{$ucinak -> usluzbenik->ime_prezime ?? ''}}</td>
                    <td>{{$ucinak -> mjesto->naziv_rm ?? ''}}</td>
                    <td>{{$ucinak -> kategorija_ocjene->name}}</td>
                    <td>{{$ucinak -> godina}}</td>
                    <td>{{$ucinak -> ocjena}}</td>
                    <td>{{$ucinak -> opisna_ocjena}}</td>
                    <td class="text-center">
                        <a href="/hr/upravljanje_ucinkom/viewUcinak/{{$ucinak -> id}}">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="/hr/upravljanje_ucinkom/editUcinak/{{$ucinak -> id}}" style="margin-left:10px;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/hr/upravljanje_ucinkom/delete/{{$ucinak -> id}}" style="margin-left:10px;">
                            <i class="fas fa-times"></i>
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
            {{--<th width="100">{{__('ID')}}</th>--}}
            {{--<th>{{__("Službenik")}}</th>--}}
            {{--<th>{{__("Radno mjesto")}}</th>--}}
            {{--<th>{{__("Kategorija")}}</th>--}}
            {{--<th>{{__("Godina")}}</th>--}}
            {{--<th>{{__("Ocjena")}}</th>--}}
            {{--<th width="150">{{__("Akcije")}}</th>--}}
            {{--</thead>--}}
            {{--<tbody>--}}
            {{--@foreach($ucinci as $ucinak)--}}
                {{--<tr class="org-row">--}}
                    {{--<td>{{$ucinak -> id}}</td>--}}
                    {{--<td>{{$ucinak -> sluzbenikime}}</td>--}}
                    {{--<td>{{$ucinak -> radnoMjesto}}</td>--}}
                    {{--<td>{{$ucinak -> kategorija}}</td>--}}
                    {{--<td>{{$ucinak -> godina}}</td>--}}
                    {{--<td>{{$ucinak -> ocjena}}</td>--}}
                    {{--<td class="text-center">--}}
                        {{--<a href="/hr/upravljanje_ucinkom/viewUcinak/{{$ucinak -> id}}">--}}
                            {{--<i class="fa fa-eye"></i>--}}
                        {{--</a>--}}
                        {{--<a href="/hr/upravljanje_ucinkom/editUcinak/{{$ucinak -> id}}" style="margin-left:10px;">--}}
                            {{--<i class="fas fa-edit"></i>--}}
                        {{--</a>--}}
                        {{--<a href="/hr/upravljanje_ucinkom/delete/{{$ucinak -> id}}" style="margin-left:10px;">--}}
                            {{--<i class="fas fa-times"></i>--}}
                        {{--</a>--}}
                    {{--</td>--}}
                {{--</tr>--}}
            {{--@endforeach--}}
            {{--</tbody>--}}
        {{--</table>--}}
    {{--</div>--}}
{{--@endsection--}}

