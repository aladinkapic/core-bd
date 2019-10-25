@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/osposobljavanje_i_usavrsavanje/obuke/home' => 'Katalog obuka',
    ]) !!}
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h3>{{__('Ocjene instance')}}</h3>
            </div>
            <div class="col-3">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success float-right" data-toggle="modal"
                        data-target="#exampleModal" data-whatever="{{$obuka->id ?? '/'}}">
                    <i class="fas fa-check-square"></i>
                    {{__('Ocjeni instancu')}}
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"
                                    id="exampleModalLabel">{{__('Ocjenjivanje instance')}}</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="get" id="ocjena">
                                    @csrf
                                    <h6> {{__('Molimo vas da izaberete službenika:')}} </h6>
                                    {!!  Form::select('sluzbenik_id',$instanca->pluck('imeSluzbenika.ime_prezime','sluzbenik_id'),  '' ,['class' => 'form-control',  'id' => 'sluzbenik']) !!}
                                    <br>
                                    <h6> {{__('Molimo vas da izaberete ocjenu za ovu obuku:')}} </h6>
                                    {!!  Form::select('ocjena',[0,1,2,3,4,5,6,7,8,9,10],  '' ,['class' => 'form-control',  'id' => 'ocjena']) !!}
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">{{__('Zatvori')}}</button>
                                <button type="submit" value="Submit" class="btn btn-primary"
                                        form="ocjena">{{__('Spasi!')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <br/>
        @include('template.snippets.filters', ['var'  => $instanca])

        <table id="filtering" class="table table-condensed table-bordered">
            <thead>
            <tr>
                <th class="text-center">#</th>
                @include('template.snippets.filters_header')
                <th class="text-center" width="150px">{{__('Akcije')}}</th>
            </tr>
            </thead>
            <tbody>
            @php $i=1; @endphp
            @if (isset($instanca))
                @foreach($instanca as $ocjena)
                    @if(isset($ocjena->ocjena))
                        <tr class="org-row">
                            <td class="text-center">{{$i++}}</td>
                            <td>{{$ocjena -> imeSluzbenika->ime_prezime ?? '/'}}</td>
                            <td>{{$ocjena -> ocjena ?? '/'}}</td>
                            <td>{{$ocjena->updated_at ?? '/'}}</td>
                            <td class="text-center row">
                                <div class="col-6 float-left">
                                    <!-- Button trigger modal -->
                                    <a  class="btn btn-success float-left" data-toggle="modal"
                                       data-target="#exampleModal2" data-whatever="{{$obuka->id ?? '/'}}"
                                       title="Izmjeni ocjenu">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"
                                                        id="exampleModalLabel">{{__('Ocjenjivanje instance')}}</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="get" id="ocjena2">
                                                        @csrf
                                                        <h6> {{__('Molimo vas da izaberete službenika:')}} </h6>
                                                        {!!  Form::select('sluzbenik_id',[$ocjena -> imeSluzbenika->id=>$ocjena -> imeSluzbenika->ime_prezime],  $ocjena -> imeSluzbenika->id ,['class' => 'form-control',  'id' => 'sluzbenik']) !!}
                                                        <br>
                                                        <h6> {{__('Molimo vas da izaberete ocjenu za ovu obuku:')}} </h6>
                                                        {!!  Form::select('ocjena',[0,1,2,3,4,5,6,7,8,9,10],  $ocjena -> ocjena  ,['class' => 'form-control',  'id' => 'ocjena']) !!}
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{__('Zatvori')}}</button>
                                                    <button type="submit" value="Submit" class="btn btn-primary"
                                                            form="ocjena2">{{__('Spasi!')}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-6 float-right">
                                    <a href="/osposobljavanje_i_usavrsavanje/obuke/ocjenaInstance/{{$ocjena->instanca_id.'/'.$ocjena -> sluzbenik_id}}">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td colspan="6">{{__('Nema Podataka!')}}</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection