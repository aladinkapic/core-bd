@extends('template.main')

@section('other_js_links')
    <script src="{{ asset('js/organizacija.js') }}"></script>
@stop
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('organizacija.index') => __('Organizacioni planovi / Pravilnici'),
        route('organizacija.edit', ['id' => $organizacija->id]) => $organizacija->naziv,
        route('organizacija.radna-mjesta', ['id' => $organizacija->id]) => __('Radna mjesta'),
    ]) !!}

@stop
@section('content')

    <div class="container">
        @include('hr.organizacija.snippets.menu')

        <div class="fine-header">
            <h4>{{ $organizacija->naziv }}</h4>

            <div class="buttons">
                <a href="{{route('home')}}">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-angle-left"></i>
                        </div>
                        <p>{{__('Početna stranica')}}</p>
                    </div>
                </a>
            </div>
        </div>



        <div class="card-body hr-activity tab full_container" style="margin-top:20px;">
            @include('template.snippets.filters', ['var'  => $radna_mjesta])
            <div class="">
                <br />
                <table class="table table-bordered"  id="filtering">
                    <thead >
                    <tr >
                        @include('template.snippets.filters_header')
                        <th scope="col" class="text-center" width="120px">Akcije</th>
                    </tr>
                    </thead>
                    <tbody>

                    @php $i=1; @endphp

                    @foreach($radna_mjesta as $rm)
                        <tr>
                            <td scope="row" width="40px;" class="text-center">{{$i++}}</td>
                            <td>{{$rm->orgjed->naziv}}</td>
                            <td>{{$rm->naziv_rm ?? '/'}}</td>
                            <td>{{$rm->sifra_rm ?? '/'}}</td>
                            <td>{{$rm->katgorijaa->name ?? '/'}}</td>
                            <td>{{$rm->tipRadnogMjesta->name ?? '/'}}</td>
                            <td>{{$rm->opis_rm ?? '/'}}</td>
                            <td>{{$rm->broj_izvrsilaca ?? '/'}}</td>
                            <td>{{$rm->platni_razred ?? '/'}}</td>
                            <td>{{$rm->strucnaSprema->name ?? '/'}}</td>
{{--                            <td>{{$rm->tipPrivremenogPremjestaja->name ?? '/'}}</td>--}}

                            <td>

                                <ul>
                                    @foreach($rm->usloviRM as $uslov)
                                        <li>{{$uslov->tekst_uslova ?? '/'}}</li>
                                    @endforeach
                                </ul>
                            </td>

                            <td>
                                <ul>
                                    @foreach($rm->sluzbeniciRel as $sl)
                                        <li>{{$sl->sluzbenik->ime_prezime ?? '/'}}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="text-center">
                                <a href="/hr/radna_mjesta/pregledaj_radno_mjesto/{{$rm->id ?? '1'}}" title="Pregledajte radno mjesto">
                                    <i class="fa fa-eye" style="margin-right:10px;"></i>
                                </a>

                                <a href="/hr/radna_mjesta/uredi_radno_mjesto/{{$rm->id ?? '1'}}" title="Uredite radno mjesto">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <button class="btn btn-success" v-on:click="toggle('#dodaj')">
                <i class="fa fa-plus"></i> {{__('Dodaj radno mjesto')}}
            </button>

            <div id="dodaj" style="display: none;">
                @include('hr.radna_mjesta.fajlovi.dodaj')
            </div>
        </div>
    </div>
@stop
