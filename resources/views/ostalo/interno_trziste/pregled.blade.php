@extends('template.main')
@section('title') {{__('Upražnjena radna mjesta')}} @endsection

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('internotrziste.pregled') => __('Upražnjena radna mjesta'),
    ]) !!}

@stop

@section('content')
    <div class="container">
        @include('ostalo/interno_trziste/fajlovi/menu')

        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var'  => $radnaMjesta])
            <table class="table table-bordered low-padding" id="filtering">
                <thead>
                <tr>
                    @include('template.snippets.filters_header')

                    @if(!isset($prekobrojni))
                        <th scope="col" class="text-center">{{__('Rješenje')}}</th>
                    @endif
                    <th scope="col" class="text-center">{{__('Akcije')}}</th>
                </tr>
                </thead>
                <tbody>

                @php $counter = 1; @endphp

                @foreach($radnaMjesta as $radnoMjesto)
                    <tr class="radnoMjesto-row">
                        <td class="text-center">{{ $counter++}}</td>
                        <td>
                            {{ $radnoMjesto->naziv_rm ?? '/'}}
                        </td>
                        <td>
                            {{ $radnoMjesto->broj_izvrsilaca ?? '/'}}
                        </td>
                        <td>
                            {{ $radnoMjesto->uposleno ?? '/'}}
                        </td>
                        <td>
                            {{ $radnoMjesto->platni_razred ?? '/'}}
                        </td>
                        <td>
                            {{ $radnoMjesto->stepenSS->name ?? '/'}}
                        </td>
                        <td>
                            {{ $radnoMjesto->katgorijaa->name ?? '/'}}
                        </td>
                        <td>
                            {{ $radnoMjesto->orgjed->naziv ?? '/'}}
                        </td>
                        <td>
                            {{ $radnoMjesto->orgjed->organizacija->organ->naziv ?? '/' }}
                        </td>
                        <td>
                            {{ $radnoMjesto->kompetencijeRel->name ?? '/'}}
                        </td>
                        <td>
                            <ul class="custom-one-to-many">
                                @foreach($radnoMjesto->sluzbeniciRel as $sluzbenik)
                                    <li > {{ $sluzbenik->sluzbenik->ime_prezime }} </li>
                                @endforeach
                            </ul>

                        </td>

                        <td class="text-center akcije">
                            <a href="{{route('rm.pregledaj-radno-mjesto', ['id' => $radnoMjesto->id])}}"
                               title="Pregledajte radno mjesto">
                                <button class="btn my-button">{{__('Pregled')}}</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
