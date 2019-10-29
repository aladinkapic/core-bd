@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('radna.mjesta.sve') => 'Pregled svih radnih mjesta',
    ]) !!}

@stop

@section('content')
    <div class="container">
        <div class="fine-header">
            <h4>{{__('Lista radnih mjesta')}}</h4>

            <div class="buttons">
                <a href="{{route('home')}}">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-angle-left"></i>
                        </div>
                        <p>{{__('Nazad')}}</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="row" style=" margin-left:6px; width: calc(100% - 40px);">
            <div class="col-md-10">
                <h4>{{__('')}}</h4>

            </div>
        </div>
        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var' => $radna_mjesta])
            <table class="table table-bordered" id="filtering">
                <thead>
                <tr>
                    <th scope="col" style="text-align:center;">#</th>
                    @include('template.snippets.filters_header')
                    <th scope="col" style="text-align:center;" class="akcije">{{__('Akcije')}}</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1; @endphp
                @foreach($radna_mjesta as $radnoMjesto)
                    <tr class="radnoMjesto-row">
                        <td class="text-center">{{ $i++}}</td>
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
                            {{ $radnoMjesto->orgjed->naziv ?? ''}}
                        </td>
                        <td>
                            {{ $radnoMjesto->orgjed->organizacija->organ->naziv ?? '' }}
                        </td>
                        <td>
                            {{ $radnoMjesto->rukovodeca_pozicija->name ?? ''}}
                        </td>
                        <td>
                            <ul class="custom-one-to-many">
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