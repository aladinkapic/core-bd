<div class="drop_down_option">
    <div class="single_row header header2">
        <p>{{__('Zasnivanje radnog odnosa')}}</p>
        <i class="fas arrow-icon fa-chevron-down" onclick="prikazi_elemente(7);"></i>
        @if(!isset($pregled))
            <i class="fas fa-plus" title="Dodajte nove podatke o mjestu prebivališta" onclick="prikazi_elemente(7, 'hidden_input_form');"></i>
        @endif
    </div>

    <div class="predefined_elements">

    @php $elements_counter = 0; $index_counter = 0; @endphp <!-- counter za jedinstven ID svakog elementa -->

        @foreach($zasnivanje_r_odnosa as $zas_r_o_s)
            <div class="preview_elements input_element{{$elements_counter}}">
                @if(!isset($pregled))
                    <div class="edit_elements_icons">
                        <div class="edit_element_icon" title="Uredite" onclick="edit_property(6, '{{$elements_counter}}');">
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
                            {!! Form::hidden('id', $zas_r_o_s->id, []) !!}
                            {!! Form::hidden('tabela', 'sluzbenik_zasnivanje_radnog_odnosa', []) !!}
                            <input type="submit" id="input_form_ispit{{ $elements_counter++ }}" class="hidden">

                        </form>
                    </div>
                @endif

                <form action="{{route('izmijenite_sadrzaj')}}" method="POST">
                {!! Form::hidden('id_sluzbenika', $id_sluzbenika, ['class' => 'form-control read_stuffs']) !!}
                {!! Form::hidden('id', $zas_r_o_s->id, []) !!}
                {!! Form::hidden('tabela', 'sluzbenik_zasnivanje_radnog_odnosa', ['class' => 'form-control read_stuffs']) !!}
                @csrf <!-- {{ csrf_field() }} -->
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('datum_zasnivanja_o',__('Datum zasnivanja radnog odnosa').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('datum_zasnivanja_o', \App\Http\Controllers\HelpController::obrniDatum($zas_r_o_s->datum_zasnivanja_o) , ['class' => 'form-control read_stuffs datepicker', 'id' => 'datum_zasnivanja_o'.$index_counter++, 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('nacin_zasnivanja_r_o', __('Način zasnivanja').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!!  Form::select('nacin_zasnivanja_r_o', $nacin_zasnivanja, $zas_r_o_s->nacin_zasnivanja_r_o ,['class' => 'form-control read_stuffs', 'disabled' => 'true']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('vrsta_r_o', __('Vrsta radnog odnosa').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!!  Form::select('vrsta_r_o', $vrsta_ro, $zas_r_o_s->vrsta_r_o ,['class' => 'form-control read_stuffs', 'disabled' => 'true']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('obracunati_r_staz', __('Obračunati staž').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!!  Form::select('obracunati_r_staz', $obracunati_staz, $zas_r_o_s->obracunati_r_staz ,['class' => 'form-control read_stuffs', 'disabled' => 'true']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('obracunati_r_s_god', __('Obračunati radni staž godina').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::number('obracunati_r_s_god', $zas_r_o_s->obracunati_r_s_god , ['class' => 'form-control read_stuffs', 'min' => 0, 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('obracunati_r_s_mje', __('Obračunati radni staž mjeseci').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::number('obracunati_r_s_mje', $zas_r_o_s->obracunati_r_s_mje , ['class' => 'form-control read_stuffs', 'min' => 0, 'max' => 12, 'readonly']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('obracunati_r_s_dan', __('Obračunati radni staž dana').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::number('obracunati_r_s_dan', $zas_r_o_s->obracunati_r_s_dan , ['class' => 'form-control read_stuffs', 'min' => 0, 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('napomena', __('Napomena').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('napomena', $zas_r_o_s->napomena ,['class' => 'form-control read_stuffs', 'maxlength' => '10000', 'id' => 'napomena', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('datum_zasnivanja_o',__('Datum donošenja sve potrebne dokumentacije').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('datum_donosenja_dokumentacije', $zas_r_o_s->datum_donosenja_dokumentacije ? \App\Http\Controllers\HelpController::obrniDatum($zas_r_o_s->datum_donosenja_dokumentacije): '', ['class' => 'form-control read_stuffs datepicker', 'id' => 'datum_donosenja_dokumentacije'.$index_counter++, 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('napomena', __('Minuli radni staž').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('minuli_radni_staz', $zas_r_o_s->minuli_radni_staz ,['class' => 'form-control read_stuffs', 'id' => 'staz', 'maxlength' => '100', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('radno_vrijeme',__('Radno vrijeme').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!!  Form::select('radno_vrijeme', $radno_vrijeme, $zas_r_o_s->radno_vrijeme ,['class' => 'form-control', 'id' => 'radno_vrijeme']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('opis_poslova', __('Opis poslova').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('opis_poslova', $zas_r_o_s->opis_poslova ,['class' => 'form-control read_stuffs', 'id' => 'opis_poslova', 'maxlength' => '100', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('steceno_radno_iskustvo',__('Stečeno radno iskustvo').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('steceno_radno_iskustvo', $zas_r_o_s->steceno_radno_iskustvo, ['class' => 'form-control read_stuffs', 'id' => 'steceno_radno_iskustvo', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('staz_osiguranja', __('Staž osiguranja').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('staz_osiguranja', $zas_r_o_s->staz_osiguranja ,['class' => 'form-control read_stuffs', 'id' => 'staz_osiguranja', 'maxlength' => '100', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('dobrovoljno_osiguranje',__('Dobrovoljno osiguranje').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('dobrovoljno_osiguranje', $zas_r_o_s->dobrovoljno_osiguranje, ['class' => 'form-control read_stuffs', 'id' => 'dobrovoljno_osiguranje', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('penzioni_staz', __('Penzioni staž').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('penzioni_staz', $zas_r_o_s->penzioni_staz ,['class' => 'form-control read_stuffs', 'id' => 'penzioni_staz', 'maxlength' => '100', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('koeficijent',__('Koeficijent').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('koeficijent', $zas_r_o_s->koeficijent, ['class' => 'form-control read_stuffs', 'id' => 'koeficijent', 'autocomplete' => 'off', 'readonly']) !!}
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
        {!! Form::hidden('tabela', 'sluzbenik_zasnivanje_radnog_odnosa', ['class' => 'form-control']) !!}
        @csrf <!-- {{ csrf_field() }} -->
            <div class="add_new_elements">
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('datum_zasnivanja_o',__('Datum zasnivanja radnog odnosa').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('datum_zasnivanja_o', '' , ['class' => 'form-control datepicker', 'id' => 'datum_zasnivanja_o', 'autocomplete' => 'off', '']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('nacin_zasnivanja_r_o', __('Način zasnivanja').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!!  Form::select('nacin_zasnivanja_r_o', $nacin_zasnivanja, 0 ,['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('vrsta_r_o', __('Vrsta radnog odnosa').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!!  Form::select('vrsta_r_o', $vrsta_ro, 0 ,['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('obracunati_r_staz', __('Obračunati staž').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!!  Form::select('obracunati_r_staz', $obracunati_staz, 0 ,['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('obracunati_r_s_god', __('Obračunati radni staž godina').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::number('obracunati_r_s_god', '' , ['class' => 'form-control', 'min' => 0]) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('obracunati_r_s_mje', __('Obračunati radni staž mjeseci').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::number('obracunati_r_s_mje', '' , ['class' => 'form-control', 'min' => 0, 'max' => 12]) !!}
                        </div>
                    </div>
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('obracunati_r_s_dan', __('Obračunati radni staž dana').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::number('obracunati_r_s_dan', '' , ['class' => 'form-control', 'min' => 0]) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('napomena', __('Napomena').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::text('napomena', '' ,['class' => 'form-control', 'id' => 'napomena', 'maxlength' => '10000', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('datum_zasnivanja_o',__('Datum donošenja sve potrebne dokumentacije').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('datum_donosenja_dokumentacije', '' , ['class' => 'form-control datepicker', 'id' => 'datum_donosenja_dokumentacije'.$index_counter++, 'autocomplete' => 'off', '']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('napomena', __('Minuli radni staž').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::text('minuli_radni_staz', '' ,['class' => 'form-control', 'id' => 'staz', 'maxlength' => '100', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('radno_vrijeme',__('Radno vrijeme').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!!  Form::select('radno_vrijeme', $radno_vrijeme, ''    ,['class' => 'form-control', 'id' => 'radno_vrijeme']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('opis_poslova', __('Opis poslova').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::text('opis_poslova', '' ,['class' => 'form-control read_stuffs', 'id' => 'opis_poslova', 'maxlength' => '100', 'autocomplete' => 'off', '']) !!}
                        </div>
                    </div>
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('steceno_radno_iskustvo',__('Stečeno radno iskustvo').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('steceno_radno_iskustvo', '', ['class' => 'form-control read_stuffs', 'id' => 'steceno_radno_iskustvo', 'autocomplete' => 'off', '']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('staz_osiguranja', __('Staž osiguranja').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::text('staz_osiguranja', '' ,['class' => 'form-control read_stuffs', 'id' => 'staz_osiguranja', 'maxlength' => '100', 'autocomplete' => 'off', '']) !!}
                        </div>
                    </div>
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('dobrovoljno_osiguranje',__('Dobrovoljno osiguranje').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('dobrovoljno_osiguranje', '', ['class' => 'form-control read_stuffs', 'id' => 'dobrovoljno_osiguranje', 'autocomplete' => 'off', '']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('penzioni_staz', __('Penzioni staž').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::text('penzioni_staz', '' ,['class' => 'form-control read_stuffs', 'id' => 'penzioni_staz', 'maxlength' => '100', 'autocomplete' => 'off', '']) !!}
                        </div>
                    </div>
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('koeficijent',__('Koeficijent').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('koeficijent', '', ['class' => 'form-control read_stuffs', 'id' => 'koeficijent', 'autocomplete' => 'off', '']) !!}
                        </div>
                    </div>
                </div>

                <div class="single_row">
                    <div class="col-lg-12">
                        {!! Form::submit(__('Spasite podatke o zasnivanju radnog odnosa '), ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
