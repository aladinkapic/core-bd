@extends('template.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card bg-light">
                    <div class="card-header ads-darker">
                        {{__(' HR Aktivnosti')}}
                    </div>
                    <div class="card-body hr-activity">
                        <div class="row">
                            <div class="stat-card info-border col-md-3">
                                <div class="stat-card-body">
                                    {{$sluzbenika}}
                                </div>
                                <span>{{__('Državnih službenika')}}</span>
                            </div>
                            <div class="stat-card grey-border col-md-3">
                                <div class="stat-card-body">
                                    {{$broj_obuka}}
                                </div>
                                <span>{{__('Otvorenih obuka')}}</span>
                            </div>
                            <div class="stat-card success-border col-md-3">
                                <div class="stat-card-body">
                                    {{$interno_trzis}}
                                </div>
                                <span>{{__('Upražnjenih radnih mjesta')}}</span>
                            </div>
                            <div class="stat-card danger-border col-md-3"
                                 onclick="window.location='/obavijesti/pregled';">
                                <div class="stat-card-body">
                                    69
                                </div>
                                <span>{{__('Obavjesti')}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <br/>

                <div class="card bg-light">
                    <div class="card-header ads-darker">
                        {{__('Registar ljudskih resursa')}}
                    </div>
                    <div class="card-body hr-activity tab">
                        <div class="row">
                            @if(\App\Models\Sluzbenik::hasRole('radna_mjesta', $me))
                                <a href="/hr/radna_mjesta/home" class="stat-card stat-card-light col-md-3">
                                    <div class="stat-card-body">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                    <span>{{__('Radna mjesta')}}</span>
                                </a>
                            @endif

                            @if(\App\Models\Sluzbenik::hasRole('unutrasnja_org', $me))
                                <a href="{{ route('organizacija.index') }}" class="stat-card stat-card-light col-md-3">
                                    <div class="stat-card-body">
                                        <i class="fas fa-sitemap"></i>
                                    </div>
                                    <span>{{__('Unutrašnja organizacija')}}</span>
                                </a>
                            @endif

                            @if(\App\Models\Sluzbenik::hasRole('organ_ju', $me))
                                <a href="/hr/organ_javne_uprave/home" class="stat-card stat-card-light col-md-3">
                                    <div class="stat-card-body">
                                        <i class="fas fa-project-diagram"></i>
                                    </div>
                                    <span>{{__('Organ javne uprave')}}</span>
                                </a>
                            @endif

                            @if(\App\Models\Sluzbenik::hasRole('sluzbenici', $me))
                                <a href="{{route('sluzbenik.pregled')}}" class="stat-card stat-card-light col-md-3">
                                    <div class="stat-card-body">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <span>{{__('Državni službenici')}}</span>
                                </a>
                            @endif

                            @if(\App\Models\Sluzbenik::hasRole('regitar_ugovora', $me))
                                <a href="{{ route('ugovor.index') }}" class="stat-card stat-card-light  col-md-3">
                                    <div class="stat-card-body">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <span>{{__('Registar ugovora')}}</span>
                                </a>
                            @endif

                            @if(\App\Models\Sluzbenik::hasRole('odsustva', $me))
                                <a href="{{route('odsustva.izaberi', ['odsustva'=>'true'])}}"
                                   class="stat-card stat-card-light col-md-3">
                                    <div class="stat-card-body">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <span>{{__('Odsustva')}}</span>
                                </a>
                            @endif

                            @if(\App\Models\Sluzbenik::hasRole('upravljanje_ucin', $me))
                                <a href="/hr/upravljanje_ucinkom/home" class="stat-card stat-card-light col-md-3">

                                    <div class="stat-card-body">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                    <span>{{__('Upravljanje učinkom')}}</span>

                                </a>
                            @endif

                            @if(\App\Models\Sluzbenik::hasRole('disciplinska_odg', $me))
                                <a href="/hr/disciplinska_odgovornost/home" class="stat-card stat-card-light col-md-3">
                                    <div class="stat-card-body">
                                        <i class="fas fa-gavel"></i>
                                    </div>
                                    <span>{{__('Disciplinska odgovornost')}}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <br/>

                <div class="card bg-light">
                    <div class="card-header ads-darker">
                        {{__('Zapošljavanje')}}
                    </div>
                    <div class="card-body hr-activity tab">
                        <div class="row">
                            @if(\App\Models\Sluzbenik::hasRole('predavaci', $me))
                                <a href="{{route('ekonkurs.request')}}" class="stat-card stat-card-light col-md-3">
                                    <div class="stat-card-body">
                                        <i class="fas fa-bars"></i>
                                    </div>
                                    <span>{{__('E-konkurs')}}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <br/>

                <div class="card bg-light">
                    <div class="card-header ads-darker">
                        {{__('Program stručnog usavršavanja')}}
                    </div>
                    <div class="card-body hr-activity tab">
                        <div class="row">

                            @if(\App\Models\Sluzbenik::hasRole('predavaci', $me))
                                <a href="osposobljavanje_i_usavrsavanje/obuke/home"
                                   class="stat-card stat-card-light col-md-3">
                                    <div class="stat-card-body">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                    <span>{{__('Obuke')}}</span>
                                </a>
                            @endif

                            @if(\App\Models\Sluzbenik::hasRole('predavaci', $me))
                                <a href="/osposobljavanje_i_usavrsavanje/predavaci/home"
                                   class="stat-card stat-card-light col-md-3">
                                    <div class="stat-card-body">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </div>
                                    <span>{{__('Predavači')}}</span>
                                </a>
                            @endif

                            @if(\App\Models\Sluzbenik::hasRole('teme_za_obuku', $me))
                                <a href="/osposobljavanje_i_usavrsavanje/teme/home"
                                   class="stat-card stat-card-light col-md-3">
                                    <div class="stat-card-body">
                                        <i class="fas fa-list-ul"></i>
                                    </div>
                                    <span>{{__('Teme za obuku')}}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <br/>

                <div class="card bg-light">
                    <div class="card-header ads-darker">
                        {{__('Ostalo')}}
                    </div>
                    <div class="card-body hr-activity tab">
                        <div class="row">
                            @if(\App\Models\Sluzbenik::hasRole('interno_trziste', $me))
                                <a href="{{route('internotrziste.pregled')}}"
                                   class="stat-card stat-card-light col-md-3">
                                    <div class="stat-card-body">
                                        <i class="fas fa-bookmark"></i>
                                    </div>
                                    <span>{{__('Interno tržište rada')}}</span>
                                </a>
                            @endif

                            @if(\App\Models\Sluzbenik::hasRole('stratesko_pl', $me))
                                <a href="{{route('pregled.strateskogplaniranja')}}"
                                   class="stat-card stat-card-light col-md-3">
                                    <div class="stat-card-body">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <span>{{__('Strateško planiranje')}}</span>
                                </a>
                            @endif

                            @if(\App\Models\Sluzbenik::hasRole('izvjestaji', $me))
                                <a href="{{route('izvjestaji.pregled')}}" class="stat-card stat-card-light col-md-3">
                                    <div class="stat-card-body">
                                        <i class="fas fa-clone"></i>
                                    </div>
                                    <span>{{__('Izvještaji')}}</span>
                                </a>
                            @endif

                            @if(\App\Models\Sluzbenik::hasRole('historizacija', $me))
                                <a href="/ostalo/historizacija/home" class="stat-card stat-card-light col-md-3">
                                    <div class="stat-card-body">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <span>{{__('Historizacija')}}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @foreach($notifications as $notification)
                    <div class="alert alert-danger my-custom-alert" role="alert"
                         id="notification-id-{{$notification->sluzbenik->id}}">
                        Obavijest : Službenik
                        <a href="{{Route('sluzbenik.dodatno', ['id' => $notification->sluzbenik->id])}}">{{$notification->sluzbenik->ime}} {{$notification->sluzbenik->prezime}}</a>
                        {{json_decode($notification->data, true)['poruka']}}

                        {{--@if(json_decode($notification->data, true)['what'] == 'zasnivanjeRO')--}}
                        {{----}}
                        {{--@elseif(json_decode($notification->data, true)['what'] == 'penzionisanje')--}}
                        {{--<a href="{{Route('sluzbenik.dodatno', ['id' => $notification->sluzbenik->id])}}">{{$notification->sluzbenik->ime}} {{$notification->sluzbenik->prezime}}</a>--}}
                        {{--stiče pravo na penzionisanje za manje od 8 mjeseci.--}}
                        {{--@elseif(json_decode($notification->data, true)['what'] == 'starosna_dob')--}}
                        {{--<a href="{{Route('sluzbenik.dodatno', ['id' => $notification->sluzbenik->id])}}">{{$notification->sluzbenik->ime}} {{$notification->sluzbenik->prezime}}</a>--}}
                        {{--je upravo napunio 64 godine života. Molimo vas poduzmite određene akcije.--}}
                        {{--@endif--}}

                        <div class="oznaci_kao_procitano"
                             onclick="sakrijNotifikacije('{{$notification->sluzbenik->id}}', '{{$notification->id}}');">
                            <p>OZNAČI KAO PROČITANO</p>
                        </div>
                    </div>
                @endforeach

                <example-component></example-component>

                <br/>

                <div class="card bg-light">
                    <div class="card-header ads-darker">
                        {{__('Nadolazeće instance obuke')}}
                    </div>
                    <ul class="list-group">
                        @if (!isset($obukeNotifikacija))
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{__('Nema aktivnih obuka!')}}
                            </li>
                        @endif
                        @if (isset ($obukeNotifikacija))
                            @foreach($obukeNotifikacija as $notifikacija)
                                <li class="list-group-item d-flex justify-content-between align-items-center"
                                    onclick="window.location = '/osposobljavanje_i_usavrsavanje/obuke/instance/{{$notifikacija['id']}}';
                                            on">
                                    <div class="col-12 row" style="padding-right: 0;">
                                        <div class="col-5">
                                            {{$notifikacija['naziv']}}
                                        </div>
                                        <div class="col-5" style="padding-right: 0 !important;">
                                            {{$notifikacija['od'].' Do '.$notifikacija['do']}}
                                        </div>
                                        @if (isset($notifikacija['doDanas']))
                                            <div class="col-2" style="padding-right: 0 !important;">
                                                <span class="badge badge-warning badge-pill">{{'Za: '.$notifikacija['doDanas'].' dana'}}</span>
                                            </div>
                                        @else
                                            <div class="col-2" style="padding-right: 0 !important;">
                                                <span class="badge badge-success badge-pill">{{__('U toku')}}</span>
                                            </div>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <br>

                <div class="card bg-light">
                    <div class="card-header ads-darker">
                        Statistika
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Službenici koji stiču pravo na penzionisanje
                            <span class="badge badge-primary badge-pill">14</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Ukupno upražnjenih radni mjesta
                            <span class="badge badge-primary badge-pill">2</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Privremeno premještenih službenika
                            <span class="badge badge-primary badge-pill">1</span>
                        </li>
                    </ul>
                </div>

                <br/>


                <div class="card bg-light">
                    <div class="card-header ads-darker">
                        Brzi linkovi
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a target="_blank" href="http://www.vlada.bdcentral.net/">
                                Vlada Brčko Distrikta Web Stranica
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a target="_blank" href="#">
                                eKonkurs Sistem
                            </a>
                        </li>
                    </ul>
                </div>

            <!--
                <div class="card bg-light">
                    <div class="card-header ads-darker">

                    </div>
                    <ul class="card-body">
                        <ul class="list-group">
                            <a href="#">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Službenici koji stiču pravo na penzionisanje
                                    <span class="badge badge-primary badge-pill">14</span>
                                </li>
                            </a>
                            <a href="{{ route('internotrziste.pregled') }}">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Upražnjena radna mjesta
                                    <span class="badge badge-primary badge-pill">2</span>
                                </li>
                            </a>
                            <a href="{{ route('internotrziste.privremeni.premjestaj') }}">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Privremeno premješteni službenici
                                    <span class="badge badge-primary badge-pill">1</span>
                                </li>
                            </a>
                        </ul>
                    </ul>
                </div>

                -->
            </div>
        </div>
    </div>
@endsection
