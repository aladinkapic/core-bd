<section class="multi_step_form">
    <form id="msform" class=""  method="post" action="{{isset($dOdgovornost) ?  '/hr/disciplinska_odgovornost/updateOdgovornost/'.$uprava->id : '/hr/disciplinska_odgovornost/storeOdgovornost' }}">

        @csrf
        @if(!isset($disciplinska))
            <div class="tittle">
                <h2>{{__('Unos disciplinske odgovornosti')}}</h2>
                <p>{{__('Molimo Vas da popunite sva potrebna polja za unos. Sve aktivnosti na ovoj stranici će biti zabilježene.')}}</p>
            </div>
        @endif


        <div id="steps-window">

            @include('hr.disciplinska_odgovornost.fajlovi.top_menu')

            <!-- UNOSO DISCIPLINSKE ODGOVORNOSTI -->
            <section class="active">
                <div class="container_block">
                    <div class="split_container">
                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('opis_povrede', 'Opis povrede : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('opis_povrede', '', ['class' => 'form-control', 'rows' => 1, 'id' => 'naziv_rm', 'onkeyup' => 'verifikuj_string("naziv_rm", "Naziv radnog ne smije sadržavati brojeve !", "ima_li_brojeva"), copy_content(this, ["disc_odg__"]), copy_content(this, ["disc_odg__c"])', 'autocomplete' => 'off', 'maxlength' => '100', isset($radno_mjesto) ? 'readonly' : '']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="notificaiton_area" id="opis_povrede_not"> <p id="opis_povrede_not_v"></p> </div>
                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('opis_disciplinske_mjere', 'Opis disciplinske mjere : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::textarea('opis_disciplinske_mjere', '', ['class' => 'form-control', 'id' => 'opis_disciplinske_mjere', 'autocomplete' => 'off', isset($radno_mjesto) ? 'readonly' : '', 'style' => 'height:190px;']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="split_container">
                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('vrsta_disciplinske', 'Vrsta : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::select('vrsta_disciplinske', ['Nije definisano' => 'Odaberite', 'Teža' => 'Teža', 'Lakša' => 'Lakša'], '', ['class' => 'form-control', 'id' => 'vrsta_disciplinske', 'autocomplete' => 'off', isset($radno_mjesto) ? 'readonly' : '', 'rows' => 4]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row steppsss">
                            <div class="col">
                                {!! Form::label('datum_povrede', 'Datum konačnosti rješenja : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('datum_povrede', '', ['class' => 'form-control datepicker', 'id' => 'datum_povrede', 'autocomplete' => 'off']) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('sluzbenik_id', 'Službenik : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    <select class="js-example-basic-single form-control"
                                            name="sluzbenik_id" style="width:100%">
                                        @foreach($nizsluzbenika as $id => $imeprezime)
                                            <option value="{{$id}}">{{$imeprezime}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row steppsss">
                            <div class="col">
                                {!! Form::label('broj_rjesenja_zabrane', __('Broj rješenja zabrane').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('broj_rjesenja_zabrane', '' , ['class' => 'form-control', 'id' => 'broj_rjesenja_zabrane']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row steppsss">
                            <div class="col">
                                {!! Form::label('datum_rjesenja_zabrane', __('Datum rješenja zabrane').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('datum_rjesenja_zabrane', '' , ['class' => 'form-control datepicker', 'id' => 'datum_rjesenja_zabrane']) !!}
                                </div>
                            </div>
{{--                            <div class="col">--}}
{{--                                {!! Form::label('datum_zavrsetka_zabrane', __('Datum završetka zabrane').' : ', ['class' => 'control-label']) !!}--}}
{{--                                <div class="col-lg-12">--}}
{{--                                    {!! Form::text('datum_zavrsetka_zabrane', '' , ['class' => 'form-control datepicker', 'id' => 'datum_zavrsetka_zabrane']) !!}--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </section>



            <!-- Disciplinksa komisija -->
            <section class="">
                <div class="container_block" >
                    <div class="split_container">
                        <div class="copied_form" id="form_for_copy">
                            {{--<div class="form-group row">--}}
                                {{--<div class="col">--}}
                                    {{--{!! Form::label('discp_odg_____', 'Opis povrede : ', ['class' => 'control-label']) !!}--}}
                                    {{--<div class="col-lg-12">--}}
                                        {{--{!! Form::text('discp_odg_____[]', '', ['class' => 'form-control readmeebaby', 'rows' => 1, 'id' => 'disc_odg__', 'readonly']) !!}--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group row">
                                <div class="col">
                                    {!! Form::label('sluzbenik_id_kom', 'Ime i prezime službenika : ', ['class' => 'control-label']) !!}
                                    <div class="col-lg-12">
                                        <select class="js-example-basic-single form-control"
                                                name="sluzbenik_id_kom[]" style="width:100%">
                                            <option value="0">{{__('Izaberite službenika')}}</option>
                                            @foreach($nizsluzbenika as $id => $imeprezime)
                                                <option value="{{$id}}">{{$imeprezime}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    {!! Form::label('sluzbenik_id_kom_e[]', 'Ime i prezime službenika : ', ['class' => 'control-label']) !!}
                                    <div class="col-lg-12">
                                        {!!  Form::text('sluzbenik_id_kom_e[]', '' ,['class' => 'form-control', 'id' => 'sluzbenik_id_kom_e']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    {!! Form::label('oju_kom', 'Organ Javne uprave : ', ['class' => 'control-label']) !!}
                                    <div class="col-lg-12">
                                        {!!  Form::select('oju_kom[]', $organi, '' ,['class' => 'form-control', 'id' => 'oju_kom']) !!}
                                    </div>
                                </div>
                                <div class="col">
                                    {!! Form::label('oju_kom_e', 'Institucija : ', ['class' => 'control-label']) !!}
                                    <div class="col-lg-12">
                                        {!!  Form::text('oju_kom_e[]', '' ,['class' => 'form-control', 'id' => 'oju_kom_e']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="text-align:right; padding-right:16px; margin-top:30px;">
                            <button type="button" class="btn btn-dark" id="custom_button" onclick="createNewDomElements('uslovi_za_radno_mjesto', 'form_for_copy');">
                                {{__('Dodajte člana komisije')}}
                                <i style="margin-left:15px;" class="fas fa-save"></i>
                            </button>
                        </div>
                    </div>
                    <div class="split_container" style="padding:0px;">
                        <div id="uslovi_za_radno_mjesto">

                        </div>
                    </div>
                </div>
            </section>



            <!-- Medijatori -->
            <section class="">
                <div class="container_block" >
                    <div class="split_container">
                        <div class="copied_form" id="nekaamo">
                            {{--<div class="form-group row">--}}
                                {{--<div class="col">--}}
                                    {{--{!! Form::label('discp_odg_____c', 'Opis povrede : ', ['class' => 'control-label']) !!}--}}
                                    {{--<div class="col-lg-12">--}}
                                        {{--{!! Form::text('discp_odg_____c[]', '', ['class' => 'form-control readmeebaby', 'rows' => 1, 'id' => 'disc_odg__c', 'readonly']) !!}--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group row">
                                <div class="col">
                                    {!! Form::label('sluzbenik_id_med', 'Ime i prezime službenika : ', ['class' => 'control-label']) !!}
                                    <div class="col-lg-12">
                                        <select class="js-example-basic-single form-control"
                                                name="sluzbenik_id_med[]" style="width:100%">
                                            <option value="0">{{__('Izaberite službenika')}}</option>
                                            @foreach($nizsluzbenika as $id => $imeprezime)
                                                <option value="{{$id}}">{{$imeprezime}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    {!! Form::label('sluzbenik_id_med_e[]', 'Ime i prezime službenika : ', ['class' => 'control-label']) !!}
                                    <div class="col-lg-12">
                                        {!!  Form::text('sluzbenik_id_med_e[]', '' ,['class' => 'form-control', 'id' => 'sluzbenik_id_med_e']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    {!! Form::label('oju_med', 'Organ Javne uprave : ', ['class' => 'control-label']) !!}
                                    <div class="col-lg-12">
                                        {!!  Form::select('oju_med[]', $organi, '' ,['class' => 'form-control', 'id' => 'oju_med']) !!}
                                    </div>
                                </div>

                                <div class="col">
                                    {!! Form::label('oju_med_e', 'Institucija : ', ['class' => 'control-label']) !!}
                                    <div class="col-lg-12">
                                        {!!  Form::text('oju_med_e[]', '' ,['class' => 'form-control', 'id' => 'oju_med_e']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="text-align:right; padding-right:16px; margin-top:30px;">
                            <button type="button" class="btn btn-dark" id="custom_button" onclick="createNewDomElements('korisnici', 'nekaamo');">
                                {{__('Dodajte medijatora')}}
                                <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </div>
                    <div class="split_container" style="padding:0px;">
                        <div id="korisnici">

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
                   {{__(' Spremite')}}
                </button>
            </div>
        </div>
    </form>
</section>
