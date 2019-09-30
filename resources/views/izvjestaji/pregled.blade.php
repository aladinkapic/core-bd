@extends('template.main')
{{--@section('other_js_links')--}}
{{--<script>--}}
{{--app.items = {!! $izvjestaji !!};--}}
{{--/* setTimeout(function(){--}}
{{--app.fireTable();--}}
{{--}, 1000); */--}}

{{--</script>--}}
{{--@endsection--}}
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('izvjestaji.pregled') => 'Izvještaji',
    ]) !!}

@stop
@section('content')
    <div class="container">
        <div class="row" style=" margin-left:6px; width: calc(100% - 40px);">
            <div class="col-md-10">
                <h4>{{__('Pregled svih izvještaja')}}</h4>
            </div>
        </div>

        <br/>

        @include('template.snippets.filters', ['var'  => $izvjestaji])


        <table id="filtering" class="table table-condensed table-bordered">
            <thead>
            <tr>
                @include('template.snippets.filters_header')
                <th style="text-align:center;" class="akcije" style="width: 15%;">{{__('Akcija')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($izvjestaji as $izvjestaj)
                <tr>
                    <td>{{$izvjestaj->naziv_korisnicki}}</td>
                    <td>{{$izvjestaj->created_at}}</td>

                    <td style="text-align:center;" class="akcije">
                        @if($izvjestaj->what == 'word')
                            <a href="/izvjestaji/word/{{$izvjestaj->naziv.'.docx'}}" download="{{$izvjestaj->naziv_korisnicki}}">
                                <i class="fa fa-file-word" style="color:blue;"></i>
                                <span style="margin-left:10px;">{{__('Preuzmite izvještaj')}}</span>
                            </a>
                        @elseif($izvjestaj->what == 'pdf')
                            <a href="/izvjestaji/pdf/{{$izvjestaj->naziv.'.pdf'}}" download="{{$izvjestaj->naziv_korisnicki}}">
                                <i class="fa fa-file-pdf" style="color:red;"></i>
                                <span style="margin-left:10px;">{{__('Preuzmite izvještaj')}}</span>
                            </a>
                        @elseif($izvjestaj->what == 'excel')
                            <a href="/izvjestaji/excel/{{$izvjestaj->naziv.'.xlsx'}}" download="{{$izvjestaj->naziv_korisnicki}}">
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
@stop

{{--<div class="card-body hr-activity tab full_container">--}}
{{--<table class="table table-bordered low-padding" id="filtering">--}}
{{--<thead >--}}
{{--<tr >--}}
{{--<th scope="col" width="40px;" style="text-align:center;">ID</th>--}}
{{--<th scope="col">Naziv izvještaja</th>--}}
{{--<th scope="col">Kreirao</th>--}}
{{--<th scope="col">Datum</th>--}}
{{--<th scope="col" style="text-align:center;">Akcije</th>--}}
{{--</tr>--}}
{{--</thead>--}}
{{--<tbody>--}}
{{--<tr class="izvjestaj-row"   v-for="(izvjestaj, index) in items" v-bind:style=" index > 10 ? 'display: none;' : 'display: table-row;'">--}}
{{--<td scope="row" width="40px;" style="text-align:center;">@{{ izvjestaj.id }}</td>--}}
{{--<td>@{{ izvjestaj.naziv_korisnicki }}</td>--}}
{{--<td>--}}
{{--<span v-if="izvjestaj.sluzbenik">--}}
{{--@{{ izvjestaj.sluzbenik.ime }} @{{ izvjestaj.sluzbenik.prezime }}--}}
{{--</span>--}}
{{--</td>--}}
{{--<td>@{{ izvjestaj.created_at }} </td>--}}
{{--<td style="text-align:center;">--}}
{{--<a v-if="izvjestaj.what === 'word'" v-bind:href="'/izvjestaji/word/' + izvjestaj.naziv + '.docx'" v-bind:download="izvjestaj.naziv_korisnicki">--}}
{{--<i class="fa fa-file-word" v-if="izvjestaj.what === 'word'"></i>--}}
{{--<span style="margin-left:10px;">Preuzmite izvještaj</span>--}}
{{--</a>--}}
{{--<a v-if="izvjestaj.what === 'pdf'" v-bind:href="'/izvjestaji/pdf/' + izvjestaj.naziv + '.pdf'" v-bind:download="izvjestaj.naziv_korisnicki">--}}
{{--<i class="fa fa-file-pdf" style="color:#333;" v-if="izvjestaj.what === 'pdf'"></i>--}}
{{--<span style="margin-left:10px;">Preuzmite izvještaj</span>--}}
{{--</a>--}}
{{--<a v-if="izvjestaj.what === 'excel'" v-bind:href="'/izvjestaji/excel/' + izvjestaj.naziv + '.xlsx'" v-bind:download="izvjestaj.naziv_korisnicki">--}}
{{--<i class="fa fa-file-excel" style="color:green;" v-if="izvjestaj.what === 'excel'"></i>--}}
{{--<span style="margin-left:10px;">Preuzmite izvještaj</span>--}}
{{--</a>--}}
{{--</td>--}}
{{--</tr>--}}
{{--</tbody>--}}
{{--</table>--}}
{{--</div>--}}
{{--</div>--}}
{{--@endsection--}}
