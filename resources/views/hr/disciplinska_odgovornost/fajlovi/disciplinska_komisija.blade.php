<div class="drop_down_option">
    <div class="single_row header">
        <p>{{__('Disciplinska komisija')}}</p>
        <i class="fas arrow-icon fa-chevron-down" onclick="prikazi_elemente(0);"></i>
        @if(!isset($pregled))
            <i class="fas fa-plus" title="Dodajte nove podatke o disciplinskoj komisiji" onclick="prikazi_elemente(0, 'hidden_input_form');"></i>
        @endif
    </div>

    <div class="predefined_elements">

    @php $elements_counter = 0; $index_counter = 0; @endphp <!-- counter za jedinstven ID svakog elementa -->

        @foreach($disciplinske_komisije as $disciplinska_komisija)
            <div class="preview_elements disciplinske_komisije input_element{{$elements_counter}}">
                @if(!isset($pregled))
                    <div class="edit_elements_icons">
                        <div class="edit_element_icon" title="Uredite" onclick="edit_property(0, '{{$elements_counter}}');">
                            <i class="fas edit_icoon fa-edit"></i>
                        </div>
                        <form action="/hr/disciplinska_odgovornost/obrisi_sadrzaj/" method="post">
                        @csrf <!-- {{ csrf_field() }} -->

                            <label for="input_form_komisija{{$elements_counter}}">
                                <div class="edit_element_icon edit_element_icon_2" title="Obrišite">
                                    <i class="fa fa-trash"></i>
                                </div>
                            </label>

                            {!! Form::hidden('disciplinska_odgovornost_id', $disciplinska_odgovornost_id, []) !!}
                            {!! Form::hidden('id', $podatak_o_komisiji->id, []) !!}
                            {!! Form::hidden('tabela', 'disciplinska_odgovornost_podaci_o_komisiji', []) !!}
                            <input type="submit" id="input_form_komisija{{ $elements_counter++ }}" class="hidden">

                        </form>
                    </div>
                @endif


                <form action="/hr/disciplinska_odgovornost/izmijeni_sadrzaj/" method="post">
                {!! Form::hidden('disciplinska_odgovornost_id', $disciplinska_odgovornost_id, ['class' => 'form-control']) !!}
                {!! Form::hidden('id', $podatak_o_komisiji->id, []) !!}
                {!! Form::hidden('tabela', 'disciplinska_odgovornost_podaci_o_komisiji', ['class' => 'form-control']) !!}
                @csrf <!-- {{ csrf_field() }} -->
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('ime_i_prezime', __('Ime i prezime').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('ime_i_prezime', $podatak_o_komisiji->ime_i_prezime, ['class' => 'form-control read_stuffs', 'maxlength' => '100', 'rows' => 1, 'readonly', 'autocomplete' => 'off', 'id' => 'ime_i_prezime', 'onkeyup' => 'verifikuj_string("ime_i_prezime", "Ime i prezime ne smije sadržavati brojeve !", "ima_li_brojeva")']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('institucija', __('Institucija').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('institucija', $podatak_o_komisiji->institucija, ['class' => 'form-control read_stuffs', 'maxlength' => '100', 'rows' => 1, 'id' => 'institucija', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="notificaiton_area" id="ime_i_prezime_not"> <p id="ime_i_prezime_not_v"></p> </div> <!-- obavijest za ime i prezime -->


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
        {!! Form::hidden('tabela', 'disciplinska_odgovornost_podaci_o_komisiji', ['class' => 'form-control']) !!}
        @csrf <!-- {{ csrf_field() }} -->
            <div class="add_new_elements">
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('ime_i_prezime', __('ime_i_prezime').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('ime_i_prezime', $value = null, ['class' => 'form-control', 'maxlength' => '100', 'rows' => 1, 'id' => 'ime_i_prezime_in', 'autocomplete' => 'off', 'onkeyup' => 'verifikuj_string("ime_i_prezime_in", "Ime i prezime ne smije sadržavati brojeve !", "ima_li_brojeva")']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('institucija', __('Institucija').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('institucija', $value = null, ['class' => 'form-control', 'maxlength' => '100', 'rows' => 1, 'id' => 'institucija', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>

                <div class="notificaiton_area" id="ime_i_prezime_in_not"> <p id="ime_i_prezime_in_not_v"></p> </div> <!-- obavijest za ime i prezime -->

                <div class="single_row">
                    <div class="col-lg-12">
                        {!! Form::submit(__('Spasite podatke o discipinskoj kommisiji'), ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>