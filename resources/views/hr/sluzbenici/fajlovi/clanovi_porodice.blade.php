<div class="drop_down_option">
    <div class="single_row header header2">
        <p>{{__('Članovi porodice')}}</p>
        <i class="fas arrow-icon fa-chevron-down" onclick="prikazi_elemente(9);"></i>
        @if(!isset($pregled))
            <i class="fas fa-plus" title="Dodajte nove podatke o mjestu prebivališta" onclick="prikazi_elemente(9, 'hidden_input_form');"></i>
        @endif
    </div>

    <div class="predefined_elements">

    @php $elements_counter = 0; $index_counter = 0; @endphp <!-- counter za jedinstven ID svakog elementa -->

        @foreach($clanovi_porodice as $clanovi_porodice_s)
            <div class="preview_elements input_element{{$elements_counter ?? '/'}}">
                @if(!isset($pregled))
                    <div class="edit_elements_icons">
                        <div class="edit_element_icon" title="Uredite" onclick="edit_property(9, '{{$elements_counter}}');">
                            <i class="fas edit_icoon fa-edit"></i>
                        </div>
                        <form action="/hr/sluzbenici/obrisi_sadrzaj/" method="post">
                        @csrf <!-- {{ csrf_field() }} -->

                            <label for="input_form_ispit{{$elements_counter ?? '/'}}">
                                <div class="edit_element_icon edit_element_icon_2" title="Obrišite">
                                    <i class="fa fa-trash"></i>
                                </div>
                            </label>

                            {!! Form::hidden('id_sluzbenika', $id_sluzbenika, []) !!}
                            {!! Form::hidden('id', $clanovi_porodice_s->id, []) !!}
                            {!! Form::hidden('tabela', 'sluzbenik_clanovi_porodice', []) !!}
                            <input type="submit" id="input_form_ispit{{ $elements_counter++ }}" class="hidden">

                        </form>
                    </div>
                @endif

                <form action="/hr/sluzbenici/izmijeni_sadrzaj/" method="post">
                {!! Form::hidden('id_sluzbenika', $id_sluzbenika, ['class' => 'form-control']) !!}
                {!! Form::hidden('id', $clanovi_porodice_s->id, []) !!}
                {!! Form::hidden('tabela', 'sluzbenik_clanovi_porodice', ['class' => 'form-control']) !!}
                @csrf <!-- {{ csrf_field() }} -->
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('datum_rodjenja', __('Datum rođenja').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('datum_rodjenja', \App\Http\Controllers\HelpController::obrniDatum($clanovi_porodice_s->datum_rodjenja) , ['class' => 'form-control read_stuffs datepicker', 'id' => 'datum_rodjenja'.$index_counter++, 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('srodstvo', __('Srodstvo').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!!  Form::select('srodstvo', $srodstvo, $clanovi_porodice_s->srodstvo ,['class' => 'form-control read_stuffs', 'id' => 'srodstvo', 'disabled' => 'true']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('napomena', __('Napomena').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('napomena', $clanovi_porodice_s->napomena, ['class' => 'form-control read_stuffs', 'maxlength' => '10000', 'rows' => 1, 'id' => 'napomena', 'autocomplete' => 'off', 'readonly']) !!}
                        </div>
                    </div>

                    <div class="single_row">
                        <div class="col-lg-12">
                            {!! Form::submit('Spasite izmjene', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                </form>
            </div>
        @endforeach
    </div>

    <div class="hidden_input_form">
        <form action="{{route('spremite_sadrzaj')}}" method="POST">
        {!! Form::hidden('id_sluzbenika', $id_sluzbenika, ['class' => 'form-control']) !!}
        {!! Form::hidden('tabela', 'sluzbenik_clanovi_porodice', ['class' => 'form-control']) !!}
        @csrf <!-- {{ csrf_field() }} -->
            <div class="add_new_elements">
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('datum_rodjenja', __('Datum rođenja').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('datum_rodjenja', '' , ['class' => 'form-control datepicker', 'id' => 'datum_rodjenja', 'autocomplete' => 'off', '']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('srodstvo', __('Srodstvo').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!!  Form::select('srodstvo', $srodstvo, '0' ,['class' => 'form-control', 'id' => 'srodstvo']) !!}
                        </div>
                    </div>
                </div>
                <div class="single_row">
                    {!! Form::label('napomena', __('Napomena').' : ', ['class' => 'control-label']) !!}
                    <div class="col-lg-12">
                        {!! Form::text('napomena', $value = null, ['class' => 'form-control', 'rows' => 1, 'maxlength' => '10000', 'id' => 'napomena', 'autocomplete' => 'off']) !!}
                    </div>
                </div>

                <div class="single_row">
                    <div class="col-lg-12">
                        {!! Form::submit('Spasite podatke o članovima porodice', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
