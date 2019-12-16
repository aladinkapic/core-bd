<div class="drop_down_option">
    <div class="single_row header header2">
        <p>{{__('Podaci o stručnoj spremi')}}</p>
        <i class="fas arrow-icon fa-chevron-down" onclick="prikazi_elemente(1);"></i>
        @if(!isset($pregled))
            <i class="fas fa-plus" title="Dodajte nove podatke o mjestu prebivališta" onclick="prikazi_elemente(1, 'hidden_input_form');"></i>
        @endif
    </div>

    <div class="predefined_elements">

    @php $elements_counter = 0; $index_counter = 0; @endphp <!-- counter za jedinstven ID svakog elementa -->

        @foreach($strucna_sprema as $strucna_sprema_s)
            <div class="preview_elements input_element{{$elements_counter}}">
                @if(!isset($pregled))
                    <div class="edit_elements_icons">
                        <div class="edit_element_icon" title="Uredite" onclick="edit_property(1, '{{$elements_counter}}');">
                            <i class="fas edit_icoon fa-edit"></i>
                        </div>
                        <form action="/hr/sluzbenici/obrisi_sadrzaj/" method="post">
                        @csrf <!-- {{ csrf_field() }} -->

                            <label for="input_form_ss{{$elements_counter}}">
                                <div class="edit_element_icon edit_element_icon_2" title="Obrišite">
                                    <i class="fa fa-trash"></i>
                                </div>
                            </label>

                            {!! Form::hidden('id_sluzbenika', $id_sluzbenika, []) !!}
                            {!! Form::hidden('id', $strucna_sprema_s->id, []) !!}
                            {!! Form::hidden('tabela', 'sluzbenik_strucna_sprema', []) !!}
                            <input type="submit" id="input_form_ss{{ $elements_counter++ }}" class="hidden">

                        </form>
                    </div>
                @endif


                <form action="{{route('izmijenite_sadrzaj')}}" method="POST">
                {!! Form::hidden('id_sluzbenika', $id_sluzbenika, ['class' => 'form-control']) !!}
                {!! Form::hidden('id', $strucna_sprema_s->id, []) !!}
                {!! Form::hidden('tabela', 'sluzbenik_strucna_sprema', ['class' => 'form-control']) !!}
                @csrf <!-- {{ csrf_field() }} -->

                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('stepen_s_s', __('Stepen stručne spreme').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('stepen_s_s', $strucna_sprema_s->stepen_s_s, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'stepen_s_s', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('vrsta_s_s', __('Vrsta stručne spreme').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('vrsta_s_s', $strucna_sprema_s->vrsta_s_s , ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'vrsta_s_s', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('komenta_o_diplomi', __('Komentar o diplomi').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('komenta_o_diplomi', $strucna_sprema_s->komenta_o_diplomi, ['class' => 'form-control read_stuffs', 'maxlength' => '100', 'rows' => 1, 'id' => 'komenta_o_diplomi', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('datum_zavrsetka', __('Datum završetka').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('datum_zavrsetka', \App\Http\Controllers\HelpController::obrniDatum($strucna_sprema_s->datum_zavrsetka) , ['class' => 'form-control read_stuffs datepicker',  'id' => 'datum_zavrsetka'.$index_counter++, 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('obrazovna_institucija', __('Obrazovna institucija').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!!  Form::select('obrazovna_institucija', $obrazovnaInstitucija, $strucna_sprema_s->obrazovna_institucija ,['class' => 'form-control read_stuffs', 'disabled' => 'true']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('nostrifikacija', __('Broj nostrifikacije').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('nostrifikacija', $strucna_sprema_s->nostrifikacija, ['class' => 'form-control read_stuffs', 'rows' => 1,  'maxlength' => '150', 'id' => 'nostrifikacija', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                    </div>


                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('diploma_poslana_na_provjeru', __('Diploma poslana na provjeru').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::select('diploma_poslana_na_provjeru', ['0' => 'NE', '1' => 'DA'], $strucna_sprema_s->diploma_poslana_na_provjeru ,['class' => 'form-control read_stuffs', 'disabled' => 'true']) !!}</div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('diploma_vracena_sa_provjere', __('Diploma vraćena sa provjere').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::select('diploma_vracena_sa_provjere', ['0' => 'NE', '1' => 'DA'], $strucna_sprema_s->diploma_vracena_sa_provjere ,['class' => 'form-control read_stuffs', 'disabled' => 'true']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('broj_obavijestenja_provjere', __('Broj obavještenja').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!! Form::text('broj_obavijestenja_provjere', $strucna_sprema_s->broj_obavijestenja_provjere, ['class' => 'form-control read_stuffs', 'rows' => 1,  'maxlength' => '150', 'id' => 'broj_obavijestenja_provjere', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
{{--                        <div class="single_row">--}}
{{--                            {!! Form::label('datum_povratka_sa_provjere', __('Datum zaprimanja diplome nazad').' : ', ['class' => ' control-label'] )  !!}--}}
{{--                            <div class="col-lg-12">--}}
{{--                                {!! Form::text('datum_povratka_sa_provjere', \App\Http\Controllers\HelpController::obrniDatum($strucna_sprema_s->datum_povratka_sa_provjere) , ['class' => 'form-control read_stuffs datepicker',  'id' => 'datum_povratka_sa_provjere'.$index_counter++, 'autocomplete' => 'off', 'readonly']) !!}--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>

                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('datum_povratka_sa_provjere', __('Datum dostavljanja diplome u toku radnog odnosa').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!! Form::text('datum_dostavljanja_diplome', $strucna_sprema_s->datum_dostavljanja_diplome ? \App\Http\Controllers\HelpController::obrniDatum($strucna_sprema_s->datum_dostavljanja_diplome) : '' , ['class' => 'form-control read_stuffs datepicker',  'id' => 'datum_dostavljaanja_diplome'.$index_counter++, 'autocomplete' => 'off', 'readonly']) !!}
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
        {!! Form::hidden('tabela', 'sluzbenik_strucna_sprema', ['class' => 'form-control']) !!}
        @csrf <!-- {{ csrf_field() }} -->
            <div class="add_new_elements">
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('stepen_s_s', __('Stepen stručne spreme').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('stepen_s_s', $value = null, ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'stepen_s_s', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('vrsta_s_s', __('Vrsta stručne spreme').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('vrsta_s_s', $value = null, ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'vrsta_s_s', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('komenta_o_diplomi', __('Komentar o diplomi').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('komenta_o_diplomi', $value = null, ['class' => 'form-control', 'maxlength' => '100', 'rows' => 1, 'id' => 'komenta_o_diplomi', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('datum_zavrsetka', __('Datum završetka').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('datum_zavrsetka', '' , ['class' => 'form-control datepicker', 'id' => 'datum_zavrsetka', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('obrazovna_institucija', __('Obrazovna institucija').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!!  Form::select('obrazovna_institucija', $obrazovnaInstitucija, $strucna_sprema_s->obrazovna_institucija ,['class' => 'form-control read_stuffs', 'disabled' => 'true']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('nostrifikacija', __('Broj nostrifikacije').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('nostrifikacija', $value = null, ['class' => 'form-control', 'maxlength' => '150', 'rows' => 1, 'id' => 'nostrifikacija', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('diploma_poslana_na_provjeru', __('Diploma poslana na provjeru').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::select('diploma_poslana_na_provjeru', ['0' => 'NE', '1' => 'DA'], '0' ,['class' => 'form-control', 'id' => 'diploma_poslana_na_provjeru']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('diploma_vracena_sa_provjere', __('Diploma vraćena sa provjere').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::select('diploma_vracena_sa_provjere', ['0' => 'NE', '1' => 'DA'], '0' ,['class' => 'form-control', 'id' => 'diploma_poslana_na_provjeru']) !!}
                        </div>
                    </div>
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('broj_obavijestenja_provjere', __('Broj obavještenja').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!! Form::text('broj_obavijestenja_provjere', $value = null, ['class' => 'form-control', 'maxlength' => '150', 'rows' => 1, 'id' => 'broj_obavijestenja_provjere', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
{{--                    <div class="single_row">--}}
{{--                        {!! Form::label('datum_povratka_sa_provjere', __('Datum zaprimanja diplome nazad').' : ', ['class' => ' control-label'] )  !!}--}}
{{--                        <div class="col-lg-12">--}}
{{--                            {!! Form::text('datum_povratka_sa_provjere', $value = null, ['class' => 'form-control datepicker', 'maxlength' => '150', 'rows' => 1, 'id' => 'datum_povratka_sa_provjere', 'autocomplete' => 'off']) !!}--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('broj_obavijestenja_provjere', __('Datum dostavljanja diplome u toku radnog odnosa').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!! Form::text('datum_dostavljanja_diplome', '', ['class' => 'form-control datepicker', 'maxlength' => '150', 'rows' => 1, 'id' => 'skkskssk', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>

                <div class="single_row">
                    <div class="col-lg-12">
                        {!! Form::submit(__('Spasite podatke o stručnoj spremi'), ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
