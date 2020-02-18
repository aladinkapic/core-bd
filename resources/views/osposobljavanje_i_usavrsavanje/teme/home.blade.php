@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        '/osposobljavanje_i_usavrsavanje/teme/home' => __('Lista tema'),
    ]) !!}
@stop

@section('content')
    <div class="container">
        <div class="fine-header">
            <h4>{{__('Teme za obuku')}}</h4>

            <div class="buttons">
                <a href="{{route('home')}}" title="Nazad">
                    <div class="small-button small-button-border small-button-edit">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </a>
                <a href="/osposobljavanje_i_usavrsavanje/teme/add">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-plus-square"></i>
                        </div>
                        <p>{{__('Nova tema za obuku')}}</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="card-body hr-activity tab full_container">
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
    </div>
@stop
