@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/osposobljavanje_i_usavrsavanje/predavaci/home' => 'Lista predavača',
        '/osposobljavanje_i_usavrsavanje/predavaci/view' => 'Pregled predavača' ,
    ]) !!}
@stop

@section('content')

    <div class="container">

        <div class="card ">
            <div class="card-header ads-darker">
                <a href="/osposobljavanje_i_usavrsavanje/predavaci/editPredavac/{{$predavac -> id}}"><button style="float:right;margin-right:5px;" class="btn btn-light"><i class="fa fa-pen"></i> {{__('Izmijeni')}}</button></a>
                <h3>{{__('Predavač')}}</h3>
            </div>
            <div class="card-body hr-activity tab">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td><b>{{__('Ime predavača')}}</b></td>
                                <td> {{$predavac -> ime}} </td>
                            </tr>
                            <tr>
                                <td><b>{{__('Prezime predavača')}}</b></td>
                                <td> {{$predavac -> prezime}} </td>
                            </tr>
                            <tr>
                                <td><b>{{__('Telefon')}}</b></td>
                                <td> {{$predavac -> telefon}} </td>
                            </tr>

                            <tr>
                                <td><b>{{__('E-mail')}}</b></td>
                                <td> {{$predavac -> mail}} </td>
                            </tr>
                            <tr>
                                <td><b>{{__('Napomena')}}</b></td>
                                <td>{{$predavac -> napomena}}</td>
                            </tr>
                            <tr>
                                <td><b>{{__('Teme za obuku')}}</b></td>
                                <td>
                                    {{$oblastitekst}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection