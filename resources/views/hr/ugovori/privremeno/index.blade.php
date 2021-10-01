@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('ugovor.privremeno.index') => __('Privremeni premještaj'),
    ]) !!}

@stop
@section('content')


    <div class="container">

        @include('hr.ugovori.snippets.menu')
        <div class="fine-header">
            <h4>{{__('Privremeni premještaj')}}</h4>

            <div class="buttons">
                <a href="{{route('home')}}" title="Nazad">
                    <div class="small-button small-button-border small-button-edit">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </a>
                <a href="{{route('ugovor.privremeno.create')}}">
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
                        <td><a href="{{route('drzavni-sluzbenici.pregled-sluzbenika', ['id_sluzbenika'=>$ugovor->sluzbenik])}}">{{$ugovor->usluzbenik->ime_prezime ?? ''}}</a></td>
                        <td><a href="{{route('radnamjesta.pregledaj', ['id'=>$ugovor->mjesto->id ?? '1'])}}">{{$ugovor->mjesto->naziv_rm ?? ''}}</a></td>
                        <td>{{$ugovor->privremeno_mjesto->naziv_rm ?? ''}}</td>
                        <td>{{$ugovor->broj_rjesenja ?? '/'}}</td>
                        <td>{{$ugovor->datumRjesenja() ?? '/'}}</td>
                        <td>{{$ugovor->datumOd() ?? '/'}}</td>
                        <td>{{$ugovor->datumDo() ?? '/'}}</td>
                        <td style="text-align:center;" class="akcije">
                            <a href="{{ '/ugovori/privremeno/edit/' . $ugovor->id ?? '1'}}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ '/ugovori/privremeno/destroy/' . $ugovor->id ?? '1'}}"
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
