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
            <h4>{{__('Radni status i raspored na radno mjesto')}}</h4>

            <div class="buttons">
                <a href="{{route('home')}}" title="Nazad">
                    <div class="small-button small-button-border small-button-edit">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </a>
                <a href="{{route('ugovor.radni_status.create')}}">
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

            <table class="table table-bordered low-padding" id="filtering">
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
                        <td>
                            <a href="{{route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $ugovor->sluzbenik ?? ''])}}">
                                {{$ugovor->usluzbenik->ime_prezime ?? ''}}
                            </a>
                        </td>
                        <td>{{$ugovor->usluzbenik->sluzbenikRel->rm->naziv_rm ?? ''}}</td>
                        <td>{{$ugovor->usluzbenik->sluzbenikRel->rm->orgjed->organizacija->organ->naziv ?? ''}}</td>
                        <td>{{$ugovor->radnoMjesto->naziv_rm ?? ''}}</td>
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
    </div>
@stop
