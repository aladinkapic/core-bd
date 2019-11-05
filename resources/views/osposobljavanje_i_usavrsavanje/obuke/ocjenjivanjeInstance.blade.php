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
            <h4>{{__('Ocjene instance')}}</h4>

            <div class="buttons">
                <a href="{{route('home')}}" title="Početna stranica">
                    <div class="small-button small-button-border small-button-edit">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </a>
                <a>
                    <div class="small-button small-button-border" data-toggle="modal" data-target="#exampleModal" data-whatever="{{$obuka->id ?? '/'}}">
                        <div class="small-button">
                            <i class="fas fa-plus-square"></i>
                        </div>
                        <p>{{__('Ocjeni instancu')}}</p>
                    </div>
                </a>
            </div>
        </div>





        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var'  => $instanca])
            <table id="filtering" class="table table-condensed table-bordered">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    @include('template.snippets.filters_header')
                    <th class="text-center" width="120px">{{__('Akcije')}}</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1; @endphp
                @foreach($instanca as $ocjena)
                    @if(isset($ocjena->ocjena))
                        <tr>
                            <td class="text-center">{{$i++}}</td>
                            <td>{{$ocjena -> imeSluzbenika->ime_prezime ?? '/'}}</td>
                            <td>{{$ocjena -> ocjena ?? '/'}}</td>
                            <td>{{$ocjena->updated_at ?? '/'}}</td>
                            <td class="text-center row">
                                <a href="/osposobljavanje_i_usavrsavanje/obuke/ocjenaInstance/{{$ocjena->instanca_id.'/'.$ocjena -> sluzbenik_id}}" title="Obrišite">
                                    <i class="fas fa-times"></i>
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