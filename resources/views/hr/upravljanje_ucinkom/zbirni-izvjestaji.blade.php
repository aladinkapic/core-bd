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
                    <th class="text-center">#</th>
                    @include('template.snippets.filters_header')
                    <th class="akcije text-center" width="120px">{{__('Akcija')}}</th>
                </tr>
                </thead>
                <tbody>
                @php $counter=1; @endphp
                @foreach($jedinice as $jedinica)
                    <tr>
                        <td>{{$counter++}}</td>
                        <td>
                            {{$jedinica->organizacija->organ->naziv ?? '/'}}
                        </td>
                        <td>{{$jedinica->naziv}}</td>
                        <td>2019</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center">
                            <a href="#">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection