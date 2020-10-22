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
        route('home') => __('Početna stranica'),
        route('sluzbenik.pregled') => __('Lista državnih službenika'),
    ]) !!}

@stop


@section('content')
    <div class="container">
        <div class="fine-header">
            <h4>{{__('Lista državnih službenika')}}</h4>

            <div class="buttons">
                <a href="{{route('home')}}" title="Nazad">
                    <div class="small-button small-button-border small-button-edit">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </a>
                <a href="{{route('drzavni-sluzbenici.dodaj-sluzbenika')}}">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-plus-square"></i>
                        </div>
                        <p>{{__('Dodajte službenika')}}</p>
                    </div>
                </a>
                <a href="{{route('sluzbenik.zbirni-izvjestaj')}}">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-chart-area"></i>
                        </div>
                        <p>{{__('Zbirni izvještaji')}}</p>
                    </div>
                </a>
            </div>
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
                @foreach($sluzbenici as $sluzbenik)
                    <tr class="sluzbenik-row">
                        <td style="text-align:center;">{{ $counter++}}</td>
                        <td>{{ $sluzbenik->ime_prezime ?? '/'}}</td>
                        <td>{{ $sluzbenik->email ?? '/'}}</td>
                        <td>{{ $sluzbenik->jmbg ?? '/'}}</td>
                        <td>{{ $sluzbenik->ime_roditelja ?? '/'}}</td>
                        <td>{{ $sluzbenik->spol_sl->name ?? '' }}</td>
                        <td>{{ $sluzbenik->kategorija_sl ? $sluzbenik->kategorija_sl->name : '' }}</td>
                        <td>{{ $sluzbenik->drzavljanstvoRel->name ?? '/' }}</td>
                        <td>{{ $sluzbenik->nacionalnost_sl ? $sluzbenik->nacionalnost_sl->name : '' }}</td>
                        <td>{{ $sluzbenik->bracni_status_sl ? $sluzbenik->bracni_status_sl->name : '' }}</td>

                        <td>{{ $sluzbenik->staz_godina ?? '/'}}</td>
                        <td>{{ $sluzbenik->staz_mjeseci ?? '/'}}</td>
                        <td>{{ $sluzbenik->staz_dana ?? '/'}}</td>

                        <td>{{ $sluzbenik->mjesto_rodjenja ?? '/' }}</td>
                        <td>{{ $sluzbenik->datumRodjenja() ?? '/'}}</td>
                        <td>{{ $sluzbenik->licna_karta ?? '/'}}</td>
                        <td>{{ $sluzbenik->mjesto_idavanja_lk ?? '/'}}</td>
                        <td>{{ $sluzbenik->pioRel->name ?? '/'}}</td>

                        <!-- Radno mjesto službenika -->
                        <td>
                            <a href="{{route('radnamjesta.pregledaj', ['id' => $sluzbenik->sluzbenikRel->rm->id ?? '1'])}}">
                                {{ $sluzbenik->sluzbenikRel->rm->naziv_rm ?? '/' }}
                            </a>
                        </td>
                        <td>{{$sluzbenik->radnoMjesto->katgorijaa->name ?? ''}}</td>
                        <td>{{ $sluzbenik->privremeni_premjestaj ?? '/'}}</td>
                        <td>{{ $sluzbenik->sluzbenikRel->rm->orgjed->naziv ?? '/'}}</td>
                        <td>{{ $sluzbenik->sluzbenikRel->rm->orgjed->organizacija->organ->naziv ?? '/'}}</td>

                        <!---- Previbalište službenika ---->
                        <td>
                            @if($sluzbenik->prebivaliste)
                                <ul>
                                    @foreach($sluzbenik->prebivaliste as $prebivaliste)
                                        <li>
                                            {{ $prebivaliste->adresa_prebivalista ?? '/'}}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>
                            @if($sluzbenik->prebivaliste)
                                <ul>
                                    @foreach($sluzbenik->prebivaliste as $prebivaliste)
                                        <li>
                                            {{ $prebivaliste->mjesto_prebivalista ?? '/'}}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>
                            @if($sluzbenik->prebivaliste)
                                <ul>
                                    @foreach($sluzbenik->prebivaliste as $prebivaliste)
                                        <li>
                                            {{ $prebivaliste->adresa_boravista ?? '/'}}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>

                        <td>
                            <ul>
                                @foreach($sluzbenik->zasnivanjeRORel as $zasnivanje)
                                    <li>{{$zasnivanje->datumZasnivanjaRO() ?? ''}}</li>
                                @endforeach
                            </ul>
                        </td>

                        <td>
                            <ul>
                                @foreach($sluzbenik->zasnivanjeRORel as $zasnivanje)
                                    <li>{{$zasnivanje->nacin_zasnivanja_ro_s->name ?? ''}}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @foreach($sluzbenik->zasnivanjeRORel as $zasnivanje)
                                    <li>{{$zasnivanje->vrsta_r_o_s->name ?? ''}}</li>
                                @endforeach
                            </ul>
                        </td>

                        <td>
                            <ul>
                                @if(isset($sluzbenik->zasnivanjeRORel) and count($sluzbenik->zasnivanjeRORel))
                                    @foreach($sluzbenik->zasnivanjeRORel as $zasnivanje)
                                        <li>{{$zasnivanje->obracunati_r_staz_s->name ?? ''}}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </td>

                        <!-- Ispiti službenika -->
                        <td>
                            <ul>
                                @if(isset($sluzbenik->zasnivanjeRORel) and count($sluzbenik->zasnivanjeRORel))
                                    @foreach($sluzbenik->zasnivanjeRORel as $zasnivanje)
                                        <li>{{$zasnivanje->obracunati_r_s_god ?? ''}}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @if(isset($sluzbenik->zasnivanjeRORel) and count($sluzbenik->zasnivanjeRORel))
                                    @foreach($sluzbenik->zasnivanjeRORel as $zasnivanje)
                                        <li>{{$zasnivanje->obracunati_r_s_mje ?? ''}}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @if(isset($sluzbenik->zasnivanjeRORel) and count($sluzbenik->zasnivanjeRORel))
                                    @foreach($sluzbenik->zasnivanjeRORel as $zasnivanje)
                                        <li>{{$zasnivanje->obracunati_r_s_dan ?? ''}}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @foreach($sluzbenik->zasnivanjeRORel as $zasnivanje)
                                    <li>{{$zasnivanje->datum_donosenja_dokumentacije}}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @foreach($sluzbenik->zasnivanjeRORel as $zasnivanje)
                                    <li>{{$zasnivanje->minuli_radni_staz}}</li>
                                @endforeach
                            </ul>
                        </td>
                        <!---- Stručna sprema službenika ---->
                        <td>
                            @if($sluzbenik->strucnaSprema)
                                <ul>
                                    @foreach($sluzbenik->strucnaSprema as $sprema)
                                        <li>
                                            {{ $sprema->stepenStrucne->name ??  '/'}}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>
                            @if($sluzbenik->strucnaSprema)
                                <ul>
                                    @foreach($sluzbenik->strucnaSprema as $sprema)
                                        <li>
                                            {{ $sprema->vrsta_s_s ?? '/'}}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>
                            @if($sluzbenik->strucnaSprema)
                                <ul>
                                    @foreach($sluzbenik->strucnaSprema as $sprema)
                                        <li>
                                            {{ $sprema->obrazovnaInstitucija->name ?? '/'}}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>

                        <td style="text-align:center;" class="akcije">
                            @if(isset($odsustva))
                                <a href="{{ '/hr/odsustva/kalendar/' . $sluzbenik->id ?? '1'}}">
                                    <i class="fa fa-eye"></i> {{__('Odsustva')}}
                                </a>
                            @elseif(isset($uloge))
                                <a href="{{ '/uloge/dodijeliUlogu/' . $sluzbenik->id ?? '1'}}">
                                    <i class="fa fa-eye"></i> {{__('Uredite uloge')}}
                                </a>
                            @else
                                <a href="{{route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $sluzbenik->id ?? ''])}}">
                                    <button class="btn my-button">{{__('Pregled')}}</button>
                                </a>
                            @endif
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>

            <br/>

            <h4>{{__('Grafici')}}</h4>

            <div class="row">
                <div class="col-6">
                    <canvas id="doughnut-chart" width="800" height="450" style="display: block; width: 762px; height: 381px;" width="762" height="381"></canvas>
                </div>
                <div class="col-6">
                    <canvas id="line-chart" width="800" height="450"></canvas>
                </div>
            </div>

        </div>
        @section('js')
            <script type="text/javascript">
                new Chart(document.getElementById("doughnut-chart"), {
                    type: 'pie',
                    data: {
                        labels: ["Muškarci", "Žene"],
                        datasets: [
                            {
                                label: "Population (millions)",
                                backgroundColor: ["#3e95cd", "#ff6384"],
                                data: [{{$sluzbenici->where('pol',1)->count().','.$sluzbenici->where('pol',2)->count()}}]
                            }
                        ]
                    },
                    options: {
                        legend: {reverse: true},

                        title: {
                            display: true,
                            text: 'Spolna struktura službenika'
                        }
                    }
                });


                new Chart(document.getElementById("line-chart"), {
                    type: 'line',
                    data: {
                        labels: [
                            '70-75',
                            '65-70',
                            '60-65',
                            '55-60',
                            '50-55',
                            '45-50',
                            '40-45',
                            '35-40',
                            '30-35',
                            '25-30',
                            '20-25',
                        ],
                        datasets: [{
                            label: 'Dobna struktura',
                            backgroundColor: "#3cba9f",
                            borderColor: "#3cba9f",
                            data: [
                                {{$q.','.$w.','.$e.','.$r.','.$t.','.$y.','.$u.','.$i.','.$o.','.$p.','.$l}}
                            ],
                            fill: false,
                        },
                            {
                                label: 'Muškarci',
                                fill: false,
                                backgroundColor: "#3e95cd",
                                borderColor: "#3e95cd",
                                data: [
                                    {{implode(',',$mm)}}

                                ],
                            },
                            {
                                label: 'Žene',
                                fill: false,
                                backgroundColor: "#ff6384",
                                borderColor: "#ff6384",
                                data: [
                                    {{implode(',',$zz)}}

                                ],
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Struktura zaposlenika'
                        },
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        },
                        scales: {
                            xAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Godine'
                                }
                            }],
                            yAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Broj'
                                }
                            }]
                        }
                    }
                });


            </script>
        @endsection
    </div>
@endsection

