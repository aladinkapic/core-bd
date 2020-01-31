@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        '/osposobljavanje_i_usavrsavanje/teme/home' => __('Lista tema'),
        '/osposobljavanje_i_usavrsavanje/teme/view' => __('Pregled teme'),
    ]) !!}
@stop

@section('content')

    <div class="container">

        <div class="card ">
            <div class="card-header ads-darker">
                <a href="/osposobljavanje_i_usavrsavanje/teme/editTema/{{$tema -> id ?? '1'}}"><button style="float:right;margin-right:5px;" class="btn btn-light"><i class="fa fa-pen"></i> {{__('Izmijeni')}}</button></a>
                <h3>{{__('Tema za obuku')}}</h3>
            </div>
            <div class="card-body hr-activity tab">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td><b>{{__('Naziv obuke')}}</b></td>
                                <td> {{$tema -> naziv ?? '/'}} </td>
                            </tr>
                            <tr>
                                <td><b>{{__('Oblast')}}</b></td>
                                <td> {{$tema -> oblast ?? '/'}} </td>
                            </tr>
                            <tr>
                                <td><b>{{__('Napomena')}}</b></td>
                                <td>{{$tema -> napomena ?? '/'}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
