<div class="drop_down_option">
    <div class="single_row header header2">
        <p>Položeni ispiti</p>
        <i class="fas arrow-icon fa-chevron-down" onclick="prikazi_elemente(2);"></i>
        @if(!isset($pregled))
            <i class="fas fa-plus" title="Dodajte nove podatke o mjestu prebivališta" onclick="prikazi_elemente(2, 'hidden_input_form');"></i>
        @endif
    </div>

    <div class="predefined_elements">

    @php $elements_counter = 0; $index_counter = 0; @endphp <!-- counter za jedinstven ID svakog elementa -->

        @foreach($ispiti as $ispit)
            <div class="preview_elements input_element{{$elements_counter}}">
                @if(!isset($pregled))
                    <div class="edit_elements_icons">
                        <div class="edit_element_icon" title="Uredite" onclick="edit_property(2, '{{$elements_counter}}');">
                            <i class="fas edit_icoon fa-edit"></i>
                        </div>
                        <form action="/hr/sluzbenici/obrisi_sadrzaj/" method="post">
                        @csrf <!-- {{ csrf_field() }} -->

                            <label for="input_form_ispit{{$elements_counter}}">
                                <div class="edit_element_icon edit_element_icon_2" title="Obrišite">
                                    <i class="fa fa-trash"></i>
                                </div>
                            </label>

                            {!! Form::hidden('id_sluzbenika', $id_sluzbenika, []) !!}
                            {!! Form::hidden('id', $ispit->id, []) !!}
                            {!! Form::hidden('tabela', 'sluzbenik_ispiti', []) !!}
                            <input type="submit" id="input_form_ispit{{ $elements_counter++ }}" class="hidden">

                        </form>
                    </div>
                @endif


                <form action="/hr/sluzbenici/izmijeni_sadrzaj/" method="post">
                {!! Form::hidden('id_sluzbenika', $id_sluzbenika, ['class' => 'form-control']) !!}
                {!! Form::hidden('id', $ispit->id, []) !!}
                {!! Form::hidden('tabela', 'sluzbenik_ispiti', ['class' => 'form-control']) !!}
                @csrf <!-- {{ csrf_field() }} -->
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('podkategorija', __('Kategorija ispita').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::select('podkategorija', $kategorija_ispita, $ispit->podkategorija ,['class' => 'form-control read_stuffs', 'id' => 'trenutno_radi', 'disabled' => 'true']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('naziv_ovog_ispita', __('Naziv ispita').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('naziv_ovog_ispita', $ispit->naziv_ovog_ispita, ['class' => 'form-control read_stuffs', 'rows' => 1, 'id' => 'PIO', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('ispit_za_rad', __('-	Ispit za rad u organima javne uprave ').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('ispit_za_rad', $ispit->ispit_za_rad, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'ispit_za_rad', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('pravosudni_isp', __('Pravosudni ispit').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('pravosudni_isp', $ispit->pravosudni_isp, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'pravosudni_isp', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('strucni_isp', __('Stručni ispit').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('strucni_isp', $ispit->strucni_isp, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'strucni_isp', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('nostrifikacija', __('Nostrifikacija').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('nostrifikacija', $ispit->nostrifikacija,['class' => 'form-control read_stuffs', 'maxlength' => '150', 'id' => 'nostrifikacija', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            {!! Form::label('datum_zavrsetka', __('Datum završetka').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('datum_zavrsetka', \App\Http\Controllers\HelpController::obrniDatum($ispit->datum_zavrsetka) , ['class' => 'form-control read_stuffs datepicker', 'id' => 'datum_zavrsetka'.$index_counter++, 'autocomplete' => 'off', 'readonly']) !!}
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
        <form action="/hr/sluzbenici/spremi_sadrzaj/" method="post">
        {!! Form::hidden('id_sluzbenika', $id_sluzbenika, ['class' => 'form-control']) !!}
        {!! Form::hidden('tabela', 'sluzbenik_ispiti', ['class' => 'form-control']) !!}
        @csrf <!-- {{ csrf_field() }} -->
            <div class="add_new_elements">
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('podkategorija', __('Kategorija ispita').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::select('podkategorija', $kategorija_ispita, '' ,['class' => 'form-control', 'id' => 'trenutno_radi']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('naziv_ovog_ispita', __('Naziv ispita').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('naziv_ovog_ispita', '', ['class' => 'form-control', 'rows' => 1, 'id' => 'PIO', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('ispit_za_rad', __('Ispit za rad u organima javne uprave ').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('ispit_za_rad', $value = null, ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'ispit_za_rad', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('pravosudni_isp', __('Pravosudni ispit').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('pravosudni_isp', $value = null, ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'pravosudni_isp', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('strucni_isp', __('Stručni ispit').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('strucni_isp', $value = null, ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'strucni_isp', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('nostrifikacija', __('Nostrifikacija').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::text('nostrifikacija', '' ,['class' => 'form-control', 'maxlength' => '150', 'id' => 'nostrifikacija', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col">
                        {!! Form::label('datum_zavrsetka', __('Datum završetka').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('datum_zavrsetka', '' , ['class' => 'form-control datepicker', 'id' => 'datum_zavrsetka_neki', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>

                <div class="single_row">
                    <div class="col-lg-12">
                        {!! Form::submit(__('Spasite podatke o ispitima'), ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>