@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        '/osposobljavanje_i_usavrsavanje/obuke/home' => __('Katalog obuka'),
    ]) !!}
@stop

@section('content')
    <div class="container">
        <div class="fine-header">
            <h4>{{__('Katalog obuka')}}</h4>

            <div class="buttons">
                <a href="{{route('home')}}" title="Nazad">
                    <div class="small-button small-button-border small-button-edit">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </a>
                <a href="/osposobljavanje_i_usavrsavanje/obuke/add">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-plus-square"></i>
                        </div>
                        <p>{{__('Dodaj novu obuku')}}</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var'  => $obuke])
            <table id="filtering" class="table table-condensed table-bordered">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    @include('template.snippets.filters_header')
                    <th class="text-center" width="150">{{__('Akcije')}}</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1; @endphp
                @foreach($obuke as $obuka)
                    <tr class="org-row">
                        <td class="text-center">{{$i++}}</td>
                        <td>{{$obuka -> naziv ?? '/'}}</td>
                        <td>{{$obuka -> vrsta ?? '/'}}</td>
                        <td>{{$obuka->organizator ?? '/'}}</td>
                        <td> {{$obuka->broj_polaznika ?? '/'}}</td>
                        <td>
                            <ul class="custom-one-to-many">
                                @foreach($obuka->instance as $instanca)
                                    <li>
                                        <a href="/osposobljavanje_i_usavrsavanje/obuke/prikazInstance/{{$instanca->id}}">
                                            {{$instanca->pocetak_obuke.' - '.$instanca->kraj_obuke}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="text-center">
                            <a href="/osposobljavanje_i_usavrsavanje/obuke/addInstancu/{{$obuka -> id ?? '1'}}"
                               title="Dodaj instancu obuke">
                                <i class="fas fa-plus"></i>
                            </a>
                            @if (count($obuka->instance))
                                <a href="{{route('pregled-instanci-obuke', ['id' => $obuka->id])}}" title="Pregledaj sve instance obuke" style="margin-left:10px;">
                                    <i class="fas fa-list-ul"></i>
                                </a>
                            @endif
                            <a href="{{route('pregled-obuke', ['id' => $obuka->id ?? '1'])}}"
                               style="margin-left:10px;">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{route('uredi-obuku', ['id' => $obuka->id])}}"
                               style="margin-left:10px;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="/osposobljavanje_i_usavrsavanje/obuke/delete/{{$obuka -> id ?? '1'}}"
                               style="margin-left:5px;">
                                <i class="fas fa-times"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

