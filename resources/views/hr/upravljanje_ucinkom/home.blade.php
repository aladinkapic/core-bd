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
                <button v-on:click="fireTable()" class="btn btn-primary btn-xs"> <i class="fa fa-filter" style="font-size: 11px;"></i> {{__("Filteri")}}</button>
                @include('snippets.buttons')
            </div>
            <div class="col-md-2">
                <button class="btn btn-success" onClick="window.location='/hr/upravljanje_ucinkom/add';"> <i class="fa fa-plus fa-1x"></i> {{__("Izvrši ocjenjivanje")}}</button>
            </div>
        </div>
        <br />
        <br />
        <table id="filtering" class="table table-condensed table-bordered">
            <thead>
            <th width="100">{{__('ID')}}</th>
            <th>{{__("Službenik")}}</th>
            <th>{{__("Radno mjesto")}}</th>
            <th>{{__("Kategorija")}}</th>
            <th>{{__("Godina")}}</th>
            <th>{{__("Ocjena")}}</th>
            <th width="150">{{__("Akcije")}}</th>
            </thead>
            <tbody>
            @foreach($ucinci as $ucinak)
                <tr class="org-row">
                    <td>{{$ucinak -> id}}</td>
                    <td>{{$ucinak -> sluzbenikime}}</td>
                    <td>{{$ucinak -> radnoMjesto}}</td>
                    <td>{{$ucinak -> kategorija}}</td>
                    <td>{{$ucinak -> godina}}</td>
                    <td>{{$ucinak -> ocjena}}</td>
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
@endsection

