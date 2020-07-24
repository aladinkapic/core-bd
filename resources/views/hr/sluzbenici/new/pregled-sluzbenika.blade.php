@extends('template.main')
@section('title') {{__('Dodajte novog službenika')}} @stop

<!-- css links -->
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('sluzbenik.pregled') => __('Lista državnih službenika'),
        route('sluzbenik.dodatno', ['id_sluzbenika' => $sluzbenik->id]) => $sluzbenik->ime.' '.$sluzbenik->prezime,
    ]) !!}

@stop

<!-- js  links -->
@section('other_js_links')

@stop

@section('content')
    <div class="container ">
        <div class="card-body hr-activity tab full_container" style="padding-top:0px; padding-bottom:0px;">
            <section class="multi_step_form">
                <div id="msform">
                    <div id="steps-window">
                        <ul>
                            <li class="active">
                                <div class="list_div">
                                    <div class="back_div"></div>
                                    <div class="icon_circle" >
                                        <i class="fas fa-user" style="padding-top:0px;"></i>
                                    </div>
                                    <p>
                                        {{$sluzbenik->ime ?? '/'}} {{$sluzbenik->prezime ?? '/'}}
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>

        <div class="row p-4">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        @include('hr.sluzbenici.new.forme.forme-includes.dodaj-sluzbenika')
                    </div>
                </div>
            </div>
            <div class="col-md-3 p-0">
                <div class="card-body hr-activity tab full_container container_block" style="">
                    <div class="split_container split_container3" style="height:360px; margin-top:-14px;">
                        <a href="{{ route('ispis.sluzbenika', ['id' => $sluzbenik->id]) }}">
                            <i style="color:saddlebrown; margin-bottom: 1rem; margin-left: 1rem;"  class="fas fa-print fa-2x" title="Ispis kartona službenika"></i>
                        </a>
                        <div class="slika_sluzbenika">
                            <img src="{{ asset('slike/slike_sluzbenika/'.$sluzbenik->fotografija ?? '/') }}" id="slika_sluz" alt="">
                            <input type="hidden" name="fotografija" id="fotografija">
                            <div class="slika_sluzbenika_sjena" title="Fotografija "></div>
                        </div>

                        <div class="basic_info">
                            <h3>{{$sluzbenik->ime.' '.$sluzbenik->prezime ?? '/'}}</h3>
                        </div>

                        <div class="basic_info">
                            <a href="{{route('drzavni-sluzbenici.uredite-sluzbenika', ['id' => $sluzbenik->id ?? ''])}}">
                                <p>{{__('Uredite karton radnika')}}</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PREBIVALIŠTE SLUŽBENIKA -->
        <div class="row p-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="row">
                            <div class="col-md-10">
                                <h5 class="m-0 p-0">Podaci o prebivalištu</h5>
                            </div>
                            <div class="col-md-2 d-flex flex-row-reverse">
                                <a href="{{route('drzavni-sluzbenici.prebivaliste.dodaj', ['sl-id' => $sluzbenik->id ?? ''])}}">
                                    <i class="fas fa-plus-square text-success" title="Unesite nove informacije o prebivalištu službenika"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @foreach($prebivalista as $prebivaliste)
                        <div class="card-body border-bottom pt-4 pb-3">
                            <div class="row edit-feature-box">
                                <div class="col-md-12 d-flex flex-row-reverse">
                                    <a href="{{route('drzavni-sluzbenici.prebivaliste.uredi', ['sl-id' => $prebivaliste->id ?? ''])}}">
                                        <i class="fas fa-edit text-primary" title="Izmijenite sadržaj"></i>
                                    </a>
                                    <a href="{{route('drzavni-sluzbenici.prebivaliste.obrisi', ['id' => $prebivaliste->id ?? ''])}}">
                                        <i class="fas fa-trash text-danger mr-3" title="Obrišite sadržaj"></i>
                                    </a>
                                </div>
                            </div>
                            @include('hr.sluzbenici.new.forme.forme-includes.prebivaliste')
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <!-- PODACI O STRUČNOJ SPREMI -->
        <div class="row p-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="row">
                            <div class="col-md-10">
                                <h5 class="m-0 p-0">Podaci o stručnoj spremi traženoj konkursom</h5>
                            </div>
                            <div class="col-md-2 d-flex flex-row-reverse">
                                <a href="{{route('drzavni-sluzbenici.strucna-sprema.dodaj', ['sl-id' => $sluzbenik->id ?? ''])}}">
                                    <i class="fas fa-plus-square text-success" title="Unesite nove informacije o stručnoj spremi"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @foreach($strucne_spreme as $strucna_sprema)
                        <div class="card-body border-bottom pt-4 pb-3">
                            <div class="row edit-feature-box">
                                <div class="col-md-12 d-flex flex-row-reverse">
                                    <a href="{{route('drzavni-sluzbenici.strucna-sprema.uredi', ['sl-id' => $strucna_sprema->id ?? ''])}}">
                                        <i class="fas fa-edit text-primary" title="Izmijenite sadržaj"></i>
                                    </a>
                                    <a href="{{route('drzavni-sluzbenici.strucna-sprema.obrisi', ['id' => $strucna_sprema->id ?? ''])}}">
                                        <i class="fas fa-trash text-danger mr-3" title="Obrišite sadržaj"></i>
                                    </a>
                                </div>
                            </div>
                            @include('hr.sluzbenici.new.forme.forme-includes.strucna-sprema')
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <!-- POLOŽENI ISPITI -->
        <div class="row p-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="row">
                            <div class="col-md-10">
                                <h5 class="m-0 p-0">Položeni ispiti</h5>
                            </div>
                            <div class="col-md-2 d-flex flex-row-reverse">
                                <a href="{{route('drzavni-sluzbenici.ispit.dodaj', ['sl-id' => $sluzbenik->id ?? ''])}}">
                                    <i class="fas fa-plus-square text-success" title="Unesite nove informacije o položenim ispitima"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @foreach($ispiti as $ispit)
                        <div class="card-body border-bottom pt-4 pb-3">
                            <div class="row edit-feature-box">
                                <div class="col-md-12 d-flex flex-row-reverse">
                                    <a href="{{route('drzavni-sluzbenici.ispit.uredi', ['sl-id' => $ispit->id ?? ''])}}">
                                        <i class="fas fa-edit text-primary" title="Izmijenite sadržaj"></i>
                                    </a>
                                    <a href="{{route('drzavni-sluzbenici.ispit.obrisi', ['id' => $ispit->id ?? ''])}}">
                                        <i class="fas fa-trash text-danger mr-3" title="Obrišite sadržaj"></i>
                                    </a>
                                </div>
                            </div>
                            @include('hr.sluzbenici.new.forme.forme-includes.ispiti')
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <!-- OBRAZOVANJE SLUŽBENIKA -->
        <div class="row p-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="row">
                            <div class="col-md-10">
                                <h5 class="m-0 p-0">Obrazovanje službenika</h5>
                            </div>
                            <div class="col-md-2 d-flex flex-row-reverse">
                                <a href="{{route('drzavni-sluzbenici.obrazovanje.dodaj', ['sl-id' => $sluzbenik->id ?? ''])}}">
                                    <i class="fas fa-plus-square text-success" title="Unesite nove informacije o obrazovanju službenika"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @foreach($obrazovanja as $obrazovanje)
                        <div class="card-body border-bottom pt-4 pb-3">
                            <div class="row edit-feature-box">
                                <div class="col-md-12 d-flex flex-row-reverse">
                                    <a href="{{route('drzavni-sluzbenici.obrazovanje.uredi', ['sl-id' => $obrazovanje->id ?? ''])}}">
                                        <i class="fas fa-edit text-primary" title="Izmijenite sadržaj"></i>
                                    </a>
                                    <a href="{{route('drzavni-sluzbenici.obrazovanje.obrisi', ['id' => $obrazovanje->id ?? ''])}}">
                                        <i class="fas fa-trash text-danger mr-3" title="Obrišite sadržaj"></i>
                                    </a>
                                </div>
                            </div>
                            @include('hr.sluzbenici.new.forme.forme-includes.obrazovanje')
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <!-- DODATNE VJEŠTINE -->
        <div class="row p-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="row">
                            <div class="col-md-10">
                                <h5 class="m-0 p-0">Dodatne vještine</h5>
                            </div>
                            <div class="col-md-2 d-flex flex-row-reverse">
                                <a href="{{route('drzavni-sluzbenici.vjestine.dodaj', ['sl-id' => $sluzbenik->id ?? ''])}}">
                                    <i class="fas fa-plus-square text-success" title="Unesite nove informacije o vještinama službenika"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @foreach($vjestine as $vjestina)
                        <div class="card-body border-bottom pt-4 pb-3">
                            <div class="row edit-feature-box">
                                <div class="col-md-12 d-flex flex-row-reverse">
                                    <a href="{{route('drzavni-sluzbenici.vjestine.uredi', ['sl-id' => $vjestina->id ?? ''])}}">
                                        <i class="fas fa-edit text-primary" title="Izmijenite sadržaj"></i>
                                    </a>
                                    <a href="{{route('drzavni-sluzbenici.vjestine.obrisi', ['id' => $vjestina->id ?? ''])}}">
                                        <i class="fas fa-trash text-danger mr-3" title="Obrišite sadržaj"></i>
                                    </a>
                                </div>
                            </div>
                            @include('hr.sluzbenici.new.forme.forme-includes.vjestine')
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <!-- RADNI STAŽ KOD PRETHODNIH POSLODAVACA -->
        <div class="row p-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="row">
                            <div class="col-md-10">
                                <h5 class="m-0 p-0">Radni staž kod prethodnih poslodavaca</h5>
                            </div>
                            <div class="col-md-2 d-flex flex-row-reverse">
                                <a href="{{route('drzavni-sluzbenici.prethodni-rs.dodaj', ['sl-id' => $sluzbenik->id ?? ''])}}">
                                    <i class="fas fa-plus-square text-success" title="Unesite nove informacije o radnom stažu"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @foreach($prethodniRS as $prethodni)
                        <div class="card-body border-bottom pt-4 pb-3">
                            <div class="row edit-feature-box">
                                <div class="col-md-12 d-flex flex-row-reverse">
                                    <a href="{{route('drzavni-sluzbenici.prethodni-rs.uredi', ['sl-id' => $prethodni->id ?? ''])}}">
                                        <i class="fas fa-edit text-primary" title="Izmijenite sadržaj"></i>
                                    </a>
                                    <a href="{{route('drzavni-sluzbenici.prethodni-rs.obrisi', ['id' => $prethodni->id ?? ''])}}">
                                        <i class="fas fa-trash text-danger mr-3" title="Obrišite sadržaj"></i>
                                    </a>
                                </div>
                            </div>
                            @include('hr.sluzbenici.new.forme.forme-includes.prethodni-rs')
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <!-- ZASNIVANJE RADNOG ODNOSA -->
        <div class="row p-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="row">
                            <div class="col-md-10">
                                <h5 class="m-0 p-0">Zasnivanje radnog odnosa</h5>
                            </div>
                            <div class="col-md-2 d-flex flex-row-reverse">
                                <a href="{{route('drzavni-sluzbenici.zasnivanje-ro.dodaj', ['sl-id' => $sluzbenik->id ?? ''])}}">
                                    <i class="fas fa-plus-square text-success" title="Unesite nove informacije o radnom stažu"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @foreach($zasnivanjeRO as $radni_odnos)
                        <div class="card-body border-bottom pt-4 pb-3">
                            <div class="row edit-feature-box">
                                <div class="col-md-12 d-flex flex-row-reverse">
                                    <a href="{{route('drzavni-sluzbenici.zasnivanje-ro.uredi', ['sl-id' => $radni_odnos->id ?? ''])}}">
                                        <i class="fas fa-edit text-primary" title="Izmijenite sadržaj"></i>
                                    </a>
                                    <a href="{{route('drzavni-sluzbenici.zasnivanje-ro.obrisi', ['id' => $radni_odnos->id ?? ''])}}">
                                        <i class="fas fa-trash text-danger mr-3" title="Obrišite sadržaj"></i>
                                    </a>
                                </div>
                            </div>
                            @include('hr.sluzbenici.new.forme.forme-includes.zasnivanje-ro')
                        </div>
                    @endforeach

                </div>
            </div>
        </div>


        <!-- PRESTANAK RADNOG ODNOSA -->
        <div class="row p-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="row">
                            <div class="col-md-10">
                                <h5 class="m-0 p-0">Prestanak radnog odnosa</h5>
                            </div>
                            <div class="col-md-2 d-flex flex-row-reverse">
                                <a href="{{route('drzavni-sluzbenici.prestanak-ro.dodaj', ['sl-id' => $sluzbenik->id ?? ''])}}">
                                    <i class="fas fa-plus-square text-success" title="Unesite nove informacije o prestanku radnog odnosa"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @foreach($prestanci as $prestanak)
                        <div class="card-body border-bottom pt-4 pb-3">
                            <div class="row edit-feature-box">
                                <div class="col-md-12 d-flex flex-row-reverse">
                                    <a href="{{route('drzavni-sluzbenici.prestanak-ro.uredi', ['sl-id' => $prestanak->id ?? ''])}}">
                                        <i class="fas fa-edit text-primary" title="Izmijenite sadržaj"></i>
                                    </a>
                                    <a href="{{route('drzavni-sluzbenici.prestanak-ro.obrisi', ['id' => $prestanak->id ?? ''])}}">
                                        <i class="fas fa-trash text-danger mr-3" title="Obrišite sadržaj"></i>
                                    </a>
                                </div>
                            </div>
                            @include('hr.sluzbenici.new.forme.forme-includes.prestanak-ro')
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <!-- ČLANOVI PORODICE -->
        <div class="row p-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="row">
                            <div class="col-md-10">
                                <h5 class="m-0 p-0">Članovi porodice</h5>
                            </div>
                            <div class="col-md-2 d-flex flex-row-reverse">
                                <a href="{{route('drzavni-sluzbenici.clanovi-porodice.dodaj', ['sl-id' => $sluzbenik->id ?? ''])}}">
                                    <i class="fas fa-plus-square text-success" title="Unesite nove informacije o članovima porodice"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @foreach($clanovi_por as $clan_porodice)
                        <div class="card-body border-bottom pt-4 pb-3">
                            <div class="row edit-feature-box">
                                <div class="col-md-12 d-flex flex-row-reverse">
                                    <a href="{{route('drzavni-sluzbenici.clanovi-porodice.uredi', ['sl-id' => $clan_porodice->id ?? ''])}}">
                                        <i class="fas fa-edit text-primary" title="Izmijenite sadržaj"></i>
                                    </a>
                                    <a href="{{route('drzavni-sluzbenici.clanovi-porodice.obrisi', ['id' => $clan_porodice->id ?? ''])}}">
                                        <i class="fas fa-trash text-danger mr-3" title="Obrišite sadržaj"></i>
                                    </a>
                                </div>
                            </div>
                            @include('hr.sluzbenici.new.forme.forme-includes.clanovi-porodice')
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

    </div>
@endsection
