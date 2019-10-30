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


        <div class="row">

            <!-- POP UP Za ocjenjivanje obuke -->

            <div class="col-3">
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