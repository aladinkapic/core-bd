@extends('template.main')
@section('title') Upražnjena radna mjesta @endsection

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('internotrziste.privremeni.premjestaj') => 'Privremeni premještaj',
    ]) !!}

@stop

@section('content')
    <div class="container">
        @include('ostalo/interno_trziste/fajlovi/menu')
        @include('ostalo/interno_trziste/fajlovi/forma')

        <div class="split_container split_container5" style="padding:0px;">
            <table class="table table-bordered text-left">
                <thead >
                <tr>
                    <th scope="col" width="40px;" class="text-center">#</th>
                    <th scope="col">Ime i prezime službenika</th>
                    <th scope="col">Radno mjesto</th>
                    <th scope="col" class="text-center">Privremeni premještaj</th>
                    <th scope="col" class="text-center" width="140px">Pregled</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1; @endphp
                @foreach($sluzbenici as $korisnik)
                    <tr>
                        <th scope="row" width="40px;" class="text-center">{{$i++}}</th>
                        <td> {{$korisnik->ime}} {{$korisnik->prezime}} </td>
                        <td>
                            @if($korisnik->radnoMjesto)
                                {{$korisnik->radnoMjesto->naziv_rm}}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">
                            @if($korisnik->privremeniPremjestaj)
                                {{$korisnik->privremeniPremjestaj->naziv_rm}}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="#">
                                <i class="fa fa-eye" style="margin-right:10px;"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
