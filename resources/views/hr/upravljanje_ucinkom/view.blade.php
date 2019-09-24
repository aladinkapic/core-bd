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
                <a href="/hr/upravljanje_ucinkom/editUcinak/{{$ucinak -> id}}"><button style="float:right;margin-right:5px;" class="btn btn-light"><i class="fa fa-pen"></i> Izmijeni</button></a>
                <h3>Upravljanje učinkom</h3>
            </div>
            <div class="card-body hr-activity tab">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td><b>Službenik:</b></td>
                                <td> {{$sluzbenik}} </td>
                            </tr>
                            <tr>
                                <td><b>Radno mjesto:</b></td>
                                <td> {{$radnoMjesto}} </td>
                            </tr>
                            <tr>
                                <td><b>Godina:</b></td>
                                <td> {{$ucinak -> godina}} </td>
                            </tr>

                            <tr>
                                <td><b>Ocjena:</b></td>
                                <td> {{$ucinak -> ocjena}} </td>
                            </tr>
                            <tr>
                                <td><b>Opisna ocjena:</b></td>
                                <td>{{$ucinak -> opisna_ocjena}}</td>
                            </tr>

                            <tr>
                                <td><b>{{__('Kategorija:')}}</b></td>
                                <td>{{$ucinak-> kategorija}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection