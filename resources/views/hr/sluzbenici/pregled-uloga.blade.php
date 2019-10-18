@extends('template.main')
@section('other_js_links')
    <script>
        /*app.hidden_columns = [/* 2, 3, 4,  5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18,
            19, 20, 21, 22, 23, 24, 25, 26, 27];*/
        app.chunked_url = '/api/chunked/sluzbenik';
    </script>
@endsection
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('sluzbenik.pregled') => 'Lista državnih službenika',
    ]) !!}

@stop


@section('content')
    <div class="container">
        <div class="row" style=" margin-left:6px; width: calc(100% - 40px);">
            <div class="col-md-10">
                <h4>{{__('Lista državnih službenika')}}</h4>
                <!---<button v-on:click="fireTable()" class="btn btn-primary btn-xs"><i class="fa fa-filter"
                                                                                   style="font-size: 11px;"></i> Filteri
                </button>--->
            </div>
            @if(!isset($odsustva))
                <div class="col-md-2">
                    <button class="btn btn-success" v-on:click="url('{{ route('sluzbenik.dodaj') }}')"><i
                                class="fa fa-plus fa-1x"></i>{{__(' Dodajte novog službenika')}}
                    </button>
                </div>
            @endif

        </div>

        <div class="card-body hr-activity tab full_container">

            @include('template.snippets.filters', ['var'  => $sluzbenici])

            @php
                $q = $sluzbenici->where('datum_rodjenja','<',(date('Y')-70).'-01-01')->where('datum_rodjenja','>',(date('Y')-75).'-01-01')->count();
                $w = $sluzbenici->where('datum_rodjenja','<',(date('Y')-65).'-01-01')->where('datum_rodjenja','>',(date('Y')-70).'-01-01')->count();
                $e=  $sluzbenici->where('datum_rodjenja','<',(date('Y')-60).'-01-01')->where('datum_rodjenja','>',(date('Y')-65).'-01-01')->count();
                $r = $sluzbenici->where('datum_rodjenja','<',(date('Y')-55).'-01-01')->where('datum_rodjenja','>',(date('Y')-60).'-01-01')->count();
                $t = $sluzbenici->where('datum_rodjenja','<',(date('Y')-50).'-01-01')->where('datum_rodjenja','>',(date('Y')-55).'-01-01')->count();
                $y = $sluzbenici->where('datum_rodjenja','<',(date('Y')-45).'-01-01')->where('datum_rodjenja','>',(date('Y')-50).'-01-01')->count();
                $u = $sluzbenici->where('datum_rodjenja','<',(date('Y')-40).'-01-01')->where('datum_rodjenja','>',(date('Y')-45).'-01-01')->count();
                $i = $sluzbenici->where('datum_rodjenja','<',(date('Y')-35).'-01-01')->where('datum_rodjenja','>',(date('Y')-40).'-01-01')->count();
                $o=  $sluzbenici->where('datum_rodjenja','<',(date('Y')-30).'-01-01')->where('datum_rodjenja','>',(date('Y')-35).'-01-01')->count();
                $p = $sluzbenici->where('datum_rodjenja','<',(date('Y')-25).'-01-01')->where('datum_rodjenja','>',(date('Y')-30).'-01-01')->count();
                $l = $sluzbenici->where('datum_rodjenja','<',(date('Y')-20).'-01-01')->where('datum_rodjenja','>',(date('Y')-25).'-01-01')->count();

                $mm = [
                 $sluzbenici->where('datum_rodjenja','<',(date('Y')-70).'-01-01')->where('datum_rodjenja','>',(date('Y')-75).'-01-01')->where('pol',1)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-65).'-01-01')->where('datum_rodjenja','>',(date('Y')-70).'-01-01')->where('pol',1)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-60).'-01-01')->where('datum_rodjenja','>',(date('Y')-65).'-01-01')->where('pol',1)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-55).'-01-01')->where('datum_rodjenja','>',(date('Y')-60).'-01-01')->where('pol',1)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-50).'-01-01')->where('datum_rodjenja','>',(date('Y')-55).'-01-01')->where('pol',1)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-45).'-01-01')->where('datum_rodjenja','>',(date('Y')-50).'-01-01')->where('pol',1)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-40).'-01-01')->where('datum_rodjenja','>',(date('Y')-45).'-01-01')->where('pol',1)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-35).'-01-01')->where('datum_rodjenja','>',(date('Y')-40).'-01-01')->where('pol',1)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-30).'-01-01')->where('datum_rodjenja','>',(date('Y')-35).'-01-01')->where('pol',1)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-25).'-01-01')->where('datum_rodjenja','>',(date('Y')-30).'-01-01')->where('pol',1)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-20).'-01-01')->where('datum_rodjenja','>',(date('Y')-25).'-01-01')->where('pol',1)->count()
                ];

            $zz = [
                 $sluzbenici->where('datum_rodjenja','<',(date('Y')-70).'-01-01')->where('datum_rodjenja','>',(date('Y')-75).'-01-01')->where('pol',2)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-65).'-01-01')->where('datum_rodjenja','>',(date('Y')-70).'-01-01')->where('pol',2)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-60).'-01-01')->where('datum_rodjenja','>',(date('Y')-65).'-01-01')->where('pol',2)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-55).'-01-01')->where('datum_rodjenja','>',(date('Y')-60).'-01-01')->where('pol',2)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-50).'-01-01')->where('datum_rodjenja','>',(date('Y')-55).'-01-01')->where('pol',2)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-45).'-01-01')->where('datum_rodjenja','>',(date('Y')-50).'-01-01')->where('pol',2)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-40).'-01-01')->where('datum_rodjenja','>',(date('Y')-45).'-01-01')->where('pol',2)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-35).'-01-01')->where('datum_rodjenja','>',(date('Y')-40).'-01-01')->where('pol',2)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-30).'-01-01')->where('datum_rodjenja','>',(date('Y')-35).'-01-01')->where('pol',2)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-25).'-01-01')->where('datum_rodjenja','>',(date('Y')-30).'-01-01')->where('pol',2)->count()
                ,$sluzbenici->where('datum_rodjenja','<',(date('Y')-20).'-01-01')->where('datum_rodjenja','>',(date('Y')-25).'-01-01')->where('pol',2)->count()
                ];
            @endphp


            <table class="table table-bordered low-padding" id="filtering">
                <thead>
                <tr>
                    @include('template.snippets.filters_header')
                    <th style="text-align:center;" class="akcije">Akcije</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1; @endphp
                @foreach($sluzbenici as $sluzbenik)
                    <tr class="sluzbenik-row">
                        <td style="text-align:center;">{{ $i++}}</td>
                        <td>{{ $sluzbenik->ime_prezime ?? '/'}}</td>
                        <td>{{ $sluzbenik->email ?? '/'}}</td>
                        <td>{{ $sluzbenik->jmbg ?? '/'}}</td>
                        <td>{{ $sluzbenik->ime_roditelja ?? '/'}}</td>

                        <!-- Radno mjesto službenika -->
                        <td>{{ $sluzbenik->radnoMjesto->naziv_rm ?? '/' }}</td>
                        <td>{{ $sluzbenik->radnoMjesto->orgjed->naziv ?? '/'}}</td>
                        <td>{{ $sluzbenik->radnoMjesto->orgjed->organizacija->organ->naziv ?? '/'}}</td>


                        <td style="text-align:center;" class="akcije">
                            <a href="{{ '/uloge/dodijeliUlogu/' . $sluzbenik->id ?? '1'}}">
                                <button class="my-extra-button my-extra-button-2">Uredite uloge</button>
                            </a>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

