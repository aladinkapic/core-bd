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
                <h4>Lista državnih službenika</h4>
                <!---<button v-on:click="fireTable()" class="btn btn-primary btn-xs"><i class="fa fa-filter"
                                                                                   style="font-size: 11px;"></i> Filteri
                </button>--->
            </div>
            @if(!isset($odsustva))
                <div class="col-md-2">
                    <button class="btn btn-success" v-on:click="url('{{ route('sluzbenik.dodaj') }}')"><i
                                class="fa fa-plus fa-1x"></i> Dodajte novog službenika
                    </button>
                </div>
            @endif

        </div>

        <div class="card-body hr-activity tab full_container">

            @include('template.snippets.filters', ['var'  => $sluzbenici])

            <table class="table table-bordered low-padding" id="filtering">
                <thead>
                <tr>
                    @include('template.snippets.filters_header')
                    <th style="text-align:center;" class="akcije">Akcije</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sluzbenici as $sluzbenik)
                    <tr class="sluzbenik-row">
                        <td scope="row" width="40px;" style="text-align:center;">{{ $sluzbenik->id }}</td>
                        <td>{{ $sluzbenik->ime_prezime }}</td>
                        <td>{{ $sluzbenik->email }}</td>
                        <td>{{ $sluzbenik->jmbg }}</td>
                        <td>{{ $sluzbenik->ime_roditelja }}</td>
                        <td>{{ $sluzbenik->spol_sl->name ?? '' }}</td>
                        <td>{{ $sluzbenik->kategorija_sl ? $sluzbenik->kategorija_sl->name : '' }}</td>
                        <td>{{ $sluzbenik->drzavljanstvo_1 }}</td>
                        <td>{{ $sluzbenik->nacionalnost_sl ? $sluzbenik->nacionalnost_sl->name : '' }}</td>
                        <td>{{ $sluzbenik->bracni_status_sl ? $sluzbenik->bracni_status_sl->name : '' }}</td>
                        <td>{{ $sluzbenik->mjesto_rodjenja }}</td>
                        <td>{{ $sluzbenik->datum_rodjenja }}</td>
                        <td>{{ $sluzbenik->licna_karta }}</td>
                        <td>{{ $sluzbenik->mjesto_idavanja_lk }}</td>
                        <td>{{ $sluzbenik->PIO }}</td>

                        <!-- Radno mjesto službenika -->
                        <td>{{ $sluzbenik->radnoMjesto ? $sluzbenik->radnoMjesto->naziv_rm : '' }}</td>
                        <td>{{ $sluzbenik->radnoMjesto ? $sluzbenik->radnoMjesto->orgjed ? $sluzbenik->radnoMjesto->orgjed->naziv : '' : ''}}</td>
                        <td>{{ $sluzbenik->radnoMjesto ? $sluzbenik->radnoMjesto->orgjed ? $sluzbenik->radnoMjesto->orgjed->organizacija ? $sluzbenik->radnoMjesto->orgjed->organizacija->organ ? $sluzbenik->radnoMjesto->orgjed->organizacija->organ->naziv : '' : '' : '' : ''}}</td>
                        <td>{{ $sluzbenik->radnoMjesto ? $sluzbenik->radnoMjesto->rukovodioc_s->name : '' }}</td>

                        <!---- Previbalište službenika ---->
                        <td>
                            @if($sluzbenik->prebivaliste)
                                <ul>
                                    @foreach($sluzbenik->prebivaliste as $prebivaliste)
                                        <li>
                                            {{ $prebivaliste->adresa_prebivalista }}
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
                                            {{ $prebivaliste->mjesto_prebivalista }}
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
                                            {{ $prebivaliste->adresa_boravista }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        {{--<td>--}}
                            {{--<ul style="list-style: none; margin: 0; padding: 0;">--}}
                                {{--@foreach($sluzbenik->prebivaliste as $preb)--}}
                                    {{--<li>--}}
                                        {{--<b>Adresa prebivališta</b>: {{ $preb->adresa_prebivalista }}<br/>--}}
                                        {{--<b>Mjesto prebivališta</b>: {{ $preb->mjesto_prebivalista }}<br/>--}}
                                        {{--<b>Adresa boravišta</b>: {{ $preb->adresa_boravista }}<br/>--}}
                                        {{--<hr/>--}}
                                    {{--</li>--}}
                                {{--@endforeach--}}
                            {{--</ul>--}}
                        {{--</td>--}}

                        <!---- Stručna sprema službenika ---->
                        <td>
                            @if($sluzbenik->strucna_sprema)
                                <ul>
                                    @foreach($sluzbenik->strucna_sprema as $sprema)
                                        <li>
                                            {{ $sprema->stepen_s_s }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>
                            @if($sluzbenik->strucna_sprema)
                                <ul>
                                    @foreach($sluzbenik->strucna_sprema as $sprema)
                                        <li>
                                            {{ $sprema->obrazovna_institucija }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                    {{--<td>--}}
                    {{--<ul style="list-style: none; margin: 0; padding: 0;">--}}
                    {{--@foreach(($sluzbenik->strucna_sprema ? $sluzbenik->strucna_sprema : []) as $ss)--}}
                    {{--<li>--}}
                    {{--<b>Stepen stručne spreme</b>: {{ $ss->stepen_s_s }}<br/>--}}
                    {{--<b>Obrazovna institucija</b>: {{ $ss->obrazovna_institucija }}<br/>--}}

                    {{--<!-- Diploma poslana na provjeru ; Ovdje ćemo hard coding uraditi za DA ili JE -->--}}
                    {{--<!-- TODO: -->--}}

                    {{--@if($ss->diploma_poslana_na_provjeru)--}}
                    {{--<b>Diploma poslana na provjeru</b>: DA<br/>--}}
                    {{--@else--}}
                    {{--<b>Diploma poslana na provjeru</b>: NE<br/>--}}
                    {{--@endif--}}

                    {{--<!-- ------------------------------------------------------------------------- -->--}}
                    {{--<b>Nostrifikacija</b>: {{ $ss->nostrifikacija }}<br/>--}}
                    {{--<b>Datum zavšetka</b>: {{ $ss->datum_zavrsetka }}<br/>--}}

                    {{--</li>--}}
                    {{--@endforeach--}}
                    {{--</ul>--}}
                    {{--</td>--}}




                        <!-- Ispiti službenika -->
                        <td>
                            <ul style="list-style: none; margin: 0; padding: 0;">
                                @foreach(($sluzbenik->ispiti) ? $sluzbenik->ispiti : [] as $ispiti)
                                    <li>
                                        <b>Ispit za rad u organima JU</b>: {{ $ispiti->ispit_za_rad }}<br/>
                                        <b>Pravosudni ispit</b>: {{ $ispiti->pravosudni_isp }}<br/>
                                        <b>Stručni ispit</b>: {{ $ispiti->strucni_isp }}<br/>
                                        <b>Datum završetka</b>: {{ $ispiti->datum_zavrsetka }}<br/>
                                        <b>Nostrifikacija</b>: {{ $ispiti->nostrifikacija }}<br/>
                                        <hr/>
                                    </li>
                                @endforeach
                            </ul>
                        </td>

                        <!-- Kontakt detalji službenika -->
                        <td>
                            <ul style="list-style: none; margin: 0; padding: 0;">
                                @foreach(($sluzbenik->kontakt_detalji) ? $sluzbenik->kontakt_detalji : [] as $kontakt)
                                    <li>
                                        <b>Službeni telefon</b>: {{ $kontakt->sluzbeni_tel }}<br/>
                                        <b>Službeni email</b>: {{ $kontakt->sluzbeni_mail }}<br/>
                                        <b>Privatni telefon</b>: {{ $kontakt->mobilni_tel }}<br/>
                                        <b>Privatni e-mail</b>: {{ $kontakt->email }}<br/>
                                        <hr/>
                                    </li>
                                @endforeach
                            </ul>
                        </td>

                        <!-- TODO: Hard kodirati određene šifrarnike; Ne postoji drugi način !! -->
                        <!-- Vještine službenika -->
                        <td>
                            <ul style="list-style: none; margin: 0; padding: 0;">
                                @foreach(($sluzbenik->vjestine ? $sluzbenik->vjestine : []) as $vjestine)
                                    <li>
                                        <b>Vrsta vještine</b>: {{ $vjestine->vrsta_vjestine }}<br/>
                                        <b>Nivo vještine</b>: {{ $vjestine->nivo_vjestine }}<br/>
                                        <b>Institucija</b>: {{ $vjestine->institucija }}<br/>
                                        <b>Broj uvjerenja</b>: {{ $vjestine->broj_uvjerenja }}<br/>
                                        <b>Datum uvjerenja</b>: {{ $vjestine->datum_uvjerenja }}<br/>
                                        <hr/>
                                    </li>
                                @endforeach
                            </ul>
                        </td>

                        <!-- Zasnivanje radnog odnosa -->
                        <td>
                            <ul style="list-style: none; margin: 0; padding: 0;">
                                @foreach(($sluzbenik->zasnivanje_r_o ? $sluzbenik->zasnivanje_r_o : []) as $zasnivanje)
                                    <li>
                                        <b>Datum zasnivanja radnog odnosa</b>: {{ $zasnivanje->datum_zasnivanja_o }}
                                        <br/>
                                        <b>Način zasnivanja radnog odnosa</b>: {{ $zasnivanje->nacin_zasnivanja_r_o }}
                                        <br/>
                                        <b>Vrsta radnog odnosa</b>: {{ $zasnivanje->vrsta_r_o }}<br/>
                                        <b>Obračunati radni staž</b>: {{ $zasnivanje->obracunati_r_staz }}<br/>
                                        <b>Obračunati radni staž godina</b>: {{ $zasnivanje->obracunati_r_s_god }}<br/>
                                        <b>Obračunati radni staž mjeseci</b>: {{ $zasnivanje->obracunati_r_s_mje }}<br/>
                                        <b>Obračunati radni staž dana</b>: {{ $zasnivanje->obracunati_r_s_dan }}<br/>
                                        <hr/>
                                    </li>
                                @endforeach
                            </ul>
                        </td>

                        <!-- Prethodno radno iskustvo -->
                        <td>
                            <ul style="list-style: none; margin: 0; padding: 0;">
                                @foreach(($sluzbenik->prethodno_r_i) ? $sluzbenik->prethodno_r_i : [] as $prethodno )
                                    <li>
                                        <b>Poslodavac</b>: {{ $prethodno->poslodavac }}<br/>
                                        <b>Sjedište poslodavca</b>: {{ $prethodno->sjediste_poslodavca }}<br/>
                                        <b>Datum početka</b>: {{ $prethodno->period_zaposlenja_od }}<br/>
                                        <b>Datum završetka</b>: {{ $prethodno->period_zaposlenja_do }}<br/>
                                        <b>Radno vrijeme</b>: {{ $prethodno->radno_vrijeme }}<br/>
                                        <b>Opis poslova</b>: {{ $prethodno->opis_poslova }}<br/>
                                        <b>Stečeno radno iskustvo</b>: {{ $prethodno->steceno_radno_iskustvo }}<br/>
                                        <b>Ostvareni radni staž</b>: {{ $prethodno->ostvareni_radni_staz }}<br/>
                                        <b>Staž osiguranja</b>: {{ $prethodno->staz_osiguranja }}<br/>
                                        <b>Dobrovoljno osiguranje</b>: {{ $prethodno->dobrovoljno_osiguranje }}<br/>
                                        <b>Penzioni staž</b>: {{ $prethodno->penzioni_staz }}<br/>
                                        <b>Staž sa uvećanim trajanjem</b>: {{ $prethodno->staz_sa_uvecanim_trajanjem }}
                                        <br/>
                                        <b>Država gdje je staž ostvaren</b>: {{ $prethodno->drzava_sa_stazom }}<br/>
                                        <b>Trajanje staža u državi</b>: {{ $prethodno->trajanje_staza_u_drzavi }}<br/>
                                        <hr/>
                                    </li>
                                @endforeach
                            </ul>
                        </td>

                        <!-- Prestanak radnog odnosa -->
                        <td>
                            <ul style="list-style: none; margin: 0; padding: 0;">
                                @foreach(($sluzbenik->prestanak_ro) ? $sluzbenik->prestanak_ro : [] as $prestanak)
                                    <li>
                                        <b>Datum prestanka</b>: {{ $prestanak->datum_prestanka }}<br/>
                                        <b>Osnov za prestanak</b>: {{ $prestanak->osnov_za_prestanak }}<br/>
                                        <hr/>
                                    </li>
                                @endforeach
                            </ul>
                        </td>

                        <!-- Članovi porodice -->
                        <td>
                            <ul style="list-style: none; margin: 0; padding: 0;">
                                @foreach(($sluzbenik->clanovi_porodice) ? $sluzbenik->clanovi_porodice : [] as $clanovi )
                                    <li>
                                        <b>Srodstvo</b>: {{ $clanovi->srodstvo }}<br/>
                                        <b>Datum rođenja</b>: {{ $clanovi->datum_rodjenja }}<br/>
                                        <hr/>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td style="text-align:center;" class="akcije">
                            @if(isset($odsustva))
                                <a href="{{ '/hr/odsustva/kalendar/' . $sluzbenik->id }}">
                                    <i class="fa fa-eye"></i> Odsustva
                                </a>
                            @elseif(isset($uloge))
                                <a href="{{ '/uloge/dodijeliUlogu/' . $sluzbenik->id }}">
                                    <i class="fa fa-eye"></i> Uredite uloge
                                </a>
                            @else
                                <a href="{{ '/hr/sluzbenici/uredi_sluzbenika/' . $sluzbenik->id }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{ '/hr/sluzbenici/dodatno_o_sluzbeniku/' . $sluzbenik->id }}"
                                   style="margin-left:10px;">
                                    <i class="fa fa-eye"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <br/>


        </div>
    </div>
@endsection