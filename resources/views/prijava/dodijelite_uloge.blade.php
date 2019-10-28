@extends('template.main')
@section('other_js_links')

@endsection
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('sluzbenik.pregled') => 'Lista državnih službenika',
        route('izvjestaji.dodijeli.ulogu', ['id' => $id]) => 'Pregled uloga korisnika',
    ]) !!}

@stop


@section('content')
    <div class="container ">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        {{__('Dodjeljivanje uloga za')}}  {{$sluzbenik->ime ?? '/'}} {{$sluzbenik->prezime  ?? '/'}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                {{__('Pristup sistemu')}}
                            </div>
                            <div class="col-md-2 text-center">
                                @php $found = false @endphp
                                @if($sluzbenik->uloge)
                                    @foreach($sluzbenik->uloge as $uloga)
                                        @if($uloga->keyword == 'pristup')
                                            @php $found = true; @endphp
                                            <input keyword="pristup" @if($uloga->vrijednost) checked @endif type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                        @endif
                                    @endforeach
                                @endif
                                @if(!$found)
                                    <input keyword="pristup" type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                @endif
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-10">
                                {{__('Radna mjesta')}}
                            </div>
                            <div class="col-md-2 text-center">
                                @php $found = false @endphp
                                @if($sluzbenik->uloge)
                                    @foreach($sluzbenik->uloge as $uloga)
                                        @if($uloga->keyword == 'radna_mjesta')
                                            @php $found = true; @endphp
                                            <input keyword="radna_mjesta" @if($uloga->vrijednost) checked @endif type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                        @endif
                                    @endforeach
                                @endif
                                @if(!$found)
                                    <input keyword="radna_mjesta" type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                @endif
                            </div>
                        </div>

                        <!-- ---------------------------------------------------------------------------- -->

                        <div class="row">
                            <div class="col-md-10">
                                {{__('Unutrašnja organizacija')}}
                            </div>
                            <div class="col-md-2 text-center">
                                @php $found = false @endphp
                                @if($sluzbenik->uloge)
                                    @foreach($sluzbenik->uloge as $uloga)
                                        @if($uloga->keyword == 'unutrasnja_org')
                                            @php $found = true; @endphp
                                            <input keyword="unutrasnja_org" @if($uloga->vrijednost) checked @endif type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                        @endif
                                    @endforeach
                                @endif
                                @if(!$found)
                                    <input keyword="unutrasnja_org" type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                @endif
                            </div>
                        </div>

                        <!-- ---------------------------------------------------------------------------- -->

                        <div class="row">
                            <div class="col-md-10">
                                {{__('Organ javne uprave')}}
                            </div>
                            <div class="col-md-2 text-center">
                                @php $found = false @endphp
                                @if($sluzbenik->uloge)
                                    @foreach($sluzbenik->uloge as $uloga)
                                        @if($uloga->keyword == 'organ_ju')
                                            @php $found = true; @endphp
                                            <input keyword="organ_ju" @if($uloga->vrijednost) checked @endif type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                        @endif
                                    @endforeach
                                @endif
                                @if(!$found)
                                    <input keyword="organ_ju" type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                @endif
                            </div>
                        </div>

                        <!-- ---------------------------------------------------------------------------- -->

                        <div class="row">
                            <div class="col-md-10">
                                {{__('Službenici')}}
                            </div>
                            <div class="col-md-2 text-center">
                                @php $found = false @endphp
                                @if($sluzbenik->uloge)
                                    @foreach($sluzbenik->uloge as $uloga)
                                        @if($uloga->keyword == 'sluzbenici')
                                            @php $found = true; @endphp
                                            <input keyword="sluzbenici" @if($uloga->vrijednost) checked @endif type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                        @endif
                                    @endforeach
                                @endif
                                @if(!$found)
                                    <input keyword="sluzbenici" type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                @endif
                            </div>
                        </div>

                        <!-- ---------------------------------------------------------------------------- -->

                        <div class="row">
                            <div class="col-md-10">
                                {{__('Registar ugovora')}}
                            </div>
                            <div class="col-md-2 text-center">
                                @php $found = false @endphp
                                @if($sluzbenik->uloge)
                                    @foreach($sluzbenik->uloge as $uloga)
                                        @if($uloga->keyword == 'regitar_ugovora')
                                            @php $found = true; @endphp
                                            <input keyword="regitar_ugovora" @if($uloga->vrijednost) checked @endif type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                        @endif
                                    @endforeach
                                @endif
                                @if(!$found)
                                    <input keyword="regitar_ugovora" type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                @endif
                            </div>
                        </div>

                        <!-- ---------------------------------------------------------------------------- -->

                        <div class="row">
                            <div class="col-md-10">
                                {{__('Odsustva')}}
                            </div>
                            <div class="col-md-2 text-center">
                                @php $found = false @endphp
                                @if($sluzbenik->uloge)
                                    @foreach($sluzbenik->uloge as $uloga)
                                        @if($uloga->keyword == 'odsustva')
                                            @php $found = true; @endphp
                                            <input keyword="odsustva" @if($uloga->vrijednost) checked @endif type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                        @endif
                                    @endforeach
                                @endif
                                @if(!$found)
                                    <input keyword="odsustva" type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                @endif
                            </div>
                        </div>

                        <!-- ---------------------------------------------------------------------------- -->

                        <div class="row">
                            <div class="col-md-10">
                                {{__('Upravljanje učinkom')}}
                            </div>
                            <div class="col-md-2 text-center">
                                @php $found = false @endphp
                                @if($sluzbenik->uloge)
                                    @foreach($sluzbenik->uloge as $uloga)
                                        @if($uloga->keyword == 'upravljanje_ucin')
                                            @php $found = true; @endphp
                                            <input keyword="upravljanje_ucin" @if($uloga->vrijednost) checked @endif type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                        @endif
                                    @endforeach
                                @endif
                                @if(!$found)
                                    <input keyword="upravljanje_ucin" type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                @endif
                            </div>
                        </div>

                        <!-- ---------------------------------------------------------------------------- -->

                        <div class="row">
                            <div class="col-md-10">
                                {{__('Disciplinska odgovornost')}}
                            </div>
                            <div class="col-md-2 text-center">
                                @php $found = false @endphp
                                @if($sluzbenik->uloge)
                                    @foreach($sluzbenik->uloge as $uloga)
                                        @if($uloga->keyword == 'disciplinska_odg')
                                            @php $found = true; @endphp
                                            <input keyword="disciplinska_odg" @if($uloga->vrijednost) checked @endif type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                        @endif
                                    @endforeach
                                @endif
                                @if(!$found)
                                    <input keyword="disciplinska_odg" type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                @endif
                            </div>
                        </div>

                        <!-- ---------------------------------------------------------------------------- -->

                        <div class="row">
                            <div class="col-md-10">
                                {{__('eKonkurs')}}
                            </div>
                            <div class="col-md-2 text-center">
                                @php $found = false @endphp
                                @if($sluzbenik->uloge)
                                    @foreach($sluzbenik->uloge as $uloga)
                                        @if($uloga->keyword == 'ekonkurs')
                                            @php $found = true; @endphp
                                            <input keyword="ekonkurs" @if($uloga->vrijednost) checked @endif type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                        @endif
                                    @endforeach
                                @endif
                                @if(!$found)
                                    <input keyword="ekonkurs" type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                @endif
                            </div>
                        </div>

                        <!-- ---------------------------------------------------------------------------- -->

                        <div class="row">
                            <div class="col-md-10">
                                {{__('Obuke')}}
                            </div>
                            <div class="col-md-2 text-center">
                                @php $found = false @endphp
                                @if($sluzbenik->uloge)
                                    @foreach($sluzbenik->uloge as $uloga)
                                        @if($uloga->keyword == 'obuke')
                                            @php $found = true; @endphp
                                            <input keyword="obuke" @if($uloga->vrijednost) checked @endif type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                        @endif
                                    @endforeach
                                @endif
                                @if(!$found)
                                    <input keyword="obuke" type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                @endif
                            </div>
                        </div>

                        <!-- ---------------------------------------------------------------------------- -->

                        <div class="row">
                            <div class="col-md-10">
                                {{__('Predavači')}}
                            </div>
                            <div class="col-md-2 text-center">
                                @php $found = false @endphp
                                @if($sluzbenik->uloge)
                                    @foreach($sluzbenik->uloge as $uloga)
                                        @if($uloga->keyword == 'predavaci')
                                            @php $found = true; @endphp
                                            <input keyword="predavaci" @if($uloga->vrijednost) checked @endif type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                        @endif
                                    @endforeach
                                @endif
                                @if(!$found)
                                    <input keyword="predavaci" type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                @endif
                            </div>
                        </div>

                        <!-- ---------------------------------------------------------------------------- -->

                        <div class="row">
                            <div class="col-md-10">
                                {{__('Teme za obuku')}}
                            </div>
                            <div class="col-md-2 text-center">
                                @php $found = false @endphp
                                @if($sluzbenik->uloge)
                                    @foreach($sluzbenik->uloge as $uloga)
                                        @if($uloga->keyword == 'teme_za_obuku')
                                            @php $found = true; @endphp
                                            <input keyword="teme_za_obuku" @if($uloga->vrijednost) checked @endif type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                        @endif
                                    @endforeach
                                @endif
                                @if(!$found)
                                    <input keyword="teme_za_obuku" type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                @endif
                            </div>
                        </div>

                        <!-- ---------------------------------------------------------------------------- -->

                        <div class="row">
                            <div class="col-md-10">
                                {{__('Interno tržište')}}
                            </div>
                            <div class="col-md-2 text-center">
                                @php $found = false @endphp
                                @if($sluzbenik->uloge)
                                    @foreach($sluzbenik->uloge as $uloga)
                                        @if($uloga->keyword == 'interno_trziste')
                                            @php $found = true; @endphp
                                            <input keyword="interno_trziste" @if($uloga->vrijednost) checked @endif type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                        @endif
                                    @endforeach
                                @endif
                                @if(!$found)
                                    <input keyword="interno_trziste" type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                @endif
                            </div>
                        </div>

                        <!-- ---------------------------------------------------------------------------- -->

                        <div class="row">
                            <div class="col-md-10">
                                {{__('Strateško planiranje')}}
                            </div>
                            <div class="col-md-2 text-center">
                                @php $found = false @endphp
                                @if($sluzbenik->uloge)
                                    @foreach($sluzbenik->uloge as $uloga)
                                        @if($uloga->keyword == 'stratesko_pl')
                                            @php $found = true; @endphp
                                            <input keyword="stratesko_pl" @if($uloga->vrijednost) checked @endif type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                        @endif
                                    @endforeach
                                @endif
                                @if(!$found)
                                    <input keyword="stratesko_pl" type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                @endif
                            </div>
                        </div>

                        <!-- ---------------------------------------------------------------------------- -->

                        <div class="row">
                            <div class="col-md-10">
                                {{__('Izvještaji')}}
                            </div>
                            <div class="col-md-2 text-center">
                                @php $found = false @endphp
                                @if($sluzbenik->uloge)
                                    @foreach($sluzbenik->uloge as $uloga)
                                        @if($uloga->keyword == 'izvjestaji')
                                            @php $found = true; @endphp
                                            <input keyword="izvjestaji" @if($uloga->vrijednost) checked @endif type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                        @endif
                                    @endforeach
                                @endif
                                @if(!$found)
                                    <input keyword="izvjestaji" type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                @endif
                            </div>
                        </div>

                        <!-- ---------------------------------------------------------------------------- -->

                        <div class="row">
                            <div class="col-md-10">
                                {{__('Historizacija')}}
                            </div>
                            <div class="col-md-2 text-center">
                                @php $found = false @endphp
                                @if($sluzbenik->uloge)
                                    @foreach($sluzbenik->uloge as $uloga)
                                        @if($uloga->keyword == 'historizacija')
                                            @php $found = true; @endphp
                                            <input keyword="historizacija" @if($uloga->vrijednost) checked @endif type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                        @endif
                                    @endforeach
                                @endif
                                @if(!$found)
                                    <input keyword="historizacija" type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                @endif
                            </div>
                        </div>

                        <!-- ---------------------------------------------------------------------------- -->

                        <div class="row">
                            <div class="col-md-10">
                                {{__('Postavke')}}
                            </div>
                            <div class="col-md-2 text-center">
                                @php $found = false @endphp
                                @if($sluzbenik->uloge)
                                    @foreach($sluzbenik->uloge as $uloga)
                                        @if($uloga->keyword == 'postavke')
                                            @php $found = true; @endphp
                                            <input keyword="postavke" @if($uloga->vrijednost) checked @endif type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                        @endif
                                    @endforeach
                                @endif
                                @if(!$found)
                                    <input keyword="postavke" type="checkbox" class="specific_role_value" sluzbenik_id="{{$sluzbenik->id ?? '1'}}">
                                @endif
                            </div>
                        </div>

                        <!-- ---------------------------------------------------------------------------- -->


                    </div>
                </div>

            </div>

<<<<<<< HEAD
                        <div>
                            <div>
                                {!! Form::hidden('sifra', $sifra, ['class' => 'form-control', 'validate' => 'required', 'autocomplete' => 'off', 'id' => 'sifra']) !!}
                                {!! Form::hidden('pin', $pin, ['class' => 'form-control', 'validate' => 'required', 'autocomplete' => 'off', 'id' => 'pin']) !!}
                                {!! Form::hidden('sluzbenik_id', $sluzbenik->id, ['class' => 'form-control', 'validate' => 'required', 'autocomplete' => 'off', 'id' => 'sluzbenik_id']) !!}
                                <button type="submit" id="buton-to-change-code" class="btn btn-primary">{{__('Spremite promijene')}}</button>
                            </div>
                        </div>
=======
            <div class="col md-6">
                <div class="generated-access-data">
                    <div class="card-header">
                        Kredincijali
>>>>>>> 2ae968b90de625a102e204988b7aa8d78656efbd
                    </div>

                    <p>
                        Za pristup sistemu, svakom od korisnika je potrebno dodijeliti korisničko ime, šifru i PIN kod.
                        Ovakav pristup predstavlja dvoslojnu zaštitu, te kao takav čini sistem sigurnijim.
                    </p>
                    <p>
                        Pristupni podaci za <b>{{$sluzbenik->ime ?? '/'}} {{$sluzbenik->prezime  ?? '/'}}</b> su:
                    </p>
                    <br>
                    <div class="user-daataaaa">
                        <table class="mine-table-hehehe">
                            <tr>
                                <td>Korisničko ime : </td>
                                <td>
                                    <b>
                                        {{$sluzbenik->korisnicko_ime}}
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Šifra : </td>
                                <td>
                                    <b>
                                        {{$sluzbenik->sifra}}
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>PIN kod : </td>
                                <td>
                                    <b>
                                        ****
                                    </b>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <p>
                        NAPOMENA: Prilikom generisanja kredincijala korisničko ime, šifra i PIN su generisani i poslani
                        putem emaila koji je definisan kod unosa Državnog službenika. <br>
                        Radi sprečavanja zloupotrabe korisničkih računa, PIN kod kod nije vidljiv administratorima.
                    </p>

                    <p>
                        U slučaju zaboravljenih pristupnih podataka, iste možete
                        <a href="{{route('izvjestaji.generisi-sifru', ['id' => $sluzbenik->id])}}">ponovo generisati ovdje</a>.
{{--                        Također, možete generisati i samo PIN kod--}}
{{--                        <a href="">ovdje</a> .--}}
                    </p>

{{--                    <div>--}}
{{--                        <div>--}}
{{--                            <h4>{{__('Dodijeljivanje sifre za')}} {{$sluzbenik->ime ?? '/'}} {{$sluzbenik->prezime  ?? '/'}}</h4>--}}
{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <div>--}}
{{--                                {!! Form::hidden('sifra', $sifra, ['class' => 'form-control', 'validate' => 'required', 'autocomplete' => 'off', 'id' => 'sifra']) !!}--}}
{{--                                {!! Form::hidden('pin', $pin, ['class' => 'form-control', 'validate' => 'required', 'autocomplete' => 'off', 'id' => 'pin']) !!}--}}
{{--                                {!! Form::hidden('sluzbenik_id', $sluzbenik->id, ['class' => 'form-control', 'validate' => 'required', 'autocomplete' => 'off', 'id' => 'sluzbenik_id']) !!}--}}
{{--                                <button type="submit" id="buton-to-change-code" class="btn btn-primary">Spremite promijene</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>

        </div>
    </div>

@endsection