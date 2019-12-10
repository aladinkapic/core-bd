<div class="drop_down_option">
    <div class="single_row header">
        <p>{{__('Podaci o prebivalištu')}}</p>
        <i class="fas arrow-icon fa-chevron-down" onclick="prikazi_elemente(0);"></i>
        @if(!isset($pregled))
            <i class="fas fa-plus" title="Dodajte nove podatke o mjestu prebivališta" onclick="prikazi_elemente(0, 'hidden_input_form');"></i>
        @endif
    </div>

    <div class="predefined_elements">

    @php $elements_counter = 0; $index_counter = 0; @endphp <!-- counter za jedinstven ID svakog elementa -->

        @foreach($podaci_o_prebivalistu as $podatak_o_prebivalistu)
            <div class="preview_elements podaci_o_prebivalistu input_element{{$elements_counter}}">
                @if(!isset($pregled))
                    <div class="edit_elements_icons">
                        <div class="edit_element_icon" title="Uredite" onclick="edit_property(0, '{{$elements_counter}}');">
                            <i class="fas edit_icoon fa-edit"></i>
                        </div>
                        <form action="/hr/sluzbenici/obrisi_sadrzaj/" method="post">
                        @csrf <!-- {{ csrf_field() }} -->

                            <label for="input_form_prebivaliste{{$elements_counter}}">
                                <div class="edit_element_icon edit_element_icon_2" title="Obrišite">
                                    <i class="fa fa-trash"></i>
                                </div>
                            </label>

                            {!! Form::hidden('id_sluzbenika', $id_sluzbenika, []) !!}
                            {!! Form::hidden('id', $podatak_o_prebivalistu->id, []) !!}
                            {!! Form::hidden('tabela', 'sluzbenik_podaci_o_prebivalistu', []) !!}
                            <input type="submit" id="input_form_prebivaliste{{ $elements_counter++ }}" class="hidden">

                        </form>
                    </div>
                @endif


                <form action="/hr/sluzbenici/izmijeni_sadrzaj/" method="post">
                {!! Form::hidden('id_sluzbenika', $id_sluzbenika, ['class' => 'form-control']) !!}
                {!! Form::hidden('id', $podatak_o_prebivalistu->id, []) !!}
                {!! Form::hidden('tabela', 'sluzbenik_podaci_o_prebivalistu', ['class' => 'form-control']) !!}
                @csrf <!-- {{ csrf_field() }} -->
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('mjesto_prebivalista', __('Mjesto prebivališta').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('mjesto_prebivalista', $podatak_o_prebivalistu->mjesto_prebivalista, ['class' => 'form-control read_stuffs', 'maxlength' => '100', 'rows' => 1, 'readonly', 'autocomplete' => 'off', 'id' => 'mjesto_prebivalista', 'onkeyup' => 'verifikuj_string("mjesto_prebivalista", "Mjesto prebivališta ne smije sadržavati brojeve !", "ima_li_brojeva")']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('adresa_prebivalista', __('Adresa prebivališta').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('adresa_prebivalista', $podatak_o_prebivalistu->adresa_prebivalista, ['class' => 'form-control read_stuffs', 'maxlength' => '100', 'rows' => 1, 'id' => 'adresa_prebivalista', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="notificaiton_area" id="mjesto_prebivalista_not"> <p id="mjesto_prebivalista_not_v"></p> </div> <!-- obavijest za mjesto_prebivalista -->


                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('adresa_boravista', __('Adresa boravišta').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('adresa_boravista', $podatak_o_prebivalistu->adresa_boravista, ['class' => 'form-control read_stuffs', 'maxlength' => '100', 'rows' => 1, 'readonly', 'autocomplete' => 'off', 'id' => 'adresa_boravista', 'onkeyup' => 'verifikuj_string("mjesto_prebivalista", "Adresa boravišta ne smije sadržavati brojeve !", "ima_li_brojeva")']) !!}
                            </div>
                        </div>
                        @if(isset($podatak_o_prebivalistu->datum_do))

                        @endif
                        <div class="single_row">
                            {!! Form::label('datum_do', __('Datum do').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('datum_do', \App\Http\Controllers\HelpController::obrniDatum($podatak_o_prebivalistu->datum_do), ['class' => 'form-control read_stuffs datepicker', 'maxlength' => '100', 'rows' => 1, 'id' => 'datum_do'.$index_counter++, 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>


{{--                    <div class="single_row">--}}
{{--                        {!! Form::label('', __('Adresa boravišta').' : ', ['class' => 'control-label']) !!}--}}
{{--                        <div class="col-lg-12">--}}
{{--                            {!! Form::text('adresa_boravista', $podatak_o_prebivalistu->adresa_boravista, ['class' => 'form-control read_stuffs', 'maxlength' => '100', 'rows' => 1, 'id' => 'adresa_boravista', 'readonly', 'autocomplete' => 'off',]) !!}--}}
{{--                        </div>--}}
{{--                    </div>--}}

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
        {!! Form::hidden('tabela', 'sluzbenik_podaci_o_prebivalistu', ['class' => 'form-control']) !!}
        @csrf <!-- {{ csrf_field() }} -->
            <div class="add_new_elements">
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('mjesto_prebivalista', __('Mjesto prebivališta').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('mjesto_prebivalista', $value = null, ['class' => 'form-control', 'maxlength' => '100', 'rows' => 1, 'id' => 'mjesto_prebivalista_in', 'autocomplete' => 'off', 'onkeyup' => 'verifikuj_string("mjesto_prebivalista_in", "Mjesto prebivališta ne smije sadržavati brojeve !", "ima_li_brojeva")']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('adresa_prebivalista', __('Adresa prebivališta').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('adresa_prebivalista', $value = null, ['class' => 'form-control', 'maxlength' => '100', 'rows' => 1, 'id' => 'adresa_prebivalista', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>

                <div class="notificaiton_area" id="mjesto_prebivalista_in_not"> <p id="mjesto_prebivalista_in_not_v"></p> </div> <!-- obavijest za mjesto_prebivalista -->

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('adresa_boravista', __('Adresa boravišta').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('adresa_boravista', '', ['class' => 'form-control read_stuffs', 'maxlength' => '100', 'rows' => 1, '', 'autocomplete' => 'off', 'id' => 'adresa_boravista', 'onkeyup' => 'verifikuj_string("mjesto_prebivalista", "Adresa boravišta ne smije sadržavati brojeve !", "ima_li_brojeva")']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('datum_do', __('Datum do').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('datum_do','', ['class' => 'form-control read_stuffs datepicker', 'maxlength' => '100', 'rows' => 1, 'id' => 'datum_doeeee', 'readonly', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>


{{--                <div class="single_row">--}}
{{--                    {!! Form::label('adresa_boravista', __('Adresa boravišta').' : ', ['class' => 'control-label']) !!}--}}
{{--                    <div class="col-lg-12">--}}
{{--                        {!! Form::text('adresa_boravista', $value = null, ['class' => 'form-control', 'maxlength' => '100', 'rows' => 1, 'id' => 'adresa_boravista', 'autocomplete' => 'off']) !!}--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="single_row">
                    <div class="col-lg-12">
                        {!! Form::submit(__('Spasite podatke o prebivalištu'), ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>