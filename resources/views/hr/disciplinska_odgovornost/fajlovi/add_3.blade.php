<section class="multi_step_form">
    <form id="msform" class=""  method="post" action="{{isset($preview) ?  Route('disciplinska.spremi') : Route('disciplinska.azuriraj') }}">

        @csrf
        @if(!isset($disciplinska))
            <div class="tittle">
                <h2>Unos disciplinske odgovornosti</h2>
                <p>Molimo Vas da popunite sva potrebna polja za unos. Sve aktivnosti na ovoj stranici će biti zabilježene.</p>
            </div>
        @else
            {!! Form::hidden('disciplinska_id', $disciplinska->id, ['class' => 'form-control', 'readonly']) !!}
        @endif


        <div id="steps-window">

            @include('hr.disciplinska_odgovornost.fajlovi.top_menu')

            <!-- UNOSO DISCIPLINSKE ODGOVORNOSTI -->
            <section class="">
                <div class="container_block">
                    <div class="split_container">

                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('opis_povrede', 'Opis povrede : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('opis_povrede', $disciplinska->opis_povrede, ['class' => 'form-control', 'rows' => 1, 'id' => 'naziv_rm', 'onkeyup' => 'verifikuj_string("naziv_rm", "Naziv radnog ne smije sadržavati brojeve !", "ima_li_brojeva"), copy_content(this, ["disc_odg__"]), copy_content(this, ["disc_odg__c"])', 'autocomplete' => 'off', 'maxlength' => '100', isset($preview) ? 'readonly' : '']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('opis_disciplinske_mjere', 'Opis disciplinske mjere : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::textarea('opis_disciplinske_mjere', $disciplinska->opis_disciplinske_mjere, ['class' => 'form-control', 'id' => 'opis_disciplinske_mjere', 'autocomplete' => 'off', isset($preview) ? 'readonly' : '', 'rows' => 4]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="notificaiton_area" id="naziv_rm_not"> <p id="naziv_rm_not_v"></p> </div>
                    </div>
                    <div class="split_container">
                        <div class="form-group row steppsss">
                            <div class="col">
                                {!! Form::label('datum_povrede', 'Datum povrede : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('datum_povrede', $disciplinska->datum_povrede, ['class' => 'form-control datepicker', 'id' => 'datum_povrede', 'autocomplete' => 'off', isset($preview) ? 'readonly' : '']) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('sluzbenik_id', 'Službenik : ', ['class' => 'control-label']) !!}
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
                                    {!! Form::text('datum_rjesenja_zabrane', $disciplinska->datum_rjesenja_zabrane , ['class' => 'form-control datepicker', 'id' => 'datum_rjesenja_zabrane', isset($preview) ? 'readonly' : '']) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('datum_zavrsetka_zabrane', __('Datum završetka zabrane').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('datum_zavrsetka_zabrane', $disciplinska->datum_zavrsetka_zabrane , ['class' => 'form-control datepicker', 'id' => 'datum_zavrsetka_zabrane', isset($preview) ? 'readonly' : '']) !!}
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
                <button type="button" class="btn btn-dark" >
                    <i class="fas fa-chevron-left"></i>
                    Nazad
                </button>
                <button type="button" class="btn btn-blue" >
                    Dalje
                    <i class="fas fa-chevron-right"></i>
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="fab fa-telegram"></i>
                    Spremite
                </button>
            </div>
        </div>
    </form>
</section>