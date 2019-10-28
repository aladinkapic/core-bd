@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/hr/upravljanje_ucinkom/home' => 'Upravljanje učinkom detaljno',
    ]) !!}
@stop


@section('content')

    <div class="container">

        <div class="card ">
            <div class="card-header ads-darker">
                <a href="/hr/upravljanje_ucinkom/editUcinak/{{$ucinak -> id ?? '1'}}"><button style="float:right;margin-right:5px;" class="btn btn-light"><i class="fa fa-pen"></i> {{__('Izmijeni')}}</button></a>
                <h3>{{__('Upravljanje učinkom')}}</h3>
            </div>
            <div class="card-body hr-activity tab">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td><b>{{__('Službenik:')}}</b></td>
                                <td> {{$sluzbenik ?? '/'}} </td>
                            </tr>
                            <tr>
                                <td><b>{{__('Radno mjesto:')}}</b></td>
                                <td> {{$radnoMjesto ?? '/'}} </td>
                            </tr>
                            <tr>
                                <td><b>{{__('Godina:')}}</b></td>
                                <td> {{$ucinak -> godina ?? '/'}} </td>
                            </tr>

                            <tr>
                                <td><b>{{__('Ocjena:')}}</b></td>
                                <td> {{$ucinak -> ocjena ?? '/'}} </td>
                            </tr>
                            <tr>
                                <td><b>{{__('Opisna ocjena:')}}</b></td>
                                <td>{{$ucinak -> opisna_ocjena ?? '/'}}</td>
                            </tr>

                            <tr>
                                <td><b>{{__('Kategorija:')}}</b></td>
                                <td>{{$ucinak-> kategorija ?? '/'}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection