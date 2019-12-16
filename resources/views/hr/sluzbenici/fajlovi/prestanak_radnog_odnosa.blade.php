<div class="drop_down_option">
    <div class="single_row header header2">
        <p>{{__('Prestanak radnog odnosa')}}</p>
        <i class="fas arrow-icon fa-chevron-down" onclick="prikazi_elemente(8);"></i>
        @if(!isset($pregled))
            <i class="fas fa-plus" title="Dodajte nove podatke o mjestu prebivališta" onclick="prikazi_elemente(8, 'hidden_input_form');"></i>
        @endif
    </div>

    <div class="predefined_elements">

    @php $elements_counter = 0; $index_counter = 0; @endphp <!-- counter za jedinstven ID svakog elementa -->

        @foreach($prestanak_r_o as $prestanak_r_o_s)
            <div class="preview_elements input_element{{$elements_counter}}">
                @if(!isset($pregled))
                    <div class="edit_elements_icons">
                        <div class="edit_element_icon" title="Uredite" onclick="edit_property(8, '{{$elements_counter}}');">
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
                            {!! Form::hidden('id', $prestanak_r_o_s->id, []) !!}
                            {!! Form::hidden('tabela', 'sluzbenik_prestanak_radnog_odnosa', []) !!}
                            <input type="submit" id="input_form_ispit{{ $elements_counter++ }}" class="hidden">

                        </form>
                    </div>
                @endif


                <form action="{{route('izmijenite_sadrzaj')}}" method="POST">
                {!! Form::hidden('id_sluzbenika', $id_sluzbenika, ['class' => 'form-control']) !!}
                {!! Form::hidden('id', $prestanak_r_o_s->id, []) !!}
                {!! Form::hidden('tabela', 'sluzbenik_prestanak_radnog_odnosa', ['class' => 'form-control']) !!}
                @csrf <!-- {{ csrf_field() }} -->
                    <div class="single_row">
                        {!! Form::label('datum_prestanka', __('Datum prestanka').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('datum_prestanka', \App\Http\Controllers\HelpController::obrniDatum($prestanak_r_o_s->datum_prestanka) , ['class' => 'form-control read_stuffs datepicker', 'id' => 'datum_prestanka'.$index_counter++, 'autocomplete' => 'off', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('osnov_za_prestanak', __('Osnov za prestanak').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!!  Form::select('osnov_za_prestanak', $osnov_za_prestanak_rd, $prestanak_r_o_s->osnov_za_prestanak ,['class' => 'form-control read_stuffs', 'disabled' => 'true']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('napomena', __('Napomena').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('napomena', $prestanak_r_o_s->napomena, ['class' => 'form-control read_stuffs',  'maxlength' => '10000', 'rows' => 1, 'id' => 'napomena', 'autocomplete' => 'off', 'readonly']) !!}
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
        <form action="{{route('spremite_sadrzaj')}}" method="POST">
        {!! Form::hidden('id_sluzbenika', $id_sluzbenika, ['class' => 'form-control']) !!}
        {!! Form::hidden('tabela', 'sluzbenik_prestanak_radnog_odnosa', ['class' => 'form-control']) !!}
        @csrf <!-- {{ csrf_field() }} -->
            <div class="add_new_elements">
                <div class="single_row">
                    {!! Form::label('datum_prestanka', __('Datum prestanka').' : ', ['class' => 'control-label']) !!}
                    <div class="col-lg-12">
                        {!! Form::text('datum_prestanka', '' , ['class' => 'form-control datepicker', 'id' => 'datum_prestanka', 'autocomplete' => 'off', '']) !!}
                    </div>
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('osnov_za_prestanak', __('Osnov za prestanak').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!!  Form::select('osnov_za_prestanak', $osnov_za_prestanak_rd, '0' ,['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('napomena', __('Napomena').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('napomena', $value = null, ['class' => 'form-control', 'rows' => 1, 'maxlength' => '10000', 'id' => 'napomena', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>


                <div class="single_row">
                    <div class="col-lg-12">
                        {!! Form::submit(__('Spasite podatke o prestanku radnog odnosa'), ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
