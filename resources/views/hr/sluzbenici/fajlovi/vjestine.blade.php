<div class="drop_down_option">
    <div class="single_row header header2">
        <p>{{__('Dodatne vještine službenika')}}</p>
        <i class="fas arrow-icon fa-chevron-down" onclick="prikazi_elemente(5);"></i>
        @if(!isset($pregled))
            <i class="fas fa-plus" title="Dodajte nove podatke o mjestu prebivališta" onclick="prikazi_elemente(5, 'hidden_input_form');"></i>
        @endif
    </div>

    <div class="predefined_elements">

    @php $elements_counter = 0; $index_counter = 0; @endphp <!-- counter za jedinstven ID svakog elementa -->

        @foreach($vjestine as $vjestina)
            <div class="preview_elements input_element{{$elements_counter}}">
                @if(!isset($pregled))
                    <div class="edit_elements_icons">
                        <div class="edit_element_icon" title="Uredite" onclick="edit_property(5, '{{$elements_counter}}');">
                            <i class="fas edit_icoon fa-edit"></i>
                        </div>
                        <form action="/hr/sluzbenici/obrisi_sadrzaj/" method="post">
                        @csrf <!-- {{ csrf_field() }} -->

                            <label for="input_form_vjestina{{$elements_counter}}">
                                <div class="edit_element_icon edit_element_icon_2" title="Obrišite">
                                    <i class="fa fa-trash"></i>
                                </div>
                            </label>

                            {!! Form::hidden('id_sluzbenika', $id_sluzbenika, []) !!}
                            {!! Form::hidden('id', $vjestina->id, []) !!}
                            {!! Form::hidden('tabela', 'sluzbenik_vjestine_sluzbenika', []) !!}
                            <input type="submit" id="input_form_vjestina{{ $elements_counter++ }}" class="hidden">

                        </form>
                    </div>
                @endif


                <form action="{{route('izmijenite_sadrzaj')}}" method="POST">
                {!! Form::hidden('id_sluzbenika', $id_sluzbenika, ['class' => 'form-control']) !!}
                {!! Form::hidden('id', $vjestina->id, []) !!}
                {!! Form::hidden('tabela', 'sluzbenik_vjestine_sluzbenika', ['class' => 'form-control']) !!}
                @csrf <!-- {{ csrf_field() }} -->
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('vrsta_vjestine', __('Vrsta vještine').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!!  Form::select('vrsta_vjestine', $vrsta_vjestine, $vjestina->vrsta_vjestine ,['class' => 'form-control read_stuffs', 'disabled' => 'true']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('nivo_vjestine', __('Nivo vještine').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!!  Form::select('nivo_vjestine', $nivo_vjestine, $vjestina->nivo_vjestine ,['class' => 'form-control read_stuffs', 'disabled' => 'true']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('institucija', __('Institucija').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('institucija', $vjestina->institucija, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'institucija', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('broj_uvjerenja', __('Broj uvjerenja').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('broj_uvjerenja', $vjestina->broj_uvjerenja ,['class' => 'form-control read_stuffs', 'maxlength' => '50', 'id' => 'broj_uvjerenja', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('datum_uvjerenja', __('Datum uvjerenja').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('datum_uvjerenja', \App\Http\Controllers\HelpController::obrniDatum($vjestina->datum_uvjerenja) , ['class' => 'form-control read_stuffs datepicker', 'id' => 'datum_uvjerenja'.$index_counter++, 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('komentar', __('Komentar').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('komentar', $vjestina->komentar ,['class' => 'form-control read_stuffs', 'maxlength' => '50', 'id' => 'komentar', 'readonly', 'autocomplete' => 'off']) !!}
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
        {!! Form::hidden('tabela', 'sluzbenik_vjestine_sluzbenika', ['class' => 'form-control']) !!}
        @csrf <!-- {{ csrf_field() }} -->
            <div class="add_new_elements">
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('', __('Vrsta vještine').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!!  Form::select('vrsta_vjestine', $vrsta_vjestine, '0' ,['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('nivo_vjestine', __('Nivo vještine').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!!  Form::select('nivo_vjestine', $nivo_vjestine, '' ,['class' => 'form-control read_stuffs']) !!}
                        </div>
                    </div>
                </div>
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('institucija', __('Institucija').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('institucija', $value = null, ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'institucija', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('broj_uvjerenja', __('Broj uvjerenja').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::text('broj_uvjerenja', '' ,['class' => 'form-control', 'maxlength' => '50', 'id' => 'broj_uvjerenja', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('datum_uvjerenja', __('Datum uvjerenja').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('datum_uvjerenja', '' , ['class' => 'form-control datepicker', 'id' => 'datum_uvjerenja', 'autocomplete' => 'off', '']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('komentar', __('Komentar').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::text('komentar', '' ,['class' => 'form-control', 'maxlength' => '50', 'id' => 'komentar', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>


                <div class="single_row">
                    <div class="col-lg-12">
                        {!! Form::submit(__('Spasite podatke o vještinama'), ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
