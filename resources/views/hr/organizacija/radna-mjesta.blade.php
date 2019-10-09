@extends('template.main')

@section('other_js_links')
    <script src="{{ asset('js/organizacija.js') }}"></script>
@stop
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('organizacija.index') => 'Unutrašnja organizacija',
        route('organizacija.edit', ['id' => $organizacija->id]) => $organizacija->naziv,
        route('organizacija.radna-mjesta', ['id' => $organizacija->id]) => 'Radna mjesta',
    ]) !!}

@stop
@section('content')

    <div class="container">

        <h4>{{ $organizacija->naziv }}</h4>



        <div class="row">
            <div class="col-md-12">
                @include('hr.organizacija.snippets.menu')

                @include('template.snippets.filters', ['var'  => $radna_mjesta])

                <div class="">
                    <br />
                    <table class="table table-bordered"  id="filtering">
                        <thead >
                        <tr >
                            @include('template.snippets.filters_header')
                            <th scope="col" class="text-center">Akcije</th>
                        </tr>
                        </thead>
                        <tbody>

                        @php $i=1; @endphp

                        @foreach($radna_mjesta as $rm)
                            <tr>
                                <td scope="row" width="40px;" class="text-center">{{$i++}}</td>
                                <td>
                                    {{$rm->naziv_rm ?? '/'}}
                                </td>
                                <td>
                                    {{$rm->sifra_rm ?? '/'}}
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
                    <div class="text-center">
                        {{--{!! $radna_mjesta->links(); !!}--}}
                    </div>
                    <br />
                    <br />
                </div>

                <button class="btn btn-success" v-on:click="toggle('#dodaj')">
                    <i class="fa fa-plus"></i> Dodaj radno mjesto
                </button>

                <div id="dodaj" style="display: none;">
                    @include('hr.radna_mjesta.fajlovi.dodaj')
                </div>
            </div>
            <div class="col-md-3">

{{--                @include('hr.organizacija.snippets.sidebar')--}}

            </div>
        </div>
    </div>


@stop