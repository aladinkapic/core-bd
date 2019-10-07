@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/osposobljavanje_i_usavrsavanje/obuke/home' => 'Katalog obuka',
    ]) !!}
@stop

@section('content')
    <div class="container">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br/>
        @endif
        <div class="row">
            <div class="col-md-10">
                <h3>{{__('Katalog obuka')}}</h3>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success" onClick="window.location='/osposobljavanje_i_usavrsavanje/obuke/add';">
                    <i class="fa fa-plus fa-1x"></i> {{__('Dodaj novu obuku')}}</button>
            </div>
        </div>
        <br/>
        <br/>
        @include('template.snippets.filters', ['var'  => $obuke])

        <table id="filtering" class="table table-condensed table-bordered">
            <thead>
            <tr>
                @include('template.snippets.filters_header')
                <th width="170">{{__('Akcije')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($obuke as $obuka)
                <tr class="org-row">
                    <td>{{$obuka -> naziv ?? '/'}}</td>
                    <td>{{$obuka -> vrsta ?? '/'}}</td>
                    <td>{{$obuka->organizator ?? '/'}}</td>
                    <td> {{$obuka->broj_polaznika ?? '/'}}</td>
                    <td>
                        <div class="row">
                            <div class="col-3">
                                @if(isset($obuka->ocjena['ocjena'])) {{$obuka->ocjena['ocjena'].__(' / ').$obuka->ocjena['br_ocjena']}} @endif
                            </div>
                            <div class="col-9">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#exampleModal" data-whatever="{{$obuka->id ?? '/'}}">
                                    <i class="fas fa-check-square"></i>
                                    {{__('Ocjeni')}}
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"
                                                    id="exampleModalLabel">{{__('Ocjenjivanje obuke')}}</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h5> {{__('Molimo vas da unesete ocjenu za ovu obuku:')}} </h5>
                                                <form method="post"
                                                      action="/osposobljavanje_i_usavrsavanje/obuke/ocjeni"
                                                      id="ocjena">
                                                    @csrf
                                                    <input id="modaldata" type="hidden" name="obuka_id"/>
                                                    {!!  Form::select('ocjena',$ocjene,  '' ,['class' => 'form-control',  'id' => 'ocjena']) !!}

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
                            @if($obuka->ocjena['br_ocjena']>0)
                                <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                            data-target="#exampleModal2"
                                            data-whatever="{{json_encode($obuka->ocjena['detalji'])}}">
                                        <i class="fas fa-eye"></i>
                                        {{__('Detalji')}}
                                    </button>
                                @endif
                                <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"
                                                    id="exampleModalLabel">{{__('Detalji ocjenjivanja obuke')}}</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table">
                                                    <thead>
                                                    <td>{{__('Ime i prezime')}}</td>
                                                    <td>{{__('Datum')}}</td>
                                                    <td>{{__('Ocjena')}}</td>
                                                    </thead>
                                                    <tbody id="tbody">

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">{{__('Zatvori')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        {{$obuka->brInstanci}}
                        &nbsp&nbsp
                        <a href="/osposobljavanje_i_usavrsavanje/obuke/addInstancu/{{$obuka -> id ?? '1'}}">
                            <button class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i>
                                {{__('Dodaj')}}
                            </button>
                        </a>
                        &nbsp&nbsp&nbsp
                        @if ($obuka->brInstanci > 0)
                            <a href="/osposobljavanje_i_usavrsavanje/obuke/instance/{{$obuka -> id ?? '1'}}">
                                <button class="btn btn-secondary btn-sm">
                                    <i class="fas fa-eye"></i>
                                    {{__('Pregledaj')}}
                                </button>
                            </a>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="/osposobljavanje_i_usavrsavanje/obuke/view/{{$obuka -> id ?? '1'}}">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="/osposobljavanje_i_usavrsavanje/obuke/edit/{{$obuka -> id ?? '1'}}"
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
@endsection

