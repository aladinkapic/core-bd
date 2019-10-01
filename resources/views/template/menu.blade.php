<div class="blue-menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-md-2 text-center">
                        {{ Html::Image('images/grb-bih.png', '', ['width' => 64]) }}
                    </div>
                    <div class="col-md-7">
                        <h3>Vlada Brčko Distrikta</h3>
                        Pododjeljenje za ljudske resurse
                    </div>
                </div>
            </div>
            <div class="col-sm-3 ">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            {{ $me->ime ?? '/'}} {{ $me->prezime ?? '/'}}
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('sluzbenik.dodatno', ['id' => $me->id]) }}">Moj
                                karton</a>
                            {{--<a class="dropdown-item" href="{{ route('svi.sifrarnici') }}">Notifikacije</a>--}}
                            {{--<a class="dropdown-item" href="{{ route('svi.sifrarnici') }}">Podešavanja</a>--}}
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/odjavi_me">Odjava</a>
                        </div>
                    </div>
                    {{--<div class="col-md-3">--}}
                    {{--<button type="button" class="btn btn-inverse-light">--}}
                    {{--<i class="fa fa-bell"></i>--}}
                    {{--</button>--}}
                    {{--</div>--}}
                </div>


            <!---
                    <span class="btn btn-light pull-right">
                        <!---{{ Html::Image('images/user.jpg', '', array('class' => 'rounded small-pic')) }}
                    <i class="fa fa-user"></i>
                Haris Muharemović
                <i style="padding-left: 10px;" class="fa fa-caret-down"></i>
            </span>
            --->
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark indigo">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <li class="collapse navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="/home"> <i class="fa fa-home"></i> Početna</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-users"></i> HR registar
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        @if(\App\Models\Sluzbenik::hasRole('radna_mjesta', $me))
                            <a class="dropdown-item" href="/hr/radna_mjesta/home">Radna mjesta</a>
                        @endif
                        @if(\App\Models\Sluzbenik::hasRole('unutrasnja_org', $me))
                            <a class="dropdown-item" href="{{ route('organizacija.index') }}">Unutrašnja
                                organizacija</a>
                        @endif
                        @if(\App\Models\Sluzbenik::hasRole('organ_ju', $me))
                            <a class="dropdown-item" href="/hr/organ_javne_uprave/home">Organ javne uprave</a>
                        @endif
                        @if(\App\Models\Sluzbenik::hasRole('sluzbenici', $me))
                            <a class="dropdown-item" href="{{route('sluzbenik.pregled')}}">Državni službenici</a>
                        @endif
                        @if(\App\Models\Sluzbenik::hasRole('regitar_ugovora', $me))
                            <a class="dropdown-item" href="{{ route('ugovor.index') }}">Registar ugovora</a>
                        @endif
                        @if(\App\Models\Sluzbenik::hasRole('odsustva', $me))
                            <a class="dropdown-item"
                               href="{{route('odsustva.izaberi', ['odsustva'=>'true'])}}">{{__('Odsustva')}}</a>
                        @endif
                        @if(\App\Models\Sluzbenik::hasRole('upravljanje_ucin', $me))
                            <a class="dropdown-item" href="/hr/upravljanje_ucinkom/home">Upravljanje učinkom</a>
                        @endif
                        @if(\App\Models\Sluzbenik::hasRole('disciplinska_odg', $me))
                            <a class="dropdown-item" href="/hr/disciplinska_odgovornost/home">Disciplinska
                                odgovornost</a>
                        @endif
                    </div>
                </li>
                <li class="nav-item">
                    @if(\App\Models\Sluzbenik::hasRole('ekonkurs', $me))
                        <a class="nav-link" href="{{route('ekonkurs.request')}}"> <i class="fa fa-link"></i> eKonkurs
                            Prijava </a>
                    @endif
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-graduation-cap"></i> Osposobljavanje i usavršavanje
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        @if(\App\Models\Sluzbenik::hasRole('obuke', $me))
                            <a class="dropdown-item" href="/osposobljavanje_i_usavrsavanje/obuke/home">Obuke</a>
                        @endif
                        @if(\App\Models\Sluzbenik::hasRole('predavaci', $me))
                            <a class="dropdown-item" href="/osposobljavanje_i_usavrsavanje/predavaci/home">Predavači</a>
                        @endif
                        @if(\App\Models\Sluzbenik::hasRole('teme_za_obuku', $me))
                            <a class="dropdown-item" href="/osposobljavanje_i_usavrsavanje/teme/home">Teme za obuku</a>
                        @endif
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-egg"></i> Ostalo
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        @if(\App\Models\Sluzbenik::hasRole('interno_trziste', $me))
                            <a class="dropdown-item" href="{{route('internotrziste.pregled')}}">Interno tržište rada</a>
                        @endif
                        @if(\App\Models\Sluzbenik::hasRole('stratesko_pl', $me))
                            <a class="dropdown-item" href="{{route('pregled.strateskogplaniranja')}}">Strateško
                                planiranje</a>
                        @endif
                        @if(\App\Models\Sluzbenik::hasRole('izvjestaji', $me))
                            <a class="dropdown-item" href="{{route('izvjestaji.pregled')}}">Izvještaji</a>
                        @endif
                        @if(\App\Models\Sluzbenik::hasRole('historizacija', $me))
                            <a class="dropdown-item" href="/ostalo/historizacija/home">Historizacija</a>
                        @endif
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"> <i class="fa fa-headset"></i> Podrška</a>
                </li>
                @if(\App\Models\Sluzbenik::hasRole('postavke', $me))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-cogs"></i> Postavke
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/hr/odsustva/praznici/dodaj">Praznici</a>
                            <a class="dropdown-item" href="/hr/odsustva/limiti">Limit odsustva</a>
                            <a class="dropdown-item" href="{{route('svi.sifrarnici')}}">Šifrarnici</a>
                            <a class="dropdown-item" href="{{route('izvjestaji.pregled.uloga')}}">Uloge</a>
                        </div>
                    </li>
                @endif
            </ul>
        </li>
    </div>
</nav>
