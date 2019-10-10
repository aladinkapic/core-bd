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

        @include('template.snippets.filters', ['var'  => $radnaMjesta])


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
                @endforeach


        <table class="table table-bordered low-padding" id="filtering">
            <thead>
            <tr>
                @include('template.snippets.filters_header')
                {{--                @if(!isset($prekobrojni))--}}
                {{--                    <th scope="col" class="text-center">Rješenje</th>--}}
                {{--                @endif--}}
                <th width="120px" class="text-center">Akcije</th>
            </tr>
            </thead>
            <tbody>

            @php $counter = 1; @endphp

            @foreach($radnaMjesta as $rm)
                @if($rm->broj_izvrsilaca < $rm->sluzbeniciRel->count())

                    <tr>
                        <td>{{$counter++}}</td>
                        <td>{{$rm->naziv_rm}}</td>
                        <td>{{$rm->orgjed->naziv }}</td>
                        <td>{{$rm->orgjed->organizacija->organ->naziv}}</td>
                        <td>{{$rm->sifra_rm ?? '/'}}</td>
                        <td>{{$rm->broj_izvrsilaca ?? '/'}}</td>
                        <td>{{$rm->sluzbeniciRel->count()}}</td>
                        <td class="text-center">
                            <a href="{{route('radnamjesta.rjesenje', ['id' => $rm->id, 'what' => 'true'])}}"
                               title="Pregledajte radno mjesto">
                                <button class="btn my-button">Pregled</button>
                            </a>
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
