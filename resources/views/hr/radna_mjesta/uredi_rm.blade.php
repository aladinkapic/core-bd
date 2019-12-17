@extends('template.main')
@section('title') @php echo isset($radno_mjesto) ? $radno_mjesto->naziv_rm : 'Dodajte novo radno mjesto' @endphp @stop

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('organizacija.index') => 'Organizacioni planovi / Pravilnici',
        route('organizacija.edit', ['id' => $organizacija->id]) => $organizacija->naziv,
        route('organizacija.radna-mjesta', ['id' => $organizacija->id]) => 'Radna mjesta',
    ]) !!}

@stop


<!-- css links -->
@section('other_css_links')

@stop
<!-- js  links -->
@section('other_js_links')
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <script>
        $(function() {
            $('.dates #usr1').datepicker({
                format: 'dd-mm-yyyy',
                'autoclose': true
            });
        });
    </script>
@stop

@section('content')
    <div class="container">
        <div class="card-body hr-activity tab full_container">
            <div class="row">
                <div class="col-md-12">
                    <section class="multi_step_form">
                        <form id="msform" method="post" action="/hr/radna_mjesta/azuriraj_rm">
                            @csrf

                            <div id="steps-window">
                                <ul>
                                    <li class="active">
                                        <div class="list_div">
                                            <div class="back_div"></div>
                                            <div class="icon_circle">
                                                <i class="fas fa-briefcase"></i>
                                            </div>
                                            <p>{{__('Radno mjesto')}}</p>
                                        </div>
                                    </li>
                                    <li class="">
                                        <div class="list_div">
                                            <div class="back_div"></div>
                                            <div class="icon_circle">
                                                <i class="fas fa-network-wired"></i>
                                            </div>
                                            <p>{{__('Uslovi za radno mjesto')}}</p>
                                        </div>
                                    </li>
                                    <li class="">
                                        <div class="list_div">
                                            <div class="back_div"></div>
                                            <div class="icon_circle">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <p>{{__('Uposleni na radnom mjestu')}}</p>
                                        </div>
                                    </li>

                                </ul>


                                <section class="active">
                                    <div class="container_block">
                                        <div class="split_container">
                                            {!! Form::hidden('id_rm', $radno_mjesto->id, ['class' => 'form-control']) !!}
                                            <div class="form-group row">
                                                <div class="col">
                                                    {!! Form::label('naziv_rm', 'Naziv radnog mjesta : ', ['class' => 'control-label']) !!}
                                                    <div class="col-lg-12">
                                                        {!! Form::text('naziv_rm', isset($radno_mjesto) ? $radno_mjesto->naziv_rm : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'naziv_rm', 'onkeyup' => 'verifikuj_string("naziv_rm", "Naziv radnog ne smije sadržavati brojeve !", "ima_li_brojeva"), copy_content(this, ["naziv_rm_inp"])', 'autocomplete' => 'off', 'maxlength' => '100']) !!}
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    {!! Form::label('sifra_rm', 'Šifra radnog mjesta : ', ['class' => 'control-label']) !!}
                                                    <div class="col-lg-12">
                                                        {!! Form::text('sifra_rm', isset($radno_mjesto) ? $radno_mjesto->sifra_rm : '' , ['class' => 'form-control', 'rows' => 1, 'id' => 'sifra_rm', 'autocomplete' => 'off']) !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="notificaiton_area" id="naziv_rm_not"> <p id="naziv_rm_not_v"></p> </div>

                                            <div class="form-group row">
                                                <div class="col">
                                                    {!! Form::label('opis_rm', 'Opis poslova radnog mjesta i odgovornosti : ', ['class' => 'control-label']) !!}
                                                    <div class="col-lg-12">
                                                        {!! Form::textarea('opis_rm', isset($radno_mjesto) ? $radno_mjesto->opis_rm : '', ['class' => 'form-control', 'style' => 'height:152px; ', 'id' => 'opis_rm']) !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col">
                                                    {!! Form::label('broj_izvrsilaca', 'Broj izvršilaca : ', ['class' => 'control-label']) !!}
                                                    <div class="col-lg-12">
                                                        {!! Form::number('broj_izvrsilaca', isset($radno_mjesto) ? $radno_mjesto->broj_izvrsilaca : '', ['class' => 'form-control', 'id' => 'broj_izvrsilaca', 'autocomplete' => 'off', 'min' => 1]) !!}
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    {!! Form::label('platni_razred', 'Platni razred : ', ['class' => 'control-label']) !!}
                                                    <div class="col-lg-12">
                                                        {!! Form::text('platni_razred', isset($radno_mjesto) ? $radno_mjesto->platni_razred : '', ['class' => 'form-control', 'id' => 'platni_razred', 'autocomplete' => 'off']) !!}
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="split_container">

                                            <div class="form-group row">
                                                <div class="col">
                                                    {!! Form::label('tip_rm', 'Stepen : ', ['class' => 'control-label']) !!}
                                                    <div class="col-lg-12">
                                                        {!!  Form::select('tip_rm', $tip_radnog_mjesta, isset($radno_mjesto) ? $radno_mjesto->tip_rm : '' ,['class' => 'form-control', 'id' => 'tip_rm']) !!}
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    {!! Form::label('kategorija_rm', 'Kategorija radnog mjesta : ', ['class' => 'control-label']) !!}
                                                    <div class="col-lg-12">
                                                        {!!  Form::select('kategorija_rm', $kateogrija_radnog, isset($radno_mjesto) ? $radno_mjesto->kategorija_rm : '' ,['class' => 'form-control', 'id' => 'kategorija_rm']) !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col">
                                                    {!! Form::label('id_oj', 'Organizaciona jedinica : ', ['class' => 'control-label']) !!}
                                                    <div class="col-lg-12">
                                                        {!!  Form::select('id_oj', $org_jedinice    , isset($radno_mjesto) ? $radno_mjesto->id_oj : '' ,['class' => 'form-control', 'id' => 'id_oj']) !!}
                                                    </div>
                                                </div>
                                            </div>

{{--                                            <div class="form-group row">--}}
{{--                                                <div class="col">--}}
{{--                                                    {!! Form::label('rukovodioc', 'Rukovodioc: ', ['class' => 'control-label']) !!}--}}
{{--                                                    <div class="col-lg-12">--}}
{{--                                                        {{ Form::checkbox('rukovodioc',null, isset($radno_mjesto) ? $radno_mjesto->rukovodioc : null , array('id'=>'asap')) }}--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

                                            <div class="form-group row">
                                                <div class="col">
                                                    {!! Form::label('strucna_sprema', 'Kompetencije : ', ['class' => 'control-label']) !!}
                                                    <div class="col-lg-12">
                                                        {!!  Form::select('strucna_sprema', $strucna_sprema, isset($radno_mjesto) ? $radno_mjesto->strucna_sprema : '' ,['class' => 'form-control', 'id' => 'strucna_sprema']) !!}
                                                    </div>
                                                </div>
{{--                                                <div class="col">--}}
{{--                                                    {!! Form::label('tip_pm', 'Tip privremenog premještaja : ', ['class' => 'control-label']) !!}--}}
{{--                                                    <div class="col-lg-12">--}}
{{--                                                        {!!  Form::select('tip_pm', $tip_premjestaja, isset($radno_mjesto) ? $radno_mjesto->tip_pm : '' ,['class' => 'form-control', 'id' => 'id_oj']) !!}--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
                                            </div>

                                            <div class="form-group row">
                                                <div class="col">
                                                    {!! Form::label('benificirani_staz', 'Benificirani radni staž : ', ['class' => 'control-label']) !!}
                                                    <div class="col-lg-12">
                                                        {!!  Form::select('benificirani_staz', $benificirani, isset($radno_mjesto) ? $radno_mjesto->strucna_sprema : '' ,['class' => 'form-control', 'id' => 'strucna_sprema']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>


                                <section class="">
                                    <div class="container_block" >
                                        <div class="split_container">
                                            <div class="copied_form" id="form_for_copy">
                                                <div class="form-group row">

                                                    {!! Form::hidden('id_uslova[]', 'empty', ['class' => 'form-control']) !!}


                                                    <div class="col">
                                                        {!! Form::label('naziv_rm_inp[]', 'Naziv radnog mjesta : ', ['class' => 'control-label']) !!}
                                                        <div class="col-lg-12">
                                                            {!! Form::text('', isset($radno_mjesto) ? $radno_mjesto->naziv_rm : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'naziv_rm_inp', 'readonly']) !!}
                                                        </div>
                                                    </div>
{{--                                                    <div class="col">--}}
{{--                                                        {!! Form::label('tip_inp', 'Tip : ', ['class' => 'control-label']) !!}--}}
{{--                                                        <div class="col-lg-12">--}}
{{--                                                            {!!  Form::select('tip_inp[]', $tip_uslova, '' ,['class' => 'form-control', 'id' => 'tip_inp']) !!}--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
                                                </div>

                                                <div class="notificaiton_area" id="naziv_rm_not"> <p id="naziv_rm_not_v"></p> </div>

                                                <div class="form-group row">
                                                    <div class="col">
                                                        {!! Form::label('tekst_uslova_inp', 'Tekst uslova : ', ['class' => 'control-label']) !!}
                                                        <div class="col-lg-12">
                                                            {!! Form::textarea('tekst_uslova_inp[]', '', ['class' => 'form-control', 'rows' => 6, 'id' => 'tekst_uslova_inp', 'maxlength' => '100']) !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                {{--                                            <div class="form-group row">--}}
                                                {{--                                                <div class="col">--}}
                                                {{--                                                    {!! Form::label('vrijednost_inp', 'Vrijednost : ', ['class' => 'control-label']) !!}--}}
                                                {{--                                                    <div class="col-lg-12">--}}
                                                {{--                                                        {!! Form::textarea('vrijednost_inp[]', '', ['class' => 'form-control', 'rows' => 2, 'id' => 'vrijednost_inp', 'maxlength' => '100']) !!}--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}
                                                {{--                                            </div>--}}
                                            </div>

                                            <div class="form-group" style="text-align:right; padding-right:16px; margin-top:30px;">
                                                <button type="button" class="btn btn-dark" id="custom_button" onclick="createNewDomElements('uslovi_za_radno_mjesto', 'form_for_copy');">
                                                    {{__('Dodajte uslov')}}
                                                    <i class="fas fa-save"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="split_container" style="padding:0px;">
                                            <div id="uslovi_za_radno_mjesto">
                                                @php $i = 0; @endphp
                                                @foreach($uslovi as $uslov)
                                                    <div class="copied_form radno_mjesto_uslovi*{{$uslov->id}}" id="form_for_copy" style="padding-top:20px;">

                                                        <div class="shadow_delete">
                                                            <div class="delete_item" onclick="obrisiDomElement('uslovi_za_radno_mjesto', '{{$i}}'); obrisiIzBaze('{{$uslov->id}}'); ">
                                                                <i class="fas fa-trash"></i>
                                                            </div>

                                                            <div class="delete_item edit_item" onclick="urediDomElement('uslovi_za_radno_mjesto', '{{$i++}}');">
                                                                <i class="fas fa-edit"></i>
                                                            </div>
                                                        </div>

                                                        {!! Form::hidden('id_uslova[]', $uslov->id, ['class' => 'form-control']) !!}

                                                        <div class="form-group row">
                                                            <div class="col">
                                                                {!! Form::label('naziv_rm_inp', 'Naziv radnog mjesta : ', ['class' => 'control-label']) !!}
                                                                <div class="col-lg-12">
                                                                    {!! Form::text('naziv_rm_inp[]', isset($radno_mjesto) ? $radno_mjesto->naziv_rm : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'naziv_rm_inp', 'readonly']) !!}
                                                                </div>
                                                            </div>
{{--                                                            <div class="col">--}}
{{--                                                                {!! Form::label('tip_inp', 'Tip : ', ['class' => 'control-label']) !!}--}}
{{--                                                                <div class="col-lg-12">--}}
{{--                                                                    {!!  Form::select('tip_inp[]', $tip_uslova, $uslov->tip ,['class' => 'form-control', 'id' => 'tip_inp']) !!}--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
                                                        </div>

                                                        <div class="notificaiton_area" id="naziv_rm_not"> <p id="naziv_rm_not_v"></p> </div>

                                                        <div class="form-group row">
                                                            <div class="col">
                                                                {!! Form::label('tekst_uslova_inp', 'Tekst uslova : ', ['class' => 'control-label']) !!}
                                                                <div class="col-lg-12">
                                                                    {!! Form::textarea('tekst_uslova_inp[]', $uslov->tekst_uslova, ['class' => 'form-control', 'rows' => 6, 'id' => 'tekst_uslova_inp', 'maxlength' => '100']) !!}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{--                                                    <div class="form-group row">--}}
                                                        {{--                                                        <div class="col">--}}
                                                        {{--                                                            {!! Form::label('vrijednost_inp', 'Vrijednost : ', ['class' => 'control-label']) !!}--}}
                                                        {{--                                                            <div class="col-lg-12">--}}
                                                        {{--                                                                {!! Form::textarea('vrijednost_inp[]', $uslov->vrijednost, ['class' => 'form-control', 'rows' => 2, 'id' => 'vrijednost_inp', 'maxlength' => '100']) !!}--}}
                                                        {{--                                                            </div>--}}
                                                        {{--                                                        </div>--}}
                                                        {{--                                                    </div>--}}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </section>


                                <section class="">
                                    <div class="container_block" >
                                        <div class="split_container">
                                            <div class="copied_form" id="nekaamo">

                                                {!! Form::hidden('id_sluzben[]', 'empty', ['class' => 'form-control']) !!}

                                                <div class="form-group row">
                                                    <div class="col">
                                                        {!! Form::label('ime_sluzbenika', 'Ime i prezime službenika : ', ['class' => 'control-label']) !!}
                                                        <div class="col-lg-12">
                                                            {!!  Form::select('sluzbenik_id[]', $sluzbenici, '' ,['class' => 'form-control', 'id' => 'tip_inp']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" style="text-align:right; padding-right:16px; margin-top:30px;">
                                                <button type="button" class="btn btn-dark" id="custom_button" onclick="createNewDomElements('korisnici', 'nekaamo');">
                                                    {{__('Dodajte službenika')}}
                                                    <i class="fas fa-save"></i>
                                                </button>
                                            </div>
                                        </div>


                                        <div class="split_container" style="padding:0px;">
                                            <div id="korisnici">
                                                @php $i=0; @endphp
                                                @foreach($uposleni as $uposlen)
                                                    @foreach($uposlen->sluzbeniciRel as $sluzbenik)

                                                        <div class="copied_form sluzbenici*{{$sluzbenik->sluzbenik->id ?? '1'}}" id="nekaamo" style="padding-top:20px;">

                                                            {!! Form::hidden('id_sluzben[]', $sluzbenik->sluzbenik->id, ['class' => 'form-control']) !!}

                                                            <div class="shadow_delete">
                                                                <div class="delete_item" onclick="obrisiDomElement('korisnici', '{{$i}}'); obrisiIzBaze('{{$sluzbenik->sluzbenik->id}}'); ">
                                                                    <i class="fas fa-times"></i>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <div class="col">
                                                                    {!! Form::label('ime_sluzbenika', 'Ime i prezime službenika : ', ['class' => 'control-label']) !!}
                                                                    <div class="col-lg-12">
                                                                        {!!  Form::select('sluzbenik_id[]', $sluzbenici, $sluzbenik->sluzbenik->id ,['class' => 'form-control', 'id' => 'tip_inp']) !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @endforeach
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </section>


                                <div class="buttons" style="text-align:center;">
                                    <button type="button" class="btn btn-dark" >
                                        <i class="fas fa-chevron-left"></i>
                                        {{__('Nazad')}}
                                    </button>
                                    <button type="button" class="btn btn-blue" >
                                        {{__('Dalje')}}
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fab fa-telegram"></i>
                                        {{__('Spremite')}}
                                    </button>
                                </div>

                            </div>
                        </form>
                    </section>
                </div>

                {{--            <div class="col-md-3">--}}
                {{--                @include('hr.organizacija.snippets.sidebar')--}}
                {{--            </div>--}}
            </div>
        </div>
    </div>
@endsection
