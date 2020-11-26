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

                            $vss = 0; $sss = 0; $nk = 0;
                            $b_vss = 0; $b_sss = 0; $b_nk = 0;
                            $h_vss = 0; $h_sss = 0; $h_nk = 0;
                            $s_vss = 0; $s_sss = 0; $s_nk = 0;
                            $o_vss = 0; $o_sss = 0; $o_nk = 0;


                        @endphp

                        @foreach($organ->organizacija->organizacioneJedinice as $orgJedinica)
                            @foreach($orgJedinica->radnaMjesta as $rm)

                                @if($rm->stepen == 2 or $rm->stepen == 3 or $rm->stepen == 4 or $rm->stepen == 5)
                                    @foreach($rm->sluzbeniciRel as $sluzbenik)
                                        @if(\App\Models\Sluzbenik::where('id', $sluzbenik->sluzbenik->id)->where('status', 'Aktivan')->first())
                                            @php $sss++; @endphp

                                            @if(isset($sluzbenik->sluzbenik->nacionalnost))
                                                @if($sluzbenik->sluzbenik->nacionalnost == 1)
                                                    @php $b_sss++; @endphp
                                                @elseif($sluzbenik->sluzbenik->nacionalnost == 2)
                                                    @php $h_sss++; @endphp
                                                @elseif($sluzbenik->sluzbenik->nacionalnost == 3)
                                                    @php $s_sss++; @endphp
                                                @elseif($sluzbenik->sluzbenik->nacionalnost == 4)
                                                    @php $o_sss++; @endphp
                                                @endif
                                            @endif
                                        @endif

                                    @endforeach
                                @elseif($rm->stepen == 8 or $rm->stepen == 7 or $rm->stepen == 8)
                                    @foreach($rm->sluzbeniciRel as $sluzbenik)
                                        @if(\App\Models\Sluzbenik::where('id', $sluzbenik->sluzbenik->id)->where('status', 'Aktivan')->first())
                                            @php $vss++; @endphp

                                            @if(isset($sluzbenik->sluzbenik->nacionalnost))
                                                @if($sluzbenik->sluzbenik->nacionalnost == 1)
                                                    @php $b_vss++; @endphp
                                                @elseif($sluzbenik->sluzbenik->nacionalnost == 2)
                                                    @php $h_vss++; @endphp
                                                @elseif($sluzbenik->sluzbenik->nacionalnost == 3)
                                                    @php $s_vss++; @endphp
                                                @elseif($sluzbenik->sluzbenik->nacionalnost == 4)
                                                    @php $o_vss++; @endphp
                                                @endif
                                            @endif
                                        @endif
                                    @endforeach
                                @elseif($rm->stepen == 1)
                                    @foreach($rm->sluzbeniciRel as $sluzbenik)
                                        @if(\App\Models\Sluzbenik::where('id', $sluzbenik->sluzbenik->id)->where('status', 'Aktivan')->first())
                                            @php $nk++; @endphp

                                            @if(isset($sluzbenik->sluzbenik->nacionalnost))
                                                @if($sluzbenik->sluzbenik->nacionalnost == 1)
                                                    @php $b_nk++; @endphp
                                                @elseif($sluzbenik->sluzbenik->nacionalnost == 2)
                                                    @php $h_nk++; @endphp
                                                @elseif($sluzbenik->sluzbenik->nacionalnost == 3)
                                                    @php $s_nk++; @endphp
                                                @elseif($sluzbenik->sluzbenik->nacionalnost == 4)
                                                    @php $o_nk++; @endphp
                                                @endif
                                            @endif
                                        @endif
                                    @endforeach
                                @endif

                                @foreach($rm->sluzbeniciRel as $sluzbenik)
                                    @if(isset($sluzbenik->sluzbenik))

                                        @if(\App\Models\Sluzbenik::where('id', $sluzbenik->sluzbenik->id)->where('status', 'Aktivan')->first())
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
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach


                        <tr>
                            <td>{{$counter++}}</td>
                            <td>{{$organ->naziv ?? '/'}}</td>
                            <td></td>
                            <td>{{$bosnjak + $hrvat + $srbin + $ostalo}}</td>
                            
                            <td>{{$muski}}</td>
                            <td>{{$zene}}</td>

                            <td>{{$bosnjak}}</td>
                            <td>{{$hrvat}}</td>
                            <td>{{$srbin}}</td>
                            <td>{{$ostalo}}</td>

                            <td>{{$vss}}</td>
                            <td>{{$sss}}</td>
                            <td>{{$nk}}</td>

                            <td>
                                <ul>
                                    <li>VSS  - {{$b_vss ?? ''}}</li>
                                    <li> SSS / KV / VKV - {{$b_sss ?? ''}} </li>
                                    <li> NK - {{$b_nk ?? ''}} </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li> VSS  - {{$h_vss ?? ''}} </li>
                                    <li> SSS / KV / VKV - {{$h_sss ?? ''}} </li>
                                    <li> NK - {{$h_nk ?? ''}} </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li> VSS  - {{$s_vss ?? ''}} </li>
                                    <li> SSS / KV / VKV - {{$s_sss ?? ''}} </li>
                                    <li> NK - {{$s_nk ?? ''}} </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li> VSS  - {{$o_vss ?? ''}} </li>
                                    <li> SSS / KV / VKV - {{$o_sss ?? ''}} </li>
                                    <li> NK - {{$o_nk ?? ''}} </li>
                                </ul>
                            </td>

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
                                <button class="btn my-button delete-this-row">{{__('Obrišite')}}</button>
                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection

