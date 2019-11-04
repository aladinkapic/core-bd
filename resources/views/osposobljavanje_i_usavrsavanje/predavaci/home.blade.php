@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/osposobljavanje_i_usavrsavanje/predavaci/home' => 'Lista predavača',
    ]) !!}
@stop

@section('content')
    <div class="container">
        <div class="fine-header">
            <h4>{{__('Predavači')}}</h4>

            <div class="buttons">
                <a href="{{route('home')}}" title="Nazad">
                    <div class="small-button small-button-border small-button-edit">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </a>
                <a href="/osposobljavanje_i_usavrsavanje/predavaci/add">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-plus-square"></i>
                        </div>
                        <p>{{__('Novi predavač')}}</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var'  => $predavaci])
            <table class="table table-bordered low-padding" id="filtering">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    @include('template.snippets.filters_header')
                    <th style="text-align:center;" class="akcije" width="120px">{{__('Akcija')}}</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1; @endphp
                @foreach($predavaci as $predavac)
                    <tr>
                        <td class="text-center">{{$i++}}</td>
                        <td>{{$predavac->ime ?? '/'}}</td>
                        <td>{{$predavac->prezime ?? '/'}}</td>
                        <td>{{$predavac->telefon ?? '/'}}</td>
                        <td>{{$predavac->mail ?? '/'}}</td>
                        <td>{{$predavac->napomena ?? '/'}}</td>
                        <td style="text-align:center;" class="akcije">
                            <a href="{{route('uredi-predavaca', ['id' => $predavac->id])}}">
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
    </div>
@stop