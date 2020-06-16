@extends('template.main')
@section('title') {{__('Službenik')}} @stop

<!-- css links -->
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('sluzbenik.pregled') => __('Lista državnih službenika'),
    ]) !!}
@stop

<!-- js  links -->
@section('other_js_links')

@stop

@section('content')
    <div class="container container_block">
        <div class="card-body hr-activity tab full_container container_block">
            <div class="full_container">
                <div class="card-header ads-darker" style="height:60px;">
                    @if(!isset($odsustva))
                        <button onClick="window.location='{{route('sluzbenik.pregled')}}';" class="btn btn-light float-right" ><i class="fa fa-chevron-circle-left"></i> {{__('Nazad na pregled službenika')}} </button>
                    @endif
                    <h4 style="position:absolute; margin-top:-6px;">
                        @if(isset($sluzbenik))
                            {{$sluzbenik->ime ?? '/'}} {{$sluzbenik->prezime ?? '/'}}
                        @else
                            {{__('Unesite službenika')}}
                        @endif
                    </h4>
                </div>
            </div>
            @include('hr/sluzbenici/fajlovi/dodaj_sluz')
        </div>

        <div class="card-body hr-activity tab full_container ">
            @if(isset($sluzbenik))
                <div class="container container_block">
                    <div class="full_container">
                        <h4 style="margin-top:10px;">
                            {{__('Dodatne informacije o')}} {{$sluzbenik->ime ?? '/'}} {{$sluzbenik->prezime ?? '/'}}
                        </h4>
                    </div>

                    @if(Input::old('unos_dijela') != null)
                        <div class="my-user-leggit-info"></div>
                    @elseif(Input::old('izmjena_dijela') != null)
                        <div class="my-user-leggit-info-edit"></div>
                    @endif

                    <div class="split_container split_container5">
                        @if ($errors->any())
                            <div class="mine-error-info">

                            </div>

                            <script>
                                $.notify("Došlo je do greške. Molimo popunite sva polja. ", 'warn');
                            </script>


                            <div class="alert alert-danger">
                                {{__('Molimo Vas da popunite sva polja!')}}
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
            @endif
        </div>


    </div>
@endsection

@section('js')

@endsection

