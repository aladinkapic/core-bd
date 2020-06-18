<div class="drop_down_option">
    <div class="single_row header header2">
        <p>{{__('Obrazovanje službenika')}}</p>
        <i class="fas arrow-icon fa-chevron-down" onclick="prikazi_elemente(4);"></i>
        @if(!isset($pregled))
            <i class="fas fa-plus" title="Dodajte nove podatke o mjestu prebivališta" onclick="prikazi_elemente(4, 'hidden_input_form');"></i>
        @endif
    </div>

    <div class="predefined_elements">

        @php $elements_counter = 0; $index_counter = 0; @endphp <!-- counter za jedinstven ID svakog elementa -->

        @foreach($obrazovanje_sluzbenika as $o_sluz_s)
        <div class="preview_elements input_element{{$elements_counter}}">
            @if(!isset($pregled))
                <div class="edit_elements_icons">
                    <div class="edit_element_icon" title="Uredite" onclick="edit_property(4, '{{$elements_counter}}');">
                        <i class="fas edit_icoon fa-edit"></i>
                    </div>
                    <form action="/hr/sluzbenici/obrisi_sadrzaj/" method="post">
                    @csrf <!-- {{ csrf_field() }} -->

                        <label for="input_form_obrazovanje{{$elements_counter}}">
                            <div class="edit_element_icon edit_element_icon_2" title="Obrišite">
                                <i class="fa fa-trash"></i>
                            </div>
                        </label>

                        {!! Form::hidden('id_sluzbenika', $id_sluzbenika, []) !!}
                        {!! Form::hidden('id', $o_sluz_s->id, []) !!}
                        {!! Form::hidden('tabela', 'sluzbenik_obrazovanje_sluzbenika', []) !!}
                        <input type="submit" id="input_form_obrazovanje{{ $elements_counter++ }}" class="hidden">

                    </form>
                </div>
            @endif


            <form action="{{route('izmijenite_sadrzaj')}}" method="POST">
                {!! Form::hidden('id_sluzbenika', $id_sluzbenika, ['class' => 'form-control']) !!}
                {!! Form::hidden('id', $o_sluz_s->id, []) !!}
                {!! Form::hidden('tabela', 'sluzbenik_obrazovanje_sluzbenika', ['class' => 'form-control']) !!}
                @csrf <!-- {{ csrf_field() }} -->
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('naziv_ustanove', __('Naziv ustanove').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('naziv_ustanove', $o_sluz_s->naziv_ustanove, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'naziv_ustanove', 'autocomplete' => 'off', 'readonly', 'placeholder' => '']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('sjediste_ustanove', __('Sjedište ustanove').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('sjediste_ustanove', $o_sluz_s->sjediste_ustanove, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'sjediste_ustanove', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('broj_diplome', __('Broj diplome').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('broj_diplome', $o_sluz_s->broj_diplome, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'broj_diplome', 'autocomplete' => 'off', 'readonly', 'placeholder' => '']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('vrsta_obrazovanja', __('Vrsta obrazovanja').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('vrsta_obrazovanja', $o_sluz_s->vrsta_obrazovanja, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'vrsta_obrazovanja', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('datum_izdavanja_dipl', __('Datum završetka').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('datum_izdavanja_dipl', \App\Http\Controllers\HelpController::obrniDatum($o_sluz_s->datum_izdavanja_dipl) , ['class' => 'form-control read_stuffs datepicker', 'id' => 'datum_izdavanja_dipl'.$index_counter++, 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('datum_diplomiranja', __('Datum završetka').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('datum_diplomiranja', \App\Http\Controllers\HelpController::obrniDatum($o_sluz_s->datum_diplomiranja) , ['class' => 'form-control read_stuffs datepicker', 'id' => 'datum_diplomiranja'.$index_counter++, 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('ciklus_obrazovanja', __('Ciklus obrazovanja').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::select('ciklus_obrazovanja', $stepen, $o_sluz_s->ciklus_obrazovanja, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'ciklus_obrazovanja', 'disabled' => 'true', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('strucno_zvanje', __('Stručno zvanje').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('strucno_zvanje', $o_sluz_s->strucno_zvanje ,['class' => 'form-control read_stuffs', 'maxlength' => '50', 'readonly', 'id' => 'strucno_zvanje', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('odsjek', __('Odsjek').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('odsjek', $o_sluz_s->odsjek, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'odsjek', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('broj_nostrifikacije', __('Broj nostrifikacije').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('broj_nostrifikacije', $o_sluz_s->broj_nostrifikacije ,['class' => 'form-control read_stuffs', 'maxlength' => '50', 'id' => 'broj_nostrifikacije', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('datum_nostrifikacije', __('Datum završetka').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('datum_nostrifikacije', \App\Http\Controllers\HelpController::obrniDatum($o_sluz_s->datum_nostrifikacije) , ['class' => 'form-control read_stuffs datepicker', 'id' => 'datum_nostrifikacije'.$index_counter++, 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('rjesenje_izdato_od', __('Rješenje izdato od').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('rjesenje_izdato_od', $o_sluz_s->rjesenje_izdato_od ,['class' => 'form-control read_stuffs', 'maxlength' => '50', 'id' => 'rjesenje_izdato_od', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>

                <div class="single_row">
                    <div class="col-lg-12">
                        {!! Form::submit(__('Izmijenite sadržaj'), ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </form>
        </div>
        @endforeach
    </div>

    <div class="hidden_input_form">
        <form action="{{route('spremite_sadrzaj')}}" method="POST">
            {!! Form::hidden('id_sluzbenika', $id_sluzbenika, ['class' => 'form-control']) !!}
            {!! Form::hidden('tabela', 'sluzbenik_obrazovanje_sluzbenika', ['class' => 'form-control']) !!}
            @csrf <!-- {{ csrf_field() }} -->
            <div class="add_new_elements">
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('naziv_ustanove', __('Naziv ustanove').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('naziv_ustanove', $value = null, ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'naziv_ustanove', 'autocomplete' => 'off', 'placeholder' => '']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('sjediste_ustanove', __('Sjedište ustanove').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('sjediste_ustanove', $value = null, ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'sjediste_ustanove', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('broj_diplome', __('Broj diplome').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('broj_diplome', $value = null, ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'broj_diplome', 'autocomplete' => 'off', 'placeholder' => '']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('vrsta_obrazovanja', __('Vrsta obrazovanja').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('vrsta_obrazovanja', $value = null, ['class' => 'form-control', 'rows' => 1, 'id' => 'vrsta_obrazovanja', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('datum_izdavanja_dipl', __('Datum izdavanja diplome').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('datum_izdavanja_dipl', '' , ['class' => 'form-control datepicker', 'id' => 'datum_izdavanja_dipl', 'autocomplete' => 'off', '']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('datum_diplomiranja', __('Datum diplomiranja').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('datum_diplomiranja', '' , ['class' => 'form-control datepicker', 'id' => 'datum_diplomiranja', 'autocomplete' => 'off', '']) !!}
                        </div>
                    </div>
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('ciklus_obrazovanja', __('Ciklus obrazovanja').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::select('ciklus_obrazovanja', $stepen, $value = null, ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'ciklus_obrazovanja', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('strucno_zvanje', __('Stručno zvanje').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::text('strucno_zvanje', '' ,['class' => 'form-control', 'maxlength' => '50', 'id' => 'strucno_zvanje', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('odsjek', __('Odsjek').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('odsjek', $value = null, ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'odsjek', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('broj_nostrifikacije', __('Broj nostrifikacije').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::text('broj_nostrifikacije', '' ,['class' => 'form-control', 'id' => 'broj_nostrifikacije', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('datum_nostrifikacije', __('Datum nostrifikacije').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('datum_nostrifikacije', '' , ['class' => 'form-control datepicker', 'id' => 'datum_nostrifikacije', 'autocomplete' => 'off', '']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('rjesenje_izdato_od', __('Rješenje izdato od').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::text('rjesenje_izdato_od', '' ,['class' => 'form-control', 'maxlength' => '50', 'id' => 'rjesenje_izdato_od', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>


                <div class="single_row">
                    <div class="col-lg-12">
                        {!! Form::submit(__('Spasite podatke o obrazovanju'), ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
