@extends('template.main')
@section('title') Dodajte novog službenika @stop

<!-- css links -->
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('sluzbenik.pregled') => 'Lista državnih službenika',
        route('sluzbenik.dodatno', ['id_sluzbenika' => $id_sluzbenika]) => $sluzbenik->ime.' '.$sluzbenik->prezime,
    ]) !!}

@stop

<!-- js  links -->
@section('other_js_links')

@stop

@section('content')
    <div class="container container_block">
        <div class="full_container">
            <div class="card-header ads-darker" style="height:60px;">
                @if(!isset($odsustva))
                    <button onClick="window.location='{{route('sluzbenik.pregled')}}';" class="btn btn-light float-right" ><i class="fa fa-chevron-circle-left"></i> Nazad na pregled službenika </button>
                @endif
                <h4 style="position:absolute; margin-top:-6px;">
                    {{$sluzbenik->ime ?? '/'}} {{$sluzbenik->prezime ?? '/'}}
                </h4>
            </div>
        </div>
        @include('/hr/sluzbenici/fajlovi/osnovne_info')
        <div class="split_container split_container3" style="height:360px;">
            <div class="slika_sluzbenika">
                <img src="{{ asset('slike/slike_sluzbenika/'.$sluzbenik->fotografija ?? '/') }}" id="slika_sluz" alt="">
                <input type="hidden" name="fotografija" id="fotografija">
                <div class="slika_sluzbenika_sjena" title="Fotografija "></div>
            </div>

            <div class="basic_info">
                <h3>{{$sluzbenik->ime.' '.$sluzbenik->prezime ?? '/'}}</h3>
            </div>

            <div class="basic_info">
                <a href="{{asset('/hr/sluzbenici/uredi_sluzbenika/'.$sluzbenik->id ?? '1')}}">
                    <p>Uredite karton radnika</p>
                </a>
            </div>
        </div>

        @if(isset($what))
            <div class="split_container split_container2">
                <h4 style="margin-top:0px; margin-left:15px;">
                    Rješenje o prekobrojnim ljudima za {{$sluzbenik->ime ?? '/'}} {{$sluzbenik->prezime ?? '/'}}
                </h4>

                {!! Form::textarea('', isset($sluzbenik) ? $sluzbenik->rjesenje : '', ['class' => 'form-control', 'rows' => 6, 'id' => 'naziv_rm_inp', 'readonly', 'style="margin-left:15px; width:calc(100% - 30px); margin-top:20px;"']) !!}
            </div>
        @endif

        <div class="full_container">
            <h4 style="margin-top:10px;">
                Dodatne informacije o {{$sluzbenik->ime ?? '/'}} {{$sluzbenik->prezime ?? '/'}}
            </h4>
        </div>

        <div class="split_container split_container2">
            @if ($errors->any())
                <div class="alert alert-danger">
                    Molimo Vas da popunite sva polja!
                </div>
            @endif


            @include('hr/sluzbenici/fajlovi/podaci_o_prebivalistu')

            <!--------------------------------------------------------------------------------------------------------->

            @include('hr/sluzbenici/fajlovi/podaci_o_strucnoj_spremi')

            <!--------------------------------------------------------------------------------------------------------->

            @include('hr/sluzbenici/fajlovi/ispiti')

            <!--------------------------------------------------------------------------------------------------------->

            @include('hr/sluzbenici/fajlovi/kontakt_detalji')

            <!--------------------------------------------------------------------------------------------------------->

            @include('hr/sluzbenici/fajlovi/obrazovanje_sluzbenika')

            <!--------------------------------------------------------------------------------------------------------->

            @include('hr/sluzbenici/fajlovi/vjestine')

            <!--------------------------------------------------------------------------------------------------------->

            @include('hr/sluzbenici/fajlovi/zasnivanje_radnog_odnosa')


            <!--------------------------------------------------------------------------------------------------------->

            @include('hr/sluzbenici/fajlovi/prethodno_radno_iskustvo')

            <!--------------------------------------------------------------------------------------------------------->

            @include('hr/sluzbenici/fajlovi/prestanak_radnog_odnosa')

            <!--------------------------------------------------------------------------------------------------------->

            @include('hr/sluzbenici/fajlovi/clanovi_porodice')

        </div>
    </div>
@endsection