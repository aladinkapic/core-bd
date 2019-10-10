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


        <table class="table table-bordered low-padding" id="filtering">
            <thead>
            <tr>
                @include('template.snippets.filters_header')

                @if(!isset($prekobrojni))
                    <th scope="col" class="text-center">{{__('Rješenje')}}</th>
                @endif
                <th scope="col" class="text-center">{{__('Pregled')}}</th>

                <th>Rješenje</th>
                <th width="120px" class="text-center">Akcije</th>

            </tr>
            </thead>
            <tbody>


            @foreach($planovi as $plan)
                @foreach($plan->organizacioneJedinice as $orgJedinica)
                    @foreach($orgJedinica->radnaMjesta as $radnoMjesto)
                        @if(isset($prekobrojni))
                            @if($radnoMjesto->broj_izvrsilaca < $radnoMjesto->sluzbenici->count())
                                <tr>
                                    <td>
                                        {{$radnoMjesto->naziv_rm ?? '/'}}
                                    </td>
                                    <td>
                                        {{$orgJedinica->naziv ?? '/'}}
                                    </td>
                                    <td>
                                        {{$radnoMjesto->sifra_rm ?? '/'}}
                                    </td>
                                    <td>
                                        {{$radnoMjesto->broj_izvrsilaca ?? '/'}}
                                    </td>
                                    <td>
                                        {{$radnoMjesto->sluzbenici->count() ?? '/'}}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{route('internotrziste.sviprekobrojniljudi', ['id' => $radnoMjesto->id])}}"
                                           title="Pregled svih službenika na radnom mjestu">
                                            <i class="fa fa-eye" style="margin-left:10px;"></i> {{__('Pregled')}}
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                @endforeach

            @php $counter = 1; @endphp

            @foreach($radnaMjesta as $rm)
                @if($rm->broj_izvrsilaca >= $rm->sluzbeniciRel->count())
                    <tr>
                        <td>{{$counter++}}</td>
                        <td>{{$rm->naziv_rm}}</td>
                        <td>{{$rm->orgjed->naziv }}</td>
                        <td>{{$rm->orgjed->organizacija->organ->naziv}}</td>
                        <td>{{$rm->sifra_rm ?? '/'}}</td>
                        <td>{{$rm->broj_izvrsilaca ?? '/'}}</td>
                        <td>{{$rm->sluzbeniciRel->count()}}</td>
                        <td>

                            @if(isset($rm->sluzbeniciRel))
                                <ul class="custom-list">
                                    @foreach($rm->sluzbeniciRel as $sl)
                                        <a href="{{route('sluzbenik.dodatno', ['id' => $sl->sluzbenik->id])}}">
                                            <li>{{$sl->sluzbenik->ime_prezime}}</li>

                                        </a>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="#" title="Dodajte / uredite rješenje" class="rjesenje" data-id="{{ $rm->id ?? '1'}}" data-name="{{ $rm->naziv_rm ?? '/'}}">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="{{route('radnamjesta.rjesenje', ['id' => $rm->id, 'what' => 'true'])}}"
                               title="Pregledajte radno mjesto">
                                <button class="btn my-button">Pregled</button>
                            </a>
                        </td>
                    </tr>
                @endif
            @endforeach


{{--            @foreach($planovi as $plan)--}}
{{--                @foreach($plan->organizacioneJedinice as $orgJedinica)--}}
{{--                    @foreach($orgJedinica->radnaMjesta as $radnoMjesto)--}}
{{--                        @if(isset($prekobrojni))--}}
{{--                            @if($radnoMjesto->broj_izvrsilaca < $radnoMjesto->sluzbenici->count())--}}
{{--                                <tr>--}}
{{--                                    <td>{{$counter++}}</td>--}}
{{--                                    <td>--}}
{{--                                        {{$radnoMjesto->naziv_rm ?? '/'}}--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        {{$orgJedinica->naziv ?? '/'}}--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        {{$radnoMjesto->sifra_rm ?? '/'}}--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        {{$radnoMjesto->broj_izvrsilaca ?? '/'}}--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        {{$radnoMjesto->sluzbenici->count() ?? '/'}}--}}
{{--                                    </td>--}}
{{--                                    <td class="text-center">--}}
{{--                                        <a href="{{route('internotrziste.sviprekobrojniljudi', ['id' => $radnoMjesto->id])}}"--}}
{{--                                           title="Pregled svih službenika na radnom mjestu">--}}
{{--                                            <i class="fa fa-eye" style="margin-left:10px;"></i> Pregled--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endif--}}
{{--                        @elseif($radnoMjesto->broj_izvrsilaca >= $radnoMjesto->sluzbenici->count())--}}
{{--                            <tr>--}}
{{--                                <td>--}}
{{--                                    {{$radnoMjesto->naziv_rm ?? '/'}}--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    {{$orgJedinica->naziv ?? '/'}}--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    {{$radnoMjesto->sifra_rm ?? '/'}}--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    {{$radnoMjesto->broj_izvrsilaca ?? '/'}}--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    {{$radnoMjesto->sluzbenici->count() ?? '/'}}--}}
{{--                                </td>--}}
{{--                                <td class="text-center">--}}
{{--                                    <a href="#" title="Dodajte / uredite rješenje" class="rjesenje"--}}
{{--                                       data-id="{{ $radnoMjesto->id ?? '1'}}" data-name="{{ $radnoMjesto->naziv_rm ?? '/'}}">--}}
{{--                                        <i class="fas fa-edit"></i>--}}
{{--                                    </a>--}}
{{--                                </td>--}}
{{--                                <td class="text-center">--}}
{{--                                    <a href="{{route('radnamjesta.rjesenje', ['id' => $radnoMjesto->id, 'what' => 'true'])}}"--}}
{{--                                       title="Pregledajte radno mjesto">--}}
{{--                                        <i class="fa fa-eye" style="margin-left:10px;"></i>--}}
{{--                                    </a>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                @endforeach--}}
{{--            @endforeach--}}
            </tbody>
        </table>
    </div>
@endsection
