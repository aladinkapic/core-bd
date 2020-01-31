@extends('template.main')
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('izvjestaji.pregled') => __('Izvještaji'),
    ]) !!}

@stop
@section('content')
    <div class="container">
        <div class="fine-header">
            <h4>{{__('Pregled svih izvještaja')}}</h4>

            <div class="buttons">
                <a href="{{route('home')}}">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-angle-left"></i>
                        </div>
                        <p>{{__('Nazad')}}</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var'  => $izvjestaji])
            <table id="filtering" class="table table-condensed table-bordered">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    @include('template.snippets.filters_header')
                    <th style="text-align:center;width: 170px;" class="akcije">{{__('Akcija')}}</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1; @endphp
                @foreach($izvjestaji as $izvjestaj)
                    <tr>
                        <td class="text-center">{{$i++}}</td>
                        <td>{{$izvjestaj->naziv_korisnicki ?? '/'}}</td>
                        <td>{{$izvjestaj->created_at ?? '/'}}</td>

                        <td style="text-align:center;" class="akcije">
                            @if($izvjestaj->what == 'word')
                                <a target="_blank" href="/izvjestaji/word/{{$izvjestaj->naziv.'.docx'}}" download="{{$izvjestaj->naziv_korisnicki ?? '/'}}">
                                    <i class="fa fa-file-word" style="color:blue;"></i>
                                    <span style="margin-left:10px;">{{__('Preuzmite izvještaj')}}</span>
                                </a>
                            @elseif($izvjestaj->what == 'pdf')
                                <a href="/export/read-pdf/{{$izvjestaj->naziv.'.pdf'}}" >
                                    <i class="fa fa-file-pdf" style="color:red;"></i>
                                    <span style="margin-left:10px;">{{__('Preuzmite izvještaj')}}</span>
                                </a>
                            @elseif($izvjestaj->what == 'excel')
                                <a href="/izvjestaji/excel/{{$izvjestaj->naziv.'.xlsx'}}" download="{{$izvjestaj->naziv_korisnicki ?? '/'}}">
                                    <i class="fa fa-file-excel" style="color:green;"></i>
                                    <span style="margin-left:10px;">{{__('Preuzmite izvještaj')}}</span>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
