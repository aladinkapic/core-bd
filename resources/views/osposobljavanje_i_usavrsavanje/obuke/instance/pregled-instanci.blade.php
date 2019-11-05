@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/osposobljavanje_i_usavrsavanje/obuke/home' => 'Katalog obuka',
        route('pregled-instanci-obuke', ['id' => $id ?? '1']) => 'Pregled instanci obuke'
    ]) !!}
@stop

@section('content')
    <div class="container">
        <div class="fine-header">
            <h4>{{__('Pregled instanci obuke')}}</h4>

            <div class="buttons">
                <a href="{{route('sve-obuke')}}" title="Nazad">
                    <div class="small-button small-button-border small-button-edit">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </a>
                <a href="{{route('dodaj-instancu-obuke', ['id' => $id])}}">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-plus"></i>
                        </div>
                            <p>{{__('Dodajte novu instancu')}}</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var'  => $instance])
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
                @foreach($instance as $instanca)
                    <tr class="org-row">
                        <td class="text-center">{{$i++}}</td>
                        <td>
                            <ul class="custom-one-to-many">
                                <li>
                                    Od : {{$instanca -> pocetak_obuke ?? '/'}}
                                </li>
                                <li>
                                    Do : {{$instanca -> kraj_obuke ?? '/'}}
                                </li>
                            </ul>
                        </td>
                        <td>
                            {{$instanca -> status ?? '/'}}
                        </td>
                        <td>{{$instanca -> datum_zatvaranja ?? '/'}}</td>
                        <td>
                            <ul class="custom-one-to-many">
                                @foreach($instanca->predavaci as $predavac)
                                    <li>{{$predavac->imePredavaca->ime ?? ''}}  {{$predavac->imePredavaca->prezime ?? ''}}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td></td>
                        <td class="text-center">
                            <a href="{{route('pregledaj-instancu-obuke', ['id' => $instanca->id])}}">
                                <button class="btn my-button">Pregled</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

