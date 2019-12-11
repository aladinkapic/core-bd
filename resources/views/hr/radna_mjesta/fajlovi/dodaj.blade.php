{{--@include('hr.organizacija.snippets.menu')--}}
<section class="multi_step_form">
    <form id="msform" class=""  method="post" action="/hr/radna_mjesta/spremi_mjesto">

    @csrf
        @if(!isset($radno_mjesto))
            <div class="tittle">
                <h2>{{__('Unos radnog mjesta')}}</h2>
                <p>{{__('Molimo Vas da popunite sva potrebna polja za unos. Sve aktivnosti na ovoj stranici će biti zabilježene.')}}</p>
            </div>
        @endif


        <div id="steps-window">
            <ul>
                <li class="active">
                    @if(isset($radno_mjesto))
                        <div class="tab_div">
                            <i class="fas fa-briefcase"></i>
                            <p>{{__('Radno mjesto')}}</p>
                        </div>

                    @else
                        <div class="list_div">
                            <div class="back_div"></div>
                            <div class="icon_circle">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <p>
                                {{__('Radno mjesto')}}
                            </p>
                        </div>
                    @endif
                </li>
                <li class="">
                    @if(isset($radno_mjesto))
                        <div class="tab_div">
                            <i class="fas fa-network-wired"></i>
                            <p>{{__('Uslovi za radno mjesto')}}</p>
                        </div>
                    @else
                        <div class="list_div">
                            <div class="back_div"></div>
                            <div class="icon_circle">
                                <i class="fas fa-network-wired"></i>
                            </div>
                            <p>
                                {{__('Uslovi za radno mjesto')}}
                            </p>
                        </div>
                    @endif
                </li>
                <li>
                    @if(isset($radno_mjesto))
                        <div class="tab_div">
                            <i class="fas fa-users"></i>
                            <p>{{__('Uposleni na radnom mjestu')}}</p>
                        </div>
                    @else
                        <div class="list_div">
                            <div class="back_div"></div>
                            <div class="icon_circle">
                                <i class="fas fa-users"></i>
                            </div>
                            <p>
                                {{__('Uposleni na radnom mjestu')}}
                            </p>
                        </div>
                    @endif
                </li>
            </ul>


            <section class="active">
                <div class="container_block">
                    <div class="split_container">
                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('naziv_rm', 'Naziv radnog mjesta : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('naziv_rm', isset($radno_mjesto) ? $radno_mjesto->naziv_rm : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'naziv_rm', 'onkeyup' => 'verifikuj_string("naziv_rm", "Naziv radnog ne smije sadržavati brojeve !", "ima_li_brojeva"), copy_content(this, ["naziv_rm_inp"])', 'autocomplete' => 'off', 'maxlength' => '100', isset($radno_mjesto) ? 'readonly' : '']) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('sifra_rm', 'Šifra radnog mjesta : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('sifra_rm', isset($radno_mjesto) ? $radno_mjesto->sifra_rm : '' , ['class' => 'form-control', 'rows' => 1, 'id' => 'sifra_rm', 'autocomplete' => 'off', isset($radno_mjesto) ? 'readonly' : '', 'maxlength' => '50']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="notificaiton_area" id="naziv_rm_not"> <p id="naziv_rm_not_v"></p> </div>
                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('opis_rm', 'Opis radnog mjesta : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::textarea('opis_rm', isset($radno_mjesto) ? $radno_mjesto->opis_rm : '', ['class' => 'form-control', 'style' => 'height:152px; ', 'id' => 'opis_rm', isset($radno_mjesto) ? 'readonly' : '', 'maxlength' => '5000']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('broj_izvrsilaca', 'Broj izvršilaca : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::number('broj_izvrsilaca', isset($radno_mjesto) ? $radno_mjesto->broj_izvrsilaca : '', ['class' => 'form-control', 'id' => 'broj_izvrsilaca', 'autocomplete' => 'off', isset($radno_mjesto) ? 'readonly' : '', 'min' => 1]) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('platni_razred', 'Platni razred : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('platni_razred', isset($radno_mjesto) ? $radno_mjesto->platni_razred : '', ['class' => 'form-control', 'id' => 'platni_razred', 'autocomplete' => 'off', isset($radno_mjesto) ? 'readonly' : '', 'maxlength' => '50']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="split_container">
                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('tip_rm', 'Tip radnog mjesta : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!!  Form::select('tip_rm', $tip_radnog_mjesta, isset($radno_mjesto) ? $radno_mjesto->tip_rm : '' ,['class' => 'form-control', 'id' => 'tip_rm', isset($radno_mjesto) ? 'disabled  = "true"' : '']) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('kategorija_rm', 'Kategorija radnog mjesta : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!!  Form::select('kategorija_rm', $kateogrija_radnog, isset($radno_mjesto) ? $radno_mjesto->kategorija_rm : '' ,['class' => 'form-control', 'id' => 'kategorija_rm', isset($radno_mjesto) ? 'disabled  = "true"' : '']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('id_oj', 'Organizaciona jedinica : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!!  Form::select('id_oj', $org_jedinice, isset($radno_mjesto) ? $radno_mjesto->id_oj : '' ,['class' => 'form-control', 'id' => 'id_oj', isset($radno_mjesto) ? 'disabled  = "true"' : '']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('rukovodioc', 'Rukovodioc: ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {{ Form::checkbox('rukovodioc',null, isset($radno_mjesto) ? $radno_mjesto->rukovodioc : null, array('id'=>'asap', isset($radno_mjesto) ? '' : '' )) }}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('strucna_sprema', 'Stručna sprema : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!!  Form::select('strucna_sprema', $strucna_sprema, isset($radno_mjesto) ? $radno_mjesto->strucna_sprema : '' ,['class' => 'form-control', 'id' => 'strucna_sprema', isset($radno_mjesto) ? 'disabled  = "true"' : '']) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('tip_pm', 'Tip privremenog premještaja : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!!  Form::select('tip_pm', $tip_premjestaja, isset($radno_mjesto) ? $radno_mjesto->tip_pm : '' ,['class' => 'form-control', 'id' => 'id_oj', isset($radno_mjesto) ? 'disabled  = "true"' : '']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('benificirani_staz', 'Benificirani radni staž : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!!  Form::select('benificirani_staz', $benificirani, isset($radno_mjesto) ? $radno_mjesto->benificirani_staz : '' ,['class' => 'form-control', 'id' => 'strucna_sprema']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(isset($what))
                        <div class="full_container full_container_b">
                            <div class="form-group row">
                                <div class="col">
                                    {!! Form::label('rjesenje', 'Rješenje : ', ['class' => 'control-label']) !!}
                                    <div class="col-lg-12">
                                        {!!  Form::textarea('rjesenje', isset($radno_mjesto) ? $radno_mjesto->rjesenje : '' ,['class' => 'form-control', 'id' => 'rjesenje', 'readonly']) !!}
                                    </div>
                                </div>
                            </  div>
                        </div>
                    @endif
                </div>
            </section>


            <section class="">
                <div class="container_block" >

                    @if(!isset($radno_mjesto))
                        <div class="split_container">
                            <div class="copied_form" id="form_for_copy">
                                <div class="form-group row">
                                    <div class="col">
                                        {!! Form::label('naziv_rm_inp', 'Naziv radnog mjesta : ', ['class' => 'control-label']) !!}
                                        <div class="col-lg-12">
                                            {!! Form::text('naziv_rm_inp[]', isset($radno_mjesto) ? $radno_mjesto->naziv_rm : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'naziv_rm_inp', 'readonly']) !!}
                                        </div>
                                    </div>
                                    <div class="col">
                                        {!! Form::label('tip_inp', 'Tip : ', ['class' => 'control-label']) !!}
                                        <div class="col-lg-12">
                                            {!!  Form::select('tip_inp[]', $tip_uslova, '' ,['class' => 'form-control', 'id' => 'tip_inp']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="notificaiton_area" id="naziv_rm_not"> <p id="naziv_rm_not_v"></p> </div>

                                <div class="form-group row">
                                    <div class="col">
                                        {!! Form::label('tekst_uslova_inp', 'Tekst uslova : ', ['class' => 'control-label']) !!}
                                        <div class="col-lg-12">
                                            {!! Form::textarea('tekst_uslova_inp[]', '', ['class' => 'form-control', 'rows' => 2, 'id' => 'tekst_uslova_inp', 'maxlength' => '100']) !!}
                                        </div>
                                    </div>
                                </div>

{{--                                <div class="form-group row">--}}
{{--                                    <div class="col">--}}
{{--                                        {!! Form::label('vrijednost_inp', 'Vrijednost : ', ['class' => 'control-label']) !!}--}}
{{--                                        <div class="col-lg-12">--}}
{{--                                            {!! Form::textarea('vrijednost_inp[]', '', ['class' => 'form-control', 'rows' => 2, 'id' => 'vrijednost_inp', 'maxlength' => '100']) !!}--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
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

                            </div>
                        </div>
                    @else
                        @foreach($uslovi as $uslov)
                            <div class="split_container split_container5" style="padding:0px;">
                                <div id="uslovi_za_radno_mjesto">
                                    <div class="copied_form copied_form2" id="form_for_copy">
                                        <div class="form-group row">
                                            <div class="col">
                                                {!! Form::label('naziv_rm_inp', 'Naziv radnog mjesta : ', ['class' => 'control-label']) !!}
                                                <div class="col-lg-12">
                                                    {!! Form::text('', isset($radno_mjesto) ? $radno_mjesto->naziv_rm : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'naziv_rm_inp', 'readonly']) !!}
                                                </div>
                                            </div>
                                            <div class="col">
                                                {!! Form::label('tip_inp', 'Tip : ', ['class' => 'control-label']) !!}
                                                <div class="col-lg-12">
                                                    {!!  Form::select('', $tip_uslova, $uslov->tip ,['class' => 'form-control', 'id' => 'tip_inp', 'disabled' => 'true']) !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col">
                                                {!! Form::label('tekst_uslova_inp', 'Tekst uslova : ', ['class' => 'control-label']) !!}
                                                <div class="col-lg-12">
                                                    {!! Form::textarea('', $uslov->tekst_uslova, ['class' => 'form-control', 'rows' => 2, 'id' => 'tekst_uslova_inp', 'maxlength' => '100', 'readonly']) !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col">
                                                {!! Form::label('vrijednost_inp', 'Vrijednost : ', ['class' => 'control-label']) !!}
                                                <div class="col-lg-12">
                                                    {!! Form::textarea('', $uslov->vrijednost, ['class' => 'form-control', 'rows' => 2, 'id' => 'vrijednost_inp', 'maxlength' => '100', 'readonly']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </section>


            <section class="">
                <div class="container_block" >
                    @if(!isset($radno_mjesto))
                        <div class="split_container">
                            <div class="copied_form" id="nekaamo">

                                <div class="form-group row">
                                    <div class="col">
                                        {!! Form::label('ime_sluzbenika', 'Ime i prezime službenika : ', ['class' => 'control-label']) !!}
                                        <div class="col-lg-12">
                                            {!!  Form::select('sluzbenik_id[]', $sluzbenici, '' ,['class' => 'form-control', 'id' => 'tip_inp']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="notificaiton_area" id="naziv_rm_not"> <p id="naziv_rm_not_v"></p> </div>
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

                            </div>
                        </div>
                    @else
                        <div class="split_container split_container5" style="padding:0px;">
                            <table class="table table-bordered text-left">
                                <thead >
                                <tr>
                                    <th scope="col" width="40px;" class="text-center">#</th>
                                    <th scope="col">{{__('Ime i prezime službenika')}}</th>
                                    <th scope="col">{{__('Organizaciona jedinica')}}</th>
                                    <th scope="col" class="text-center" width="140px">{{__('Akcije')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($odabrani_sluzbenici as $korisnik)
                                    <tr>
                                        <th scope="row" width="40px;" class="text-center"></th>
                                        <td> {{$korisnik->ime}} {{$korisnik->prezime}} </td>
                                        <td> {{$org_jedinice[$radno_mjesto->id_oj]}} </td>
                                        <td class="text-center">
                                            <a href="{{ route('sluzbenik.dodatno', ['id_sluzbenika' => $korisnik->id]) }}">
                                                <i class="fa fa-eye" style="margin-right:10px;"></i> {{__('Pregled')}}
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

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