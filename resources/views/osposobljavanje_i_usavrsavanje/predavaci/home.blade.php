@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/osposobljavanje_i_usavrsavanje/predavaci/home' => 'Lista predavača',
    ]) !!}
@stop

@section('content')
    <div class="container">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif
        <div class="row">
            <div class="col-md-10">
                <h4 >Predavači</h4>
                <button v-on:click="fireTable()" class="btn btn-primary btn-xs"> <i class="fa fa-filter" style="font-size: 11px;"></i> Filteri</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success" onClick="window.location='/osposobljavanje_i_usavrsavanje/predavaci/add';"> <i class="fa fa-plus fa-1x"></i> Novi predavač</button>
            </div>
        </div>
        <br />
        <br />
        <table id="filtering" class="table table-condensed table-bordered">
            <thead>
            <th width="100">ID</th>
            <th>Ime</th>
            <th>Prezime</th>
            <th width="150">Akcije</th>
            </thead>
            <tbody>
            @if (isset($predavaci))
            @foreach($predavaci as $predavac)
                <tr class="org-row">
                    <td>{{$predavac -> id}}</td>
                    <td>{{$predavac -> ime}}</td>
                    <td>{{$predavac -> prezime }}</td>
                    <td class="text-center">
                        <a href="/osposobljavanje_i_usavrsavanje/predavaci/viewPredavac/{{$predavac -> id}}">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="/osposobljavanje_i_usavrsavanje/predavaci/editPredavac/{{$predavac -> id}}" style="margin-left:10px;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/osposobljavanje_i_usavrsavanje/predavaci/delete/{{$predavac -> id}}" style="margin-left:10px;">
                            <i class="fas fa-times"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
                @else
                <tr>
                    <td colspan="4">{{__('Nema podataka!')}}</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection

@section('content2')
    <div class="container">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif
        <div class="col-sm-12">
            <div class="card ">
                <div class="card-header ads-darker">
                    <button onClick="window.location='/osposobljavanje_i_usavrsavanje/predavaci/add';" class="btn btn-light float-right" ><i class="fa fa-plus-circle"></i> Novi predavač</button>
                    Predavači
                </div>
                <div class="card-body hr-activity tab">

                    <br />

                    <table class="table table-bordered">
                        <thead >
                        <tr >
                            <th scope="col">Predavač</th>
                            <th scope="col">Obuke</th>
                            <th scope="col" width="120px;" class="text-center">Akcije</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($predavaci as $predavac)
                            <tr>
                                <td>{{$predavac -> ime}}</td>
                                <td>{{$predavac -> prezime }}</td>
                                <td width="120px;" class="text-center">
                                    <a href="/osposobljavanje_i_usavrsavanje/predavaci/viewPredavac/{{$predavac -> id}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="/osposobljavanje_i_usavrsavanje/predavaci/editPredavac/{{$predavac -> id}}" style="margin-left:10px;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/osposobljavanje_i_usavrsavanje/predavaci/delete/{{$predavac -> id}}" style="margin-left:10px;">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>

                    <br />
                    <br />
                </div>
            </div>

        </div>
    </div>
@endsection