<section class="multi_step_form">
    <form id="msform" class="" method="post"
          action="{{isset($preview) ?  Route('disciplinska.spremi') : Route('disciplinska.azuriraj') }}">

        @csrf
        @if(!isset($disciplinska))
            <div class="tittle">
                <h2>{{__('Unos disciplinske odgovornosti')}}</h2>
                <p>{{__('Molimo Vas da popunite sva potrebna polja za unos. Sve aktivnosti na ovoj stranici će biti zabilježene.')}}</p>
            </div>
        @else
            {!! Form::hidden('disciplinska_id', $disciplinska->id, ['class' => 'form-control', 'readonly']) !!}
        @endif


        <div id="steps-window">
            <div id="msform">
                <div id="steps-window">
                    <ul>
                        <li class="active">
                            <div class="list_div">
                                <div class="back_div"></div>
                                <div class="icon_circle">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <p>{{__('Disciplinska odgovornost')}}</p>
                            </div>
                        </li>
                        <li class="">
                            <div class="list_div">
                                <div class="back_div"></div>
                                <div class="icon_circle">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <p>{{__('Disciplinska komisija')}}</p>
                            </div>
                        </li>
                        <li class="">
                            <div class="list_div">
                                <div class="back_div"></div>
                                <div class="icon_circle">
                                    <i class="fas fa-users"></i>
                                </div>
                                <p>
                                    {{__('Disciplinska komisija')}}
                                </p>

                                <div class="iconsss">
                                    <div class="single-icon steps-going-to" goto="{{Route('disciplinska.uredite', ['id' => $disciplinska->id ?? '1'])}}">
                                        <i class="fas fa-edit"></i>
                                        <p>{{__('Uredite')}}</p>
                                    </div>
                                    <div class="single-icon">
                                        <a href="">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
{{--        @include('hr.disciplinska_odgovornost.fajlovi.top_menu')--}}

        <!-- UNOSO DISCIPLINSKE ODGOVORNOSTI -->
            <section class="active">
                <div class="container_block">
                    <div class="split_container">

                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('opis_povrede', __('Opis povrede').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('opis_povrede', $disciplinska->opis_povrede, ['class' => 'form-control', 'rows' => 1, 'id' => 'naziv_rm', 'onkeyup' => 'verifikuj_string("naziv_rm", "Naziv radnog ne smije sadržavati brojeve !", "ima_li_brojeva"), copy_content(this, ["disc_odg__"]), copy_content(this, ["disc_odg__c"])', 'autocomplete' => 'off', 'maxlength' => '100', isset($preview) ? 'readonly' : '']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('opis_disciplinske_mjere', __('Opis disciplinske mjere').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::textarea('opis_disciplinske_mjere', $disciplinska->opis_disciplinske_mjere, ['class' => 'form-control', 'id' => 'opis_disciplinske_mjere', 'autocomplete' => 'off', isset($preview) ? 'readonly' : '', 'style' => 'height:190px;']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="notificaiton_area" id="naziv_rm_not"><p id="naziv_rm_not_v"></p></div>
                    </div>
                    <div class="split_container">
                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('vrsta_disciplinske', __('Vrsta').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::select('vrsta_disciplinske', ['Nije definisano' => 'Odaberite', 'Teža' => 'Teža', 'Lakša' => 'Lakša'], $disciplinska->vrsta_disciplinske, ['class' => 'form-control', 'id' => 'vrsta_disciplinske', 'autocomplete' => 'off', isset($preview) ? 'disabled => true' : '']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row steppsss">
                            <div class="col">
                                {!! Form::label('datum_povrede', __('Datum konačnosti rješenja').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('datum_povrede', $disciplinska->datumPovrede(), ['class' => 'form-control datepicker', 'id' => 'datum_povrede', 'autocomplete' => 'off', isset($preview) ? 'readonly' : '']) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('sluzbenik_id', __('Službenik').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    @if(isset($preview))
                                        {!! Form::text('sluzbenik_id', $disciplinska->sluzbenik->ime.' '.$disciplinska->sluzbenik->prezime, ['class' => 'form-control', 'readonly']) !!}
                                    @else
                                        {!! Form::select('sluzbenik_id', $nizsluzbenika, $disciplinska->sluzbenik_id, ['class' => 'js-example-basic-single form-control', isset($preview) ? 'disabled' : '', 'style' => 'width:100%;']) !!}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group row steppsss">
                            <div class="col">
                                {!! Form::label('broj_rjesenja_zabrane', __('Broj rješenja zabrane').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('broj_rjesenja_zabrane', $disciplinska->broj_rjesenja_zabrane , ['class' => 'form-control', 'id' => 'broj_rjesenja_zabrane', isset($preview) ? 'readonly' : '']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row steppsss">
                            <div class="col">
                                {!! Form::label('datum_rjesenja_zabrane', __('Datum rješenja zabrane').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('datum_rjesenja_zabrane', $disciplinska->datumZabrane() , ['class' => 'form-control datepicker', 'id' => 'datum_rjesenja_zabrane', isset($preview) ? 'readonly' : '']) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('datum_zavrsetka_zabrane', __('Datum završetka zabrane').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('datum_zavrsetka_zabrane', $disciplinska->datumZavrsetka() , ['class' => 'form-control datepicker', 'id' => 'datum_zavrsetka_zabrane', isset($preview) ? 'readonly' : '']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <!-- Disciplinksa komisija -->
            @include('hr.disciplinska_odgovornost.fajlovi.komisija')



            <!-- Medijatori -->
            @include('hr.disciplinska_odgovornost.fajlovi.medijatori')


            <div class="buttons" style="text-align:center;">
                <button type="button" class="btn btn-dark">
                    <i class="fas fa-chevron-left"></i>
                    {{__('Nazad')}}
                </button>
                <button type="button" class="btn btn-blue">
                    {{__('Dalje')}}
                    <i class="fas fa-chevron-right"></i>
                </button>
                @if(!isset($preview))
                    <button type="submit" class="btn btn-success">
                        <i class="fab fa-telegram"></i>
                        {{__('Spremite')}}
                    </button>
                @endif
            </div>
        </div>
    </form>
</section>
