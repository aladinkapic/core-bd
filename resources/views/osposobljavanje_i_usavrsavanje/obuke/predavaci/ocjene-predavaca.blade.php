@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/osposobljavanje_i_usavrsavanje/obuke/home' => 'Katalog obuka',
    ]) !!}
@stop

@section('content')
    <div class="container">
        <div class="fine-header">
            <h4>Predavač : {{$instance[0]->imePredavaca->ime ?? '/'}} {{$instance[0]->imePredavaca->prezime ?? '/'}}</h4>

            <div class="buttons">
                <a href="">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-angle-left"></i>
                        </div>
                        <p>{{__('Nazad')}}</p>
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
                @php $i=1;  $ocjena = 0; @endphp
                @foreach($instance as $instanca)
                    @php $ocjena += ($instanca->ocjena ?? '0'); @endphp
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$instanca->instance->obuka->naziv ?? '/'}}</td>
                        <td>{{$instanca->instance->pocetakObuke() ?? '/'}}</td>
                        <td>{{$instanca->instance->krajObuke() ?? '/'}}</td>
                        <td>{{$instanca->ocjena ?? 'Nije ocijenjen'}}</td>
                        <td class="text-center" title="Pregled predavača">
                            <a href="">
                                <button class="btn my-button">Pregled</button>
                            </a>
                        </td>

                    </tr>

                @endforeach

                <tr>
                    <td>Prosjek</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{round($ocjena / ($i-1), 2)}}</td>
                    <td></td>

                </tr>
{{--                @foreach($instance as $instanca)--}}
{{--                    <tr class="org-row">--}}
{{--                        <td class="text-center">{{$i++}}</td>--}}
{{--                        <td>--}}
{{--                            {{$instanca -> pocetakObuke() ?? '/'}}--}}
{{--                        </td>--}}
{{--                        <td>{{$instanca -> krajObuke() ?? '/'}}</td>--}}
{{--                        <td>{{$instanca -> datumZatvaranja() ?? '/'}}</td>--}}
{{--                        <td>--}}
{{--                            {{$instanca -> status ?? '/'}}--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <ul class="custom-one-to-many">--}}
{{--                                @foreach($instanca->predavaci as $predavac)--}}
{{--                                    <li>{{$predavac->imePredavaca->ime ?? ''}}  {{$predavac->imePredavaca->prezime ?? ''}}</li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <ul class="custom-one-to-many">--}}
{{--                                @foreach($instanca->sluzbenici as $sluzbenik)--}}
{{--                                    <li>{{$sluzbenik->sluzbenik->ime_prezime ?? '/'}}</li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </td>--}}
{{--                        <td class="text-center">--}}
{{--                            <a href="{{route('pregledaj-instancu-obuke', ['id' => $instanca->id])}}">--}}
{{--                                <button class="btn my-button">Pregled</button>--}}
{{--                            </a>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
                </tbody>
            </table>
        </div>
    </div>
@endsection

