@extends('template.main')
@section('title') {{__('Upražnjena radna mjesta')}} @endsection

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('internotrziste.privremeni.premjestaj') => __('Privremeni premještaj'),
    ]) !!}
@stop


@section('content')
    <div class="container">
        @include('ostalo/interno_trziste/fajlovi/menu')

        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var'  => $ugovori])
            <table id="filtering" class="table table-condensed table-bordered">
                <thead>
                <tr>
                    @include('template.snippets.filters_header')
                    <th width="120" class="text-center">{{__('Akcije')}}</th>
                </tr>
                </thead>
                <tbody>
                @php $counter = 1; @endphp
                @foreach($ugovori as $ugovor)
                    <tr>
                        <td class="text-center">{{$counter++}} - {{ $ugovor->id ?? '' }}</td>
                        <td><a href="{{route('drzavni-sluzbenici.pregled-sluzbenika', ['id_sluzbenika'=>$ugovor->sluzbenik])}}">{{$ugovor->usluzbenik->ime_prezime ?? ''}}</a></td>
                        <td><a href="{{route('radnamjesta.pregledaj', ['id'=>$ugovor->mjesto->id ?? '1'])}}">{{$ugovor->usluzbenik->sluzbenikRel->rm->naziv_rm ?? ''}}</a></td>
                        <td><a href="{{route('radnamjesta.pregledaj', ['id'=> $ugovor->privremeno_mjesto->id ?? '1'])}}">{{$ugovor->privremeno_mjesto->naziv_rm ?? ''}}</a></td>

                        <td>{{$ugovor->privremeno_mjesto->orgjed->naziv ?? ''}}</td>
                        <td>{{$ugovor->privremeno_mjesto->orgjed->organizacija->organ->naziv ?? ''}}</td>
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
@endsection
