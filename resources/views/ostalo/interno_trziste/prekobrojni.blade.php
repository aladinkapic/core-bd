@extends('template.main')
@section('title') {{__('Upražnjena radna mjesta')}} @endsection

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('internotrziste.pregled') => 'Upražnjena radna mjesta',
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
                    <th scope="col">{{__('Ime i prezime službenika')}}</th>
                    <th scope="col">{{__('Radno mjesto')}}</th>
                    <th scope="col" class="text-center" width="140px">{{__('Rješenje')}}</th>
                    <th scope="col" class="text-center" width="140px">{{__('Pregled')}}</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1; @endphp
                @foreach($sluzbenici as $korisnik)
                    <tr>
                        <th scope="row" width="40px;" class="text-center">{{$i++}}</th>
                        <td> {{$korisnik->ime ?? '/'}} {{$korisnik->prezime ?? '/'}} </td>
                        <td> {{$korisnik->radnoMjesto->naziv_rm ?? '/'}} </td>
                        <td class="text-center">
                            <a href="#" title="Dodajte / uredite rješenje" class="rjesenje rjesenje_korisnika" data-id="{{ $korisnik->id ?? '1'}}" data-name="{{ $korisnik->ime ?? '/'}} {{ $korisnik->prezime ?? '/'}}">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('sluzbenik.dodatnoRjesenje', ['id_sluzbenika' => $korisnik->id, 'what' => true]) }}">
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



