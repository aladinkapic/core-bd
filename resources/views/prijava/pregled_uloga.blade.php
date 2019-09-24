@extends('template.main')
@section('other_js_links')
    <script>
        app.items = {!! $sluzbenici !!};
    </script>
@endsection
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('izvjestaji.pregled.uloga') => 'Pregled korisnika sa ulogama',
    ]) !!}

@stop
@section('content')
    <div class="container">
        <div class="row" style=" margin-left:6px; width: calc(100% - 40px);">
            <div class="col-md-10" >
                <h4>Pregled korisnika sa ulogama</h4>
                <button v-on:click="fireTable()" class="btn btn-primary btn-xs"> <i class="fa fa-filter" style="font-size: 11px;"></i> Filteri</button>
            </div>
        </div>

        <div class="card-body hr-activity tab full_container">
            <table class="table table-bordered low-padding" id="filtering">
                <thead >
                <tr >
                    <th scope="col" width="40px;" style="text-align:center;">ID</th>
                    <th scope="col">Ime i prezime</th>
                    <th scope="col">Stručno zvanje</th>
                    <th scope="col">Radno mjesto</th>
                    <th scope="col" style="text-align:center;" width="220px;">Dodijelite uloge</th>
                </tr>
                </thead>
                <tbody>
                <tr class="sluzbenik-row" v-for="(sluzbenik, index) in items" v-bind:style=" index > 4 ? 'display: none;' : 'display: table-row;'">
                    <td scope="row" width="40px;" style="text-align:center;">@{{ sluzbenik.id }}</td>
                    <td>@{{ sluzbenik.ime }} @{{ sluzbenik.prezime }}</td>
                    <td>
                        <span v-if="sluzbenik.obrazovanje">
                            <span v-for="item in sluzbenik.obrazovanje">
                                @{{ item.strucno_zvanje }}
                            </span>
                        </span>
                    </td>
                    <td>
                        <span v-if="sluzbenik.radno_mjesto">
                            @{{ sluzbenik.radno_mjesto.naziv_rm || 'neee' }}
                        </span>
                    </td>
                    <td style="text-align:center;">
                        <div class="inside_cells">
                            <span class="custom_span" v-bind:custom_id="sluzbenik.id" v-bind:title="'Pogledajte uloge -' + ' ' + sluzbenik.ime + ' ' + sluzbenik.prezime">
                                Uredite <i style="margin-left:10px;" class="fas fa-angle-right"></i>
                            </span>
                            <div class="select_roles" v-bind:id="'show_roles' + sluzbenik.id">

                                @include('prijava.snippets')


                                {{--<div class="specific_role text-left">--}}
                                    {{--<p> Unutrašnja organizacija </p>--}}
                                    {{--<input type="checkbox" class="specific_role_value">--}}
                                {{--</div>--}}
                                {{--<div class="specific_role text-left">--}}
                                    {{--<p> Organ javne uprave </p>--}}
                                    {{--<input type="checkbox" class="specific_role_value">--}}
                                {{--</div>--}}
                                {{--<div class="specific_role text-left">--}}
                                    {{--<p> Službenici </p>--}}
                                    {{--<input type="checkbox" class="specific_role_value">--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
