@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/osposobljavanje_i_usavrsavanje/predavaci/home' => 'Lista predavača',
    ]) !!}
@stop

@section('content')
    <div class="container">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif
        <div class="row">
            <div class="col-md-10">
                <h4 >{{__('Predavači')}}</h4>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success" onClick="window.location='/osposobljavanje_i_usavrsavanje/predavaci/add';"> <i class="fa fa-plus fa-1x"></i> {{__('Novi predavač')}}</button>
            </div>
        </div>
        <br />
        <br />
            @include('template.snippets.filters', ['var'  => $predavaci])


            <table id="filtering" class="table table-condensed table-bordered">
                <thead>
                <tr>
                    @include('template.snippets.filters_header')
                    <th style="text-align:center;" class="akcije" style="width: 15%;">{{__('Akcija')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($predavaci as $predavac)
                    <tr>
                        <td>{{$predavac->ime ?? '/'}}</td>
                        <td>{{$predavac->prezime ?? '/'}}</td>
                        <td>{{$predavac->telefon ?? '/'}}</td>
                        <td>{{$predavac->mail ?? '/'}}</td>
                        <td>{{$predavac->napomena ?? '/'}}</td>
                        <td style="text-align:center;" class="akcije">
                            <a href="{{ '/ugovori/mjesto-rada/edit/' . $predavac->id ?? '1'}}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ '/ugovori/mjesto-rada/destroy/' . $predavac->id ?? '1'}}"
                               style="margin-left:10px;">
                                <i class="fa fa-times"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
@stop