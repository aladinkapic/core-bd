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

            </ul>

            <section class="active">
                <div class="container_block">
                    <div class="split_container">
                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('naziv_rm', __('Naziv radnog mjesta').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('naziv_rm', isset($radno_mjesto) ? $radno_mjesto->naziv_rm : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'naziv_rm', 'onkeyup' => 'verifikuj_string("naziv_rm", "Naziv radnog ne smije sadržavati brojeve !", "ima_li_brojeva"), copy_content(this, ["naziv_rm_inp"])', 'autocomplete' => 'off', 'maxlength' => '100', isset($radno_mjesto) ? 'readonly' : '']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="notificaiton_area" id="naziv_rm_not"> <p id="naziv_rm_not_v"></p> </div>
                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('opis_rm', __('Opis poslova radnog mjesta i odgovornosti').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::textarea('opis_rm', isset($radno_mjesto) ? $radno_mjesto->opis_rm : '', ['class' => 'form-control', 'style' => 'height:152px; ', 'id' => 'opis_rm', isset($radno_mjesto) ? 'readonly' : '', 'maxlength' => '5000']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('broj_izvrsilaca', __('Broj izvršilaca').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::number('broj_izvrsilaca', isset($radno_mjesto) ? $radno_mjesto->broj_izvrsilaca : '', ['class' => 'form-control', 'id' => 'broj_izvrsilaca', 'autocomplete' => 'off', isset($radno_mjesto) ? 'readonly' : '', 'min' => 1]) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('platni_razred', __('Platni razred').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('platni_razred', isset($radno_mjesto) ? $radno_mjesto->platni_razred : '', ['class' => 'form-control', 'id' => 'platni_razred', 'autocomplete' => 'off', isset($radno_mjesto) ? 'readonly' : '', 'maxlength' => '50']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="split_container">
                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('stepen', __('Stepen').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!!  Form::select('stepen', $tip_radnog_mjesta, isset($radno_mjesto) ? $radno_mjesto->stepen : '' ,['class' => 'form-control', 'id' => 'stepen', isset($radno_mjesto) ? 'disabled  = "true"' : '']) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('kategorija_rm', __('Kategorija radnog mjesta').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!!  Form::select('kategorija_rm', $kateogrija_radnog, isset($radno_mjesto) ? $radno_mjesto->kategorija_rm : '' ,['class' => 'form-control', 'id' => 'kategorija_rm', isset($radno_mjesto) ? 'disabled  = "true"' : '']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('id_oj', __('Organizaciona jedinica').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!!  Form::select('id_oj', $org_jedinice, isset($radno_mjesto) ? $radno_mjesto->id_oj : '' ,['class' => 'form-control', 'id' => 'id_oj', isset($radno_mjesto) ? 'disabled  = "true"' : '']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('strucna_sprema', __('Kompetencije').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!!  Form::select('strucna_sprema', $kompetencije, isset($radno_mjesto) ? $radno_mjesto->kompetencije : '' ,['class' => 'form-control', 'id' => 'strucna_sprema', isset($radno_mjesto) ? 'disabled  = "true"' : '']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(isset($what))
                        <div class="full_container full_container_b">
                            <div class="form-group row">
                                <div class="col">
                                    {!! Form::label('rjesenje', __('Rješenje').' : ', ['class' => 'control-label']) !!}
                                    <div class="col-lg-12">
                                        {!!  Form::textarea('rjesenje', isset($radno_mjesto) ? $radno_mjesto->rjesenje : '' ,['class' => 'form-control', 'id' => 'rjesenje', 'readonly']) !!}
                                    </div>
                                </div>
                            </  div>
                        </div>
                    @endif
                </div>
            </section>


{{--            <section class="">--}}
{{--                <div class="container_block" >--}}

{{--                    @if(!isset($radno_mjesto))--}}
{{--                        <div class="split_container">--}}
{{--                            <div class="copied_form" id="form_for_copy">--}}
{{--                                <div class="form-group row">--}}
{{--                                    <div class="col">--}}
{{--                                        {!! Form::label('naziv_rm_inp', __('Naziv radnog mjesta').' : ', ['class' => 'control-label']) !!}--}}
{{--                                        <div class="col-lg-12">--}}
{{--                                            {!! Form::text('naziv_rm_inp[]', isset($radno_mjesto) ? $radno_mjesto->naziv_rm : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'naziv_rm_inp', 'readonly']) !!}--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="notificaiton_area" id="naziv_rm_not"> <p id="naziv_rm_not_v"></p> </div>--}}

{{--                                <div class="form-group row">--}}
{{--                                    <div class="col">--}}
{{--                                        {!! Form::label('tekst_uslova_inp', __('Tekst uslova').' : ', ['class' => 'control-label']) !!}--}}
{{--                                        <div class="col-lg-12">--}}
{{--                                            {!! Form::textarea('tekst_uslova_inp[]', '', ['class' => 'form-control', 'rows' => 6, 'id' => 'tekst_uslova_inp', 'maxlength' => '100']) !!}--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group" style="text-align:right; padding-right:16px; margin-top:30px;">--}}
{{--                                <button type="button" class="btn btn-dark" id="custom_button" onclick="createNewDomElements('uslovi_za_radno_mjesto', 'form_for_copy');">--}}
{{--                                    {{__('Dodajte uslov')}}--}}
{{--                                    <i class="fas fa-save"></i>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="split_container" style="padding:0px;">--}}
{{--                            <div id="uslovi_za_radno_mjesto">--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @else--}}
{{--                        @foreach($uslovi as $uslov)--}}
{{--                            <div class="split_container split_container5" style="padding:0px;">--}}
{{--                                <div id="uslovi_za_radno_mjesto">--}}
{{--                                    <div class="copied_form copied_form2" id="form_for_copy">--}}
{{--                                        <div class="form-group row">--}}
{{--                                            <div class="col">--}}
{{--                                                {!! Form::label('naziv_rm_inp', __('Naziv radnog mjesta').' : ', ['class' => 'control-label']) !!}--}}
{{--                                                <div class="col-lg-12">--}}
{{--                                                    {!! Form::text('', isset($radno_mjesto) ? $radno_mjesto->naziv_rm : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'naziv_rm_inp', 'readonly']) !!}--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="form-group row">--}}
{{--                                            <div class="col">--}}
{{--                                                {!! Form::label('tekst_uslova_inp', __('Tekst uslova').' : ', ['class' => 'control-label']) !!}--}}
{{--                                                <div class="col-lg-12">--}}
{{--                                                    {!! Form::textarea('', $uslov->tekst_uslova, ['class' => 'form-control', 'rows' => 6, 'id' => 'tekst_uslova_inp', 'maxlength' => '100', 'readonly']) !!}--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    @endif--}}

{{--                </div>--}}
{{--            </section>--}}


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
