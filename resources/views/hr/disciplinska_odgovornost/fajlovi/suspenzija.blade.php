<div class="drop_down_option">
    <div class="single_row header">
        <p>Suspenzija</p>
        <i class="fas arrow-icon fa-chevron-down" onclick="prikazi_elemente(0);"></i>
        @if(!isset($pregled))
            <i class="fas fa-plus" title="Dodajte nove podatke o suspenziji" onclick="prikazi_elemente(0, 'hidden_input_form');"></i>
        @endif
    </div>

    <div class="predefined_elements">

    @php $elements_counter = 0; $index_counter = 0; @endphp <!-- counter za jedinstven ID svakog elementa -->

        @foreach($suspenzije as $suspenzija)
            <div class="preview_elements suspenzije input_element{{$elements_counter}}">
                @if(!isset($pregled))
                    <div class="edit_elements_icons">
                        <div class="edit_element_icon" title="Uredite" onclick="edit_property(0, '{{$elements_counter}}');">
                            <i class="fas edit_icoon fa-edit"></i>
                        </div>
                        <form action="/hr/disciplinska_odgovornost/obrisi_sadrzaj/" method="post">
                        @csrf <!-- {{ csrf_field() }} -->

                            <label for="input_form_suspenzija{{$elements_counter}}">
                                <div class="edit_element_icon edit_element_icon_2" title="Obrišite">
                                    <i class="fa fa-trash"></i>
                                </div>
                            </label>

                            {!! Form::hidden('disciplinska_odgovornost_id', $disciplinska_odgovornost_id, []) !!}
                            {!! Form::hidden('id', $podatak_o_suspenziji->id, []) !!}
                            {!! Form::hidden('tabela', 'disciplinska_odgovornost_podaci_o_suspenzijama', []) !!}
                            <input type="submit" id="input_form_suspenzija{{ $elements_counter++ }}" class="hidden">

                        </form>
                    </div>
                @endif


                <form action="/hr/disciplinska_odgovornost/izmijeni_sadrzaj/" method="post">
                {!! Form::hidden('disciplinska_odgovornost_id', $disciplinska_odgovornost_id, ['class' => 'form-control']) !!}
                {!! Form::hidden('id', $podatak_o_suspenzijama->id, []) !!}
                {!! Form::hidden('tabela', 'disciplinska_odgovornost_podaci_o_suspenzijama', ['class' => 'form-control']) !!}
                @csrf <!-- {{ csrf_field() }} -->
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('broj_rjesenja', __('Broj rješenja').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('broj_rjesenja', $podatak_o_suspenzijama->broj_rjesenja, ['class' => 'form-control read_stuffs', 'maxlength' => '100', 'rows' => 1, 'id' => 'broj_rjesenja', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('razlog_udaljenja', __('Razlog udaljenja').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::textarea('razlog_udaljenja', $podatak_o_suspenzijama->razlog_udaljenja, ['class' => 'form-control read_stuffs', 'maxlength' => '100', 'rows' => 1, 'id' => 'razlog_udaljenja', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('datum_udaljenja', __('Datum udaljenja').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('datum_udaljenja', $podatak_o_suspenzijama->datum_udaljenja, ['class' => 'form-control date_picker read_stuffs', 'maxlength' => '100', 'rows' => 1, 'id' => 'datum_udaljenja', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>

                    </div>


                    <div class="single_row">
                        <div class="col-lg-12">
                            {!! Form::submit(__('Spasite izmjene'), ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                </form>
            </div>
        @endforeach
    </div>

    <div class="hidden_input_form">
        <form action="/hr/disciplinska_odgovornost/spremi_sadrzaj/" method="post">
        {!! Form::hidden('disciplinska_odgovornost_id', $disciplinska_odgovornost_id, ['class' => 'form-control']) !!}
        {!! Form::hidden('tabela', 'disciplinska_odgovornost_podaci_o_suspenzijama', ['class' => 'form-control']) !!}
        @csrf <!-- {{ csrf_field() }} -->
            <div class="add_new_elements">
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('broj_rjesenja', __('broj_rjesenja').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('broj_rjesenja', $value = null, ['class' => 'form-control', 'maxlength' => '100', 'rows' => 1, 'id' => 'broj_rjesenja_in', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('razlog_udaljenja', __('razlog_udaljenja').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::textarea('razlog_udaljenja', $value = null, ['class' => 'form-control', 'maxlength' => '100', 'rows' => 1, 'id' => 'razlog_udaljenja_in', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('datum_udaljenja', __('Datum udaljenja').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('datum_udaljenja', $value = null, ['class' => 'form-control date_picker', 'maxlength' => '100', 'rows' => 1, 'id' => 'datum_udaljenja', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>

                <div class="single_row">
                    <div class="col-lg-12">
                        {!! Form::submit(__('Spasite podatke o suspenziji'), ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>