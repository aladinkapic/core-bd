@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('radna.mjesta.sve') => 'Pregled svih radnih mjesta',
    ]) !!}

@stop

@section('content')
    <div class="container">
        <div class="row" style=" margin-left:6px; width: calc(100% - 40px);">
            <div class="col-md-10">
                <h4>Lista radnih mjesta</h4>

            </div>
        </div>
        @include('template.snippets.filters', ['var' => $radna_mjesta])
        <div class="card-body hr-activity tab full_container">
            <table class="table table-bordered" id="filtering">
                <thead>
                <tr>
                    @include('template.snippets.filters_header')
                    <th scope="col" style="text-align:center;" class="akcije">Akcije</th>
                </tr>
                </thead>
                <tbody>
                @foreach($radna_mjesta as $radnoMjesto)
                    <tr class="radnoMjesto-row">
                        <td scope="col" width="40px;" class="text-center">{{ $radnoMjesto->id ?? '1'}}</td>
                        <td>
                            {{ $radnoMjesto->naziv_rm ?? '/'}}
                        </td>
                        <td>
                            {{ $radnoMjesto->sifra_rm ?? '/'}}
                        </td>
                        <td>
                            {{ $radnoMjesto->broj_izvrsilaca ?? '/'}}
                        </td>
                        <td>
                            {{ $radnoMjesto->orgjed->organizacija->organ->naziv ?? '' }}
                        </td>
                        <td>
                            {{ $radnoMjesto->orgjed->naziv ?? ''}}
                        </td>
                        <td>
                            {{ $radnoMjesto->rukovodeca_pozicija->name ?? ''}}
                        </td>
                        <td>
                            <ul>
                                @foreach($radnoMjesto->sluzbenici as $sluzbenik)
                                    <li > {{ $sluzbenik->ime_prezime }} </li>
                                @endforeach
                            </ul>

                        </td>

                        <td class="text-center akcije">
                            <a href="/hr/radna_mjesta/pregledaj_radno_mjesto/{{ $radnoMjesto->id ?? '1'}}"
                               title="Pregledajte radno mjesto">
                                <i class="fa fa-eye" style="margin-right:10px;"></i>
                            </a>

                            <a href="/hr/radna_mjesta/uredi_radno_mjesto/{{ $radnoMjesto->id ?? '1'}}"
                               title="Uredite radno mjesto">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection