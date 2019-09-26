@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('zalbe.pregled') => __('Lista žalbi'),
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
                <h4 style="margin-left:8px;">Lista žalbi</h4>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success" onClick="window.location='/hr/disciplinska_odgovornost/unos_zalbe';"> <i class="fa fa-plus fa-1x"></i> {{__('Unesite novu žalbu')}}</button>
            </div>
        </div>

            <br />

            @include('template.snippets.filters', ['var'  => $zalbe])


            <table id="filtering" class="table table-condensed table-bordered">
                <thead>
                <tr>
                    @include('template.snippets.filters_header')
                    <th style="text-align:center;" class="akcije" style="width: 15%;">{{__('Akcija')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($zalbe as $zalba)
                    <tr>
                        <td>{{$zalba->disciplinskaOdgovornost->sluzbenik->ime_prezime ?? ''}}</td>
                        <td>{{$zalba->disciplinskaOdgovornost->sluzbenik->radnoMjesto->naziv_rm ?? ''}}</td>
                        <td>{{$zalba->disciplinskaOdgovornost->opis_disciplinske_mjere ?? ''}}</td>
                        <td>{{$zalba->broj_ulozene_zalbe}}</td>
                        <td>{{$zalba->datum_ulozene_zalbe}}</td>
                        <td>{{$zalba->broj_odluke_zalbe}}</td>
                        <td>{{$zalba->datum_odluke_zalbe}}</td>
                        <td style="text-align:center;" class="akcije">
                            <a href="{{ '/hr/disciplinska_odgovornost/pregledajte_zalbu/' . $zalba->id }}" style="margin-left:10px;">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ '/hr/disciplinska_odgovornost/uredite_zalbu/' . $zalba->id }}" style="margin-left:10px;">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ '/hr/disciplinska_odgovornost/obrisite_zalbu/' . $zalba->id }}"
                               style="margin-left:10px;">
                                <i class="fa fa-times"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
@stop
        {{--<div class="card-body hr-activity tab full_container">--}}
            {{--<table class="table table-bordered low-padding" id="filtering">--}}
                {{--<thead>--}}
                {{--<tr>--}}
                    {{--<th>{{__('Službenik')}}</th>--}}
                    {{--<th>{{__('Radno mjesto')}}</th>--}}
                    {{--<th>{{__('Opis disciplinske mjere')}}</th>--}}
                    {{--<th>{{__('Broj uložene žalbe')}}</th>--}}
                    {{--<th>{{__('Datum uložene žalbe')}}</th>--}}
                    {{--<th>{{__('Broj odluke žalbe')}}</th>--}}
                    {{--<th>{{__('Datum odluke žalbe')}}</th>--}}
                    {{--<th scope="col" style="text-align:center;" class="akcije">{{__('Akcije')}}</th>--}}
                {{--</tr>--}}
                {{--</thead>--}}
                {{--<tbody>--}}
                {{--<tr v-for="(zalba, index) in items" v-bind:style=" index > 10 ? 'display: none;' : 'display: table-row;'">--}}
                    {{--<td>--}}
                        {{--<span v-if="zalba.disciplinska_odgovornost.sluzbenik">--}}
                            {{--@{{ zalba.disciplinska_odgovornost.sluzbenik.ime }} @{{ zalba.disciplinska_odgovornost.sluzbenik.prezime }}--}}
                        {{--</span>--}}
                        {{--<span v-else>--}}

                        {{--</span>--}}
                    {{--</td>--}}
                    {{--<td>--}}
                        {{--<span v-if="zalba.disciplinska_odgovornost.radno_mjesto">--}}
                            {{--@{{ zalba.disciplinska_odgovornost.radno_mjesto.naziv_rm }}--}}
                        {{--</span>--}}
                        {{--<span v-else>--}}
                            {{-----}}
                        {{--</span>--}}
                    {{--</td>--}}
                    {{--<td>--}}
                        {{--@{{ zalba.disciplinska_odgovornost.opis_disciplinske_mjere }}--}}
                    {{--</td>--}}
                    {{--<td>--}}
                        {{--@{{ zalba.broj_ulozene_zalbe }}--}}
                    {{--</td>--}}
                    {{--<td>--}}
                        {{--@{{ zalba.datum_ulozene_zalbe | formatDate}}--}}
                    {{--</td>--}}
                    {{--<td>--}}
                        {{--@{{ zalba.broj_odluke_zalbe }}--}}
                    {{--</td>--}}
                    {{--<td>--}}
                        {{--@{{ zalba.datum_odluke_zalbe | formatDate }}--}}
                    {{--</td>--}}
                    {{--<td class="text-center akcije">--}}
                        {{--<a v-bind:href="'/hr/disciplinska_odgovornost/pregledajte_zalbu/' + zalba.id" >--}}
                            {{--<i class="fa fa-eye"></i>--}}
                        {{--</a>--}}
                        {{--<a v-bind:href="'/hr/disciplinska_odgovornost/uredite_zalbu/' + zalba.id" style="margin-left:10px;">--}}
                            {{--<i class="fa fa-edit"></i>--}}
                        {{--</a>--}}
                        {{--<a href="#" style="margin-left:10px;" v-on:click.prevent="confirmText('Jeste li sigurni da želite obrisati ovu žalbu? Izmjene će biti primijenjene trenutno!', '#set-active' + zalba.id)">--}}
                            {{--<i class="fa fa-trash"></i>--}}
                        {{--</a>--}}
                        {{--<form method="GET" v-bind:id="'set-active' + zalba.id" v-bind:action="'/hr/disciplinska_odgovornost/obrisite_zalbu/' + zalba.id">--}}
                            {{--@csrf--}}
                        {{--</form>--}}
                    {{--</td>--}}
                {{--</tr>--}}
                {{--</tbody>--}}
            {{--</table>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@endsection--}}