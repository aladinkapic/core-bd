@extends('template.main')

@section('other_js_links')
    <script>
        app.items = {!! $teme !!};
        // app.hidden_columns = [2,3];
        // app.mountHidden();
    </script>
@stop

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/osposobljavanje_i_usavrsavanje/teme/home' => 'Lista tema',
    ]) !!}
@stop

@section('content')
    <div class="container">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{session()->get('success')}}
            </div>
        @endif
            <div class="row">
                <div class="col-md-10">
                    <h4 >{{__('Teme za obuku')}}</h4>
                    <button v-on:click="fireTable()" class="btn btn-primary btn-xs"> <i class="fa fa-filter" style="font-size: 11px;"></i> {{__('Filtriraj')}}</button>
                    @include('snippets.buttons')
                </div>
                <div class="col-md-2">
                    <button class="btn  btn-success" v-on:click="url('/osposobljavanje_i_usavrsavanje/teme/add')"> <i class="fa fa-plus fa-1x"></i> {{__('Nova tema za obuku')}}</button>
                </div>
            </div>

        <br />
        <br />
        <table id="filtering" class="table table-condensed table-bordered">
            <thead>
            <th width="100">ID</th>
            <th>Naziv</th>
            <th>Oblast</th>
            <th width="150">Akcije</th>
            </thead>
            <tbody>
            @foreach($teme as $tema)
                <tr class="org-row">
                    <td>{{$tema -> id}}</td>
                    <td>{{$tema -> naziv}}</td>
                    <td>{{$tema -> oblast }}</td>
                    <td class="text-center">
                        <a href="/osposobljavanje_i_usavrsavanje/teme/viewTema/{{$tema -> id}}">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="/osposobljavanje_i_usavrsavanje/teme/editTema/{{$tema -> id}}" style="margin-left:10px;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/osposobljavanje_i_usavrsavanje/teme/delete/{{$tema -> id}}" style="margin-left:10px;">
                            <i class="fas fa-times"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
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
                    <button onClick="window.location='/osposobljavanje_i_usavrsavanje/teme/add';" class="btn btn-light float-right" ><i class="fa fa-plus-circle"></i> Nova tema za obuku</button>
                     Teme za obuku
                </div>
                <div class="card-body hr-activity tab">

                    <br />

                    <table class="table table-bordered">
                        <thead >
                        <tr >
                            <th scope="col">Naziv teme</th>
                            <th scope="col">Oblast</th>
                            <th scope="col" width="120px;" class="text-center">Akcije</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($teme as $tema)
                            <tr>
                                <td>{{$tema -> naziv}}</td>
                                <td>{{$tema -> oblast }}</td>
                                <td width="120px;" class="text-center">
                                    <a href="/osposobljavanje_i_usavrsavanje/teme/viewTema/{{$tema -> id}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="/osposobljavanje_i_usavrsavanje/teme/editTema/{{$tema -> id}}" style="margin-left:10px;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/osposobljavanje_i_usavrsavanje/teme/delete/{{$tema -> id}}" style="margin-left:10px;">
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