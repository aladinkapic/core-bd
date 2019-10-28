@extends('template.main')
@section('title') {{__('Upražnjena radna mjesta')}} @endsection

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('internotrziste.privremeni.premjestaj') => 'Privremeni premještaj',
    ]) !!}
@stop


@section('content')
    <div class="container">
        @include('ostalo/interno_trziste/fajlovi/menu')

        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var'  => $sluzbenici])
            <table id="filtering" class="table table-condensed table-bordered">
                <thead>
                <tr>
                    @include('template.snippets.filters_header')
                    <th width="120" class="text-center">{{__('Akcije')}}</th>
                </tr>
                </thead>
                <tbody>
                @php $counter = 1; @endphp
                @foreach($sluzbenici as $korisnik)
                    <tr>
                        <td>{{$counter++}}</td>
                        <td>
                            <a href="{{route('sluzbenik.dodatno', ['id' => $korisnik->id])}}">
                                {{$korisnik->ime_prezime ?? '/'}}
                            </a>
                        </td>
                        <td>
                            <a href="{{route('radnamjesta.pregledaj', ['id' => $korisnik->radnoMjesto->id ?? '/'])}}">
                                {{$korisnik->radnoMjesto->naziv_rm ?? '/'}}
                            </a>
                        </td>
                        <td>
                            <a href="{{route('radnamjesta.pregledaj', ['id' => $korisnik->privremeniPremjestajRel->privremeno_mjesto->id ?? '/'])}}">
                                {{$korisnik->privremeniPremjestajRel->privremeno_mjesto->naziv_rm ?? '/'}}
                            </a>
                        </td>
                        <td>{{$korisnik->privremeniPremjestajRel->broj_rjesenja ?? '/'}}</td>
                        <td>
                            @if(isset($korisnik->privremeniPremjestajRel))
                                {{$korisnik->privremeniPremjestajRel->datumRjesenja() }}
                            @endif
                        </td>
                        <td>@if(isset($korisnik->privremeniPremjestajRel))
                                {{$korisnik->privremeniPremjestajRel->datumOd() }}
                            @endif</td>
                        <td>@if(isset($korisnik->privremeniPremjestajRel))
                                {{$korisnik->privremeniPremjestajRel->datumDo() }}
                            @endif</td>
                        <td class="text-center">
                            <a href="{{route('ugovor.privremeno.edit', ['id' => $korisnik->privremeni_premjestaj])}}">
                                <button class="btn my-button">Pregled</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection