@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('ugovor.index') => 'Radni status i raspored na radno mjesto',
    ]) !!}

@stop
@section('content')


    <div class="container">

        @include('hr.ugovori.snippets.menu')
        <hr/>
        <br/>
        <div class="row">
            <div class="col-md-10">
                <h4>{{__('Radni status i raspored na radno mjesto')}}</h4>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success" style="float:right;"
                        v-on:click="url('{{ route('ugovor.radni_status.create') }}')"><i class="fa fa-plus fa-1x"></i>
                    {{__('Novi unos')}}
                </button>
            </div>
        </div>

        <br/>
        <br/>

        @if(isset($success))
            <div class="alert alert-success">{{ $success }}</div>
        @endif

        @include('template.snippets.filters', ['var'  => $ugovori])

        <table id="filtering" class="table table-condensed table-bordered">
            <thead>
            <tr>
                <th class="text-center">#</th>
                @include('template.snippets.filters_header')
                <th class="akcije text-center" width="120px">{{__('Akcije')}}</th>
            </tr>
            </thead>
            <tbody>
            @php $counter = 1; @endphp
            @foreach($ugovori as $ugovor)
                <tr>
                    <td class="text-center">{{$counter++}}</td>
                    <td>{{$ugovor->broj ?? '/'}}</td>
                    <td>{{$ugovor->usluzbenik->ime_prezime ?? ''}}</td>
                    <td>{{$ugovor->datumUgovora() ?? '/'}}</td>
                    <td>{{$ugovor->datumIsteka() ?? '/'}}</td>
                    <td>{{$ugovor->datumIstekaProbni() ?? '/'}}</td>
                    <td>{{$ugovor->broj_sati ?? '/'}}</td>
                    <td style="text-align:center;" class="akcije">
                        <a href="{{ '/ugovori/radni-status/edit/' . $ugovor->id ?? '1'}}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{ '/ugovori/radni-status/destroy/' . $ugovor->id ?? '1'}}"
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