@extends('template.main')
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('sluzbenik.pregled') => 'Lista državnih službenika',
        route('sluzbenik.zbirni-izvjestaj') => 'Zbirni izvještaji'
    ]) !!}

@stop


@section('content')
    <div class="container">
        <div class="fine-header">
            <h4>{{__('Zbirni izvještaj')}}</h4>

            <div class="buttons">
                <a href="{{route('sluzbenik.pregled')}}">
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

{{--            @include('template.snippets.filters', ['var'  => $sluzbenici])--}}


            <table class="table table-bordered low-padding" id="filtering">
                <thead>
                <tr>
{{--                    @include('template.snippets.filters_header')--}}
                    <th width="120px" class="akcije text-center">{{__('Akcije')}}</th>
                </tr>
                </thead>
                <tbody>
                @php
                    if(isset($_GET['page'])){
                        if(isset($_GET['limit'])){
                            $counter = ($_GET['page'] - 1) * $_GET['limit'] + 1;
                        }else $counter = ($_GET['page'] - 1) * 10 + 1;
                    }else $counter = 1;
                @endphp
{{--                @foreach($sluzbenici as $sluzbenik)--}}
{{--                    <tr class="sluzbenik-row">--}}
{{--                        <td style="text-align:center;">{{ $counter++}}</td>--}}
{{--                        <td>{{ $sluzbenik->ime_prezime ?? '/'}}</td>--}}
{{--                        <td>{{ $sluzbenik->email ?? '/'}}</td>--}}
{{--                        <td>{{ $sluzbenik->jmbg ?? '/'}}</td>--}}
{{--                        <td>{{ $sluzbenik->ime_roditelja ?? '/'}}</td>--}}

{{--                        <td style="text-align:center;" class="akcije">--}}
{{--                            <a href="{{ '/hr/odsustva/kalendar/' . $sluzbenik->id ?? '1'}}">--}}
{{--                                <i class="fa fa-eye"></i> {{__('Odsustva')}}--}}
{{--                            </a>--}}
{{--                        </td>--}}
{{--                    </tr>--}}

{{--                @endforeach--}}
                </tbody>
            </table>

        </div>
    </div>
@endsection

