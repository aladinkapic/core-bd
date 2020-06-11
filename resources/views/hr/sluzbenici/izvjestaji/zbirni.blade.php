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

            @include('template.snippets.filters', ['var'  => $organi])


            <table class="table table-bordered low-padding" id="filtering">
                <thead>
                <tr>
                    @include('template.snippets.filters_header')
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
                    @foreach($organi as $organ)

                        @php
                            $muski = 0; $zene = 0;
                            $bosnjak = 0; $srbin = 0; $hrvat = 0; $ostalo = 0;

                            $manjeOd20 = 0; $od21do25 = 0; $od26do30 = 0;
                            $od31do35 = 0; $od36do40 = 0; $od41do45 = 0;
                            $od46do50 = 0; $od51do55 = 0; $od55do61 = 0; $od61do65=0; $veceOd65 = 0;

                        @endphp

                        @foreach($organ->organizacija->organizacioneJedinice as $orgJedinica)
                            @foreach($orgJedinica->radnaMjesta as $rm)
                                @foreach($rm->sluzbeniciRel as $sluzbenik)
                                    @if(isset($sluzbenik->sluzbenik))

                                        <!-- Pol službenika -->

                                        @if(isset($sluzbenik->sluzbenik->pol))
                                            @if($sluzbenik->sluzbenik->pol == 1)
                                                @php $muski++; @endphp
                                            @elseif($sluzbenik->sluzbenik->pol == 2)
                                                @php $zene++; @endphp
                                            @endif
                                        @endif

                                        <!-- Starosna struktura -->

                                        @if(isset($sluzbenik->sluzbenik->godina))
                                            @if($sluzbenik->sluzbenik->godina <= 20)
                                                @php $manjeOd20++; @endphp
                                            @elseif($sluzbenik->sluzbenik->godina > 20 and $sluzbenik->sluzbenik->godina < 26)
                                                @php $od21do25++; @endphp
                                            @elseif($sluzbenik->sluzbenik->godina > 25 and $sluzbenik->sluzbenik->godina < 31)
                                                @php $od26do30++; @endphp
                                            @elseif($sluzbenik->sluzbenik->godina > 30 and $sluzbenik->sluzbenik->godina < 36)
                                                @php $od31do35++; @endphp
                                            @elseif($sluzbenik->sluzbenik->godina > 35 and $sluzbenik->sluzbenik->godina < 41)
                                                @php $od36do40++; @endphp
                                            @elseif($sluzbenik->sluzbenik->godina > 40 and $sluzbenik->sluzbenik->godina < 46)
                                                @php $od41do45++; @endphp
                                            @elseif($sluzbenik->sluzbenik->godina > 45 and $sluzbenik->sluzbenik->godina < 51)
                                                @php $od46do50++; @endphp
                                            @elseif($sluzbenik->sluzbenik->godina > 50 and $sluzbenik->sluzbenik->godina < 56)
                                                @php $od51do55++; @endphp
                                            @elseif($sluzbenik->sluzbenik->godina > 55 and $sluzbenik->sluzbenik->godina < 61)
                                                @php $od55do61++; @endphp
                                            @elseif($sluzbenik->sluzbenik->godina > 60 and $sluzbenik->sluzbenik->godina < 66)
                                                @php $od61do65++; @endphp
                                            @elseif($sluzbenik->sluzbenik->godina > 65)
                                                @php $veceOd65++; @endphp
                                            @endif
                                        @endif

                                        <!-- Nacionalnost -->

                                        @if(isset($sluzbenik->sluzbenik->nacionalnost))
                                            @if($sluzbenik->sluzbenik->nacionalnost == 1)
                                                @php $bosnjak++; @endphp
                                            @elseif($sluzbenik->sluzbenik->nacionalnost == 2)
                                                @php $hrvat++; @endphp
                                            @elseif($sluzbenik->sluzbenik->nacionalnost == 3)
                                                @php $srbin++; @endphp
                                            @elseif($sluzbenik->sluzbenik->nacionalnost == 4)
                                                @php $ostalo++; @endphp
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach


                        <tr>
                            <td>{{$counter++}}</td>
                            <td>{{$organ->naziv ?? '/'}}</td>
                            <td></td>

                            <td>{{$muski}}</td>
                            <td>{{$zene}}</td>

                            <td>{{$bosnjak}}</td>
                            <td>{{$hrvat}}</td>
                            <td>{{$srbin}}</td>
                            <td>{{$ostalo}}</td>
                            <td>{{$bosnjak + $hrvat + $srbin + $ostalo}}</td>

                            <td>{{$manjeOd20}}</td>
                            <td>{{$od21do25}}</td>
                            <td>{{$od26do30}}</td>
                            <td>{{$od31do35}}</td>
                            <td>{{$od36do40}}</td>
                            <td>{{$od41do45}}</td>
                            <td>{{$od46do50}}</td>
                            <td>{{$od51do55}}</td>
                            <td>{{$od55do61}}</td>
                            <td>{{$od61do65}}</td>
                            <td>{{$veceOd65}}</td>

                            <td class="akcije" style="text-align:center;">
                                <button class="btn my-button">{{__('Pregled')}}</button>
                            </td>
                        </tr>
                    @endforeach
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

