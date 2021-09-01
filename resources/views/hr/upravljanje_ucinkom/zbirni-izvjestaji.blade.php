@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('upravljanje-ucinkom-pregled') => 'Upravljanje učinkom',
        route('upravljanje-ucinkom.pregled-izvjestaja') => 'Izvještaji'
    ]) !!}
@stop


@section('content')
    <div class="container">
        <div class="fine-header">
            <h4>{{__('Izvještaji')}}</h4>

            <div class="buttons">
                <a href="{{route('home')}}" title="Nazad">
                    <div class="small-button small-button-border small-button-edit">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </a>
                <a href="/hr/upravljanje_ucinkom/add">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-plus-square"></i>
                        </div>
                        <p>{{__('Izvršite ocjenjivanje')}}</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var'  => $jedinice])
            <table id="filtering" class="table table-condensed table-bordered">
                <thead>
                <tr>
                    <th class="text-center align-middle">#</th>
                    <th class="align-middle">Organ javne uprave</th>
                    <th class="align-middle">Organizaciona jedinica</th>
                    <th width="100px" class="align-middle text-center">Godina</th>
                    <th width="150px" class="text-center">Ne zadovoljava očekivanja</th>
                    <th width="150px" class="text-center">Zadovoljava očekivanja</th>
                    <th width="150px" class="text-center">Nadmašuje očekivanja</th>
                    <th width="150px" class="text-center">UKUPNO OCJENJENIH</th>
                </tr>
                </thead>
                <tbody>
                @php $counter=1; @endphp
                @foreach($jedinice as $jedinica)
                    @if(isset($jedinica->orgJedinica->organizacija->organ->naziv))
                        <tr>
                            <td>{{$counter++}}</td>
                            <td>
                                {{$jedinica->orgJedinica->organizacija->organ->naziv ?? '/'}}
                            </td>
                            <td>{{$jedinica->orgJedinica->naziv ?? '/'}}</td>
                            <td class="text-center">{{$jedinica->godina}}</td>
                            <td class="text-center layer-td" style="padding:0px;">
                                <div class="top-layer">
                                    {{$jedinica->ne_zadovoljava}}
                                </div>
                                <div class="bottom-layer">
                                    {{$jedinica->postotakNeZadovoljava()}}%
                                </div>
                            </td>
                            <td class="text-center layer-td" style="padding:0px;">
                                <div class="top-layer">
                                    {{$jedinica->zadovoljava}}
                                </div>
                                <div class="bottom-layer">
                                    {{$jedinica->postotakZadovoljava()}}%
                                </div>
                            </td>
                            <td class="text-center layer-td" style="padding:0px;">
                                <div class="top-layer">
                                    {{$jedinica->nadmasuje}}
                                </div>
                                <div class="bottom-layer">
                                    {{$jedinica->postotakNadmasuje()}}%
                                </div>
                            </td>
                            <td class="text-center layer-td" style="padding:0px;">
                                <div class="top-layer">
                                    {{$jedinica->ukupno}}
                                </div>
                                <div class="bottom-layer">
                                    100%
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
