@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('ugovor.index') => __('Radni status i raspored na radno mjesto'),
    ]) !!}

@stop
@section('content')
    <div class="container">
        @include('hr.ugovori.snippets.menu')
        <div class="fine-header">
            <h4>{{__('Mjesto rada državnog službenika')}}</h4>

            <div class="buttons">
                <a href="{{route('home')}}" title="Nazad">
                    <div class="small-button small-button-border small-button-edit">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </a>
                <a href="{{route('ugovor.mjesto_rada.create')}}">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-plus-square"></i>
                        </div>
                        <p>{{__('Novi ugovor / odluka')}}</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="card-body hr-activity tab full_container">
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
                        <td>{{$ugovor->usluzbenik->ime_prezime ?? ''}}</td>
                        <td>{{$ugovor->adresa ?? '/'}}</td>
                        <td>{{$ugovor->sprat ?? '/'}}</td>
                        <td>{{$ugovor->broj_kancelarije}}</td>
                        <td>{{$ugovor->sluzbeno_autoq->name ?? ''}}</td>
                        <td>{{$ugovor->povjerena_stalna_sredstva ?? '/'}}</td>
                        <td>{{$ugovor->rm->naziv_rm ?? ''}}</td>
                        <td style="text-align:center;" class="akcije">
                            <a href="{{ '/ugovori/mjesto-rada/edit/' . $ugovor->id ?? '1'}}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ '/ugovori/mjesto-rada/destroy/' . $ugovor->id ?? '1'}}"
                               style="margin-left:10px;">
                                <i class="fa fa-times"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
