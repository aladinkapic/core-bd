@extends('template.main')
@section('title') {{__('Upražnjena radna mjesta')}} @endsection

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('internotrziste.pregled') => __('Upražnjena radna mjesta'),
    ]) !!}

@stop

@section('content')
    <div class="container">
        @include('ostalo/interno_trziste/fajlovi/menu')

        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var'  => $radnaMjesta])
            <table class="table table-bordered low-padding" id="filtering">
                <thead>
                <tr>
                    @include('template.snippets.filters_header')
                    <th width="120px" class="text-center">{{__('Akcije')}}</th>
                </tr>
                </thead>
                <tbody>

                @php $counter = 1; @endphp

                @foreach($radnaMjesta as $rm)
                    @if($rm->broj_izvrsilaca < $rm->sluzbeniciRel->count())

                        <tr>
                            <td>{{$counter++}}</td>
                            <td>{{$rm->naziv_rm}}</td>
                            <td>{{$rm->orgjed->naziv }}</td>
                            <td>{{$rm->orgjed->organizacija->organ->naziv}}</td>
                            <td>{{$rm->sifra_rm ?? '/'}}</td>
                            <td>{{$rm->broj_izvrsilaca ?? '/'}}</td>
                            <td>{{$rm->sluzbeniciRel->count()}}</td>
                            <td class="text-center">
                                <a href="{{route('radnamjesta.rjesenje', ['id' => $rm->id, 'what' => 'true'])}}"
                                   title="Pregledajte radno mjesto">
                                    <button class="btn my-button">{{__('Pregled')}}</button>
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
