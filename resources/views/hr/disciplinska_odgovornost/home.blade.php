@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/hr/disciplinska_odgovornost/home' => 'Lista disciplinskih odgovornosti',
    ]) !!}

@stop


@section('content')
    <div class="container">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br/>
        @endif

        @include('hr.disciplinska_odgovornost.fajlovi.menu')

        <div class="row" style=" margin-left:-4px; width: calc(100% - 40px);">
            <div class="col-md-10">
                <h4 style="margin-left:8px;">{{__('Lista disciplinskih odgovornosti')}}</h4>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success" onClick="window.location='/hr/disciplinska_odgovornost/add';"><i
                            class="fa fa-plus fa-1x"></i> {{__('Nova disciplinska odgovornost')}}</button>
            </div>
        </div>

        <br/>

        @if(isset($success))
            <div class="alert alert-success">{{ $success }}</div>
        @endif

        @include('template.snippets.filters', ['var'  => $odgovornosti])


        <table id="filtering" class="table table-condensed table-bordered">
            <thead>
            <tr>
                <th class="text-center">#</th>
                @include('template.snippets.filters_header')
                <th style="text-align:center;" class="akcije" style="width: 15%;">{{__('Akcija')}}</th>
            </tr>
            </thead>
            <tbody>
            @php $i=1; @endphp
            @foreach($odgovornosti as $odgovornost)
                <tr>
                    <td class="text-center">{{$i++}}</td>
                    <td>{{$odgovornost->sluzbenik->ime_prezime ?? ''}}</td>
                    <td>{{$odgovornost->sluzbenik->radnoMjesto->naziv_rm ?? ''}}</td>
                    <td>{{$odgovornost->datumPovrede() ?? '/'}}</td>
                    <td>{{$odgovornost->opis_povrede ?? '/'}}</td>
                    <td>{{$odgovornost->opis_disciplinske_mjere ?? '/'}}</td>
                    <td>{{$odgovornost->broj_rjesenja_zabrane ?? '/'}}</td>
                    <td>{{$odgovornost->datumZabrane() ?? '/'}}</td>
                    <td>{{$odgovornost->datumZavrsetka() ?? '/'}}</td>

                    <td class="text-center">
                        <a href="{{Route('disciplinska.pregledaj', ['id' => $odgovornost->id ?? '1'])}}"
                           title="Pregledajte disciplinsku odgovornost">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{Route('disciplinska.uredite', ['id' => $odgovornost->id ?? '1'])}}" style="margin-left:10px;"
                           title="Uredite  disciplinsku odgovornost">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ '/hr/disciplinska_odgovornost/obrisi/' . $odgovornost->id ?? '1'}}"
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
{{--<th>{{__('Datum povrede')}}</th>--}}
{{--<th>{{__('Opis povrede')}}</th>--}}
{{--<th>{{__('Opis disciplinske mjere')}}</th>--}}
{{--<th>{{__('Broj rješenja zabrane')}}</th>--}}
{{--<th>{{__('Datum rješenja zabrane')}}</th>--}}
{{--<th>{{__('Datum završetka zabrane')}}</th>--}}
{{--<th scope="col" style="text-align:center;">{{__('Akcije')}}</th>--}}
{{--</tr>--}}
{{--</thead>--}}
{{--<tbody>--}}
{{--<tr v-for="(odgovornost, index) in items" v-bind:style=" index > 10 ? 'display: none;' : 'display: table-row;'">--}}
{{--<td>--}}
{{--<span v-if="odgovornost.sluzbenik">--}}
{{--@{{ odgovornost.sluzbenik.ime }} @{{ odgovornost.sluzbenik.prezime }}--}}
{{--</span>--}}
{{--<span v-else>-</span>--}}
{{--</td>--}}
{{--<td>--}}
{{--<span v-if="odgovornost.sluzbenik.radno_mjesto">--}}
{{--@{{ odgovornost.sluzbenik.radno_mjesto_naziv_rm }}--}}
{{--</span>--}}
{{--<span v-else>-</span>--}}
{{--</td>--}}
{{--<td> @{{ odgovornost.datum_povrede }} </td>--}}
{{--<td> @{{ odgovornost.opis_povrede }} </td>--}}
{{--<td> @{{ odgovornost.opis_disciplinske_mjere }} </td>--}}
{{--<td> @{{ odgovornost.datum_rjesenja_zabrane }} </td>--}}
{{--<td> @{{ odgovornost.broj_rjesenja_zabrane }} </td>--}}
{{--<td> @{{ odgovornost.datum_zavrsetka_zabrane }} </td>--}}
{{--<td class="text-center akcije">--}}
{{--<a v-bind:href="'/hr/disciplinska_odgovornost/pregledajte_suspenzija/' + odgovornost.id" >--}}
{{--<i class="fa fa-eye"></i>--}}
{{--</a>--}}
{{--<a v-bind:href="'/hr/disciplinska_odgovornost/uredite_suspenzija/' + odgovornost.id" style="margin-left:10px;">--}}
{{--<i class="fa fa-edit"></i>--}}
{{--</a>--}}
{{--<a href="#" style="margin-left:10px;" v-on:click.prevent="confirmText('Jeste li sigurni da želite obrisati ovu žalbu? Izmjene će biti primijenjene trenutno!', '#set-active' + odgovornost.id)">--}}
{{--<i class="fa fa-trash"></i>--}}
{{--</a>--}}
{{--<form method="GET" v-bind:id="'set-active' + odgovornost.id" v-bind:action="'/hr/disciplinska_odgovornost/obrisi/' + odgovornost.id">--}}
{{--@csrf--}}
{{--</form>--}}
{{--</td>--}}
{{--</tr>--}}



{{--@foreach($odgovornosti as $odgovornost)--}}
{{--<tr>--}}
{{--<td>{{$odgovornost -> sluzbenik->ime}} {{$odgovornost -> sluzbenik->prezime}}</td>--}}
{{--<td>--}}
{{--@if($odgovornost -> sluzbenik->radnoMjesto)--}}
{{--{{$odgovornost -> sluzbenik->radnoMjesto->naziv_rm}}--}}
{{--@else--}}
{{-----}}
{{--@endif--}}
{{--</td>--}}
{{--<td>{{$odgovornost -> opis_disciplinske_mjere}}</td>--}}
{{--<td>{{$odgovornost -> datum_rjesenja_zabrane}}</td>--}}
{{--<td class="text-center">--}}
{{--<a href="{{Route('disciplinska.pregledaj', ['id' => $odgovornost->id])}}" title="Pregledajte disciplinsku odgovornost">--}}
{{--<i class="fas fa-eye"></i>--}}
{{--</a>--}}
{{--<a href="{{Route('disciplinska.uredite', ['id' => $odgovornost->id])}}" title="Uredite  disciplinsku odgovornost">--}}
{{--<i class="fas fa-edit"></i>--}}
{{--</a>--}}
{{--<a href="" title="Obrišite disciplinsku odgovornost">--}}
{{--<i class="fas fa-trash"></i>--}}
{{--</a>--}}
{{--</td>--}}
{{--</tr>--}}
{{--@endforeach--}}
