@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/osposobljavanje_i_usavrsavanje/teme/home' => 'Lista tema',
    ]) !!}
@stop

@section('content')
    <div class="container">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{session()->get('success')}}
            </div>
        @endif
            <div class="row">
                <div class="col-md-10">
                    <h4 >{{__('Teme za obuku')}}</h4>
                </div>
                <div class="col-md-2">
                    <button class="btn  btn-success" v-on:click="url('/osposobljavanje_i_usavrsavanje/teme/add')"> <i class="fa fa-plus fa-1x"></i> {{__('Nova tema za obuku')}}</button>
                </div>
            </div>

            <br />
            <br />

            @include('template.snippets.filters', ['var'  => $teme])

            <table id="filtering" class="table table-condensed table-bordered">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    @include('template.snippets.filters_header')
                    <th style="text-align:center;width: 120px;" class="akcije">{{__('Akcija')}}</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1; @endphp
                @foreach($teme as $tema)
                    <tr>
                        <td class="text-center">{{$i++}}</td>
                        <td>{{$tema->naziv ?? '/'}}</td>
                        <td>{{$tema->oblast_s->name ?? '/'}}</td>
                        <td>{{$tema->napomena ?? '/'}}</td>
                        <td class="text-center">
                        <a href="/osposobljavanje_i_usavrsavanje/teme/viewTema/{{$tema -> id ?? '1'}}">
                        <i class="fa fa-eye"></i>
                        </a>
                        <a href="/osposobljavanje_i_usavrsavanje/teme/editTema/{{$tema -> id ?? '1'}}" style="margin-left:10px;">
                        <i class="fas fa-edit"></i>
                        </a>
                        <a href="/osposobljavanje_i_usavrsavanje/teme/delete/{{$tema -> id ?? '1'}}" style="margin-left:10px;">
                        <i class="fas fa-times"></i>
                        </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
@stop