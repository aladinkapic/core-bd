@extends('template.main')
@section('other_js_links')
    <script>
        app.items = {!! $suspenzije !!};
        app.hidden_columns = [4, 5]
    </script>
@endsection

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('suspenzije.pregled') => __('Lista suspenzija'),
    ]) !!}

@stop


@section('content')
    <div class="container">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif

        @include('hr.disciplinska_odgovornost.fajlovi.menu')

        <div class="row" style=" margin-left:-4px; width: calc(100% + 0px);">
            <div class="col-md-10" >
                <h4 style="margin-left:8px;">Lista suspenzija</h4>
                <button v-on:click="fireTable()" class="btn btn-primary btn-xs" style="margin-left:10px;"> <i class="fa fa-filter" style=" font-size: 11px;"></i> Filteri</button>
                @include('snippets.buttons')
            </div>
            <div class="col-md-2">
                <button class="btn btn-success" onClick="window.location='/hr/disciplinska_odgovornost/unos_suspenzija';"> <i class="fa fa-plus fa-1x"></i> {{__('Unesite novu suspenziju')}}</button>
            </div>
        </div>

        <div class="card-body hr-activity tab full_container">
            <table class="table table-bordered low-padding" id="filtering">
                <thead>
                <tr>
                    <th>{{__('Službenik')}}</th>
                    <th>{{__('Radno mjesto')}}</th>
                    <th>{{__('Opis disciplinske mjere')}}</th>
                    <th>{{__('Broj rješenja')}}</th>
                    <th>{{__('Razlog udaljenja')}}</th>
                    <th>{{__('Datum udaljenja')}}</th>
                    <th scope="col" style="text-align:center;" class="akcije">{{__('Akcije')}}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(suspenzija, index) in items" v-bind:style=" index > 10 ? 'display: none;' : 'display: table-row;'">
                    <td>@{{ suspenzija.disciplinska_odgovornost.sluzbenik.ime }} @{{ suspenzija.disciplinska_odgovornost.sluzbenik.prezime }} </td>
                    <td>
                        <span v-if="suspenzija.disciplinska_odgovornost.radno_mjesto">
                            @{{ suspenzija.disciplinska_odgovornost.radno_mjesto.naziv_rm }}
                        </span>
                        <span v-else>
                            -
                        </span>
                    </td>
                    <td>
                        @{{ suspenzija.disciplinska_odgovornost.opis_disciplinske_mjere }}
                    </td>
                    <td>
                        @{{ suspenzija.broj_rjesenja }}
                    </td>
                    <td>
                        @{{ suspenzija.razlog_udaljenja}}
                    </td>
                    <td>
                        @{{ suspenzija.datum_udaljenja | formatDate }}
                    </td>
                    <td class="text-center akcije">
                        <a v-bind:href="'/hr/disciplinska_odgovornost/pregledajte_suspenzija/' + suspenzija.id" >
                            <i class="fa fa-eye"></i>
                        </a>
                        <a v-bind:href="'/hr/disciplinska_odgovornost/uredite_suspenzija/' + suspenzija.id" style="margin-left:10px;">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="#" style="margin-left:10px;" v-on:click.prevent="confirmText('Jeste li sigurni da želite ovu unutrašnju organizaciju za organ javne uprave  postaviti kao aktivnu? Izmjene će biti izmijenjene trenutno!', '#set-active' + suspenzija.id)">
                            <i class="fa fa-trash"></i>
                        </a>
                        <form method="GET" v-bind:id="'set-active' + suspenzija.id" v-bind:action="'/hr/disciplinska_odgovornost/obrisite_suspenziju/' + suspenzija.id">
                            @csrf
                        </form>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection