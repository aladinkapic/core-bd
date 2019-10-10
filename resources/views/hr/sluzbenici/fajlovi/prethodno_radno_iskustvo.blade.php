<div class="drop_down_option">
    <div class="single_row header header2">
        <p>Radni staž kod prethodnih poslodavaca</p>
        <i class="fas arrow-icon fa-chevron-down" onclick="prikazi_elemente(7);"></i>
        @if(!isset($pregled))
            <i class="fas fa-plus" title="Dodajte nove podatke o mjestu prebivališta" onclick="prikazi_elemente(7, 'hidden_input_form');"></i>
        @endif
    </div>

    <div class="predefined_elements">

    @php $elements_counter = 0; $index_counter = 0; @endphp <!-- counter za jedinstven ID svakog elementa -->

        @foreach($prethodno_r_iskustvo as $prethod_r_i_s)
            @php  $prethod_r_i_s->radniStazGodina(); @endphp
            <div class="preview_elements input_element{{$elements_counter}}">
                @if(!isset($pregled))
                    <div class="edit_elements_icons">
                        <div class="edit_element_icon" title="Uredite" onclick="edit_property(7, '{{$elements_counter}}');">
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
                            {!! Form::hidden('id', $prethod_r_i_s->id, []) !!}
                            {!! Form::hidden('tabela', 'sluzbenik_prethodno_radno_iskustvo', []) !!}
                            <input type="submit" id="input_form_ispit{{ $elements_counter++ }}" class="hidden">

                        </form>
                    </div>
                @endif


                <form action="/hr/sluzbenici/izmijeni_sadrzaj/" method="post">
                {!! Form::hidden('id_sluzbenika', $id_sluzbenika, ['class' => 'form-control']) !!}
                {!! Form::hidden('id', $prethod_r_i_s->id, []) !!}
                {!! Form::hidden('tabela', 'sluzbenik_prethodno_radno_iskustvo', ['class' => 'form-control']) !!}
                @csrf <!-- {{ csrf_field() }} -->
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('poslodavac', __('Poslodavac').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('poslodavac', $prethod_r_i_s->poslodavac, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'poslodavac', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('sjediste_poslodavca', __('Sjedište poslodavca').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('sjediste_poslodavca', $prethod_r_i_s->sjediste_poslodavca, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'sjediste_poslodavca', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('period_zaposlenja_od', __('Datum početka').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('period_zaposlenja_od', \App\Http\Controllers\HelpController::obrniDatum($prethod_r_i_s->period_zaposlenja_od), ['class' => 'form-control read_stuffs datepicker', 'maxlength' => '50', 'rows' => 1, 'id' => 'period_zaposlenja_od'.$index_counter++, 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>

                        <div class="single_row">
                            {!! Form::label('period_zaposlenja_do', __('Datum završetka').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('period_zaposlenja_do', \App\Http\Controllers\HelpController::obrniDatum($prethod_r_i_s->period_zaposlenja_do), ['class' => 'form-control read_stuffs datepicker', 'maxlength' => '50', 'rows' => 1, 'id' => 'period_zaposlenja_do'.$index_counter++, 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('radno_vrijeme', __('Radno vrijeme').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!!  Form::select('radno_vrijeme', $radno_vrijeme, $prethod_r_i_s->radno_vrijeme ,['class' => 'form-control read_stuffs', 'disabled' => 'true']) !!}
                        </div>
                    </div>
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('opis_poslova', __('Opis poslova').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('opis_poslova', $prethod_r_i_s->opis_poslova, ['class' => 'form-control read_stuffs', 'maxlength' => '9000', 'rows' => 1, 'id' => 'opis_poslova', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('steceno_radno_iskustvo', __('Stečeno radno iskustvo').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('steceno_radno_iskustvo', $prethod_r_i_s->steceno_radno_iskustvo ,['class' => 'form-control read_stuffs', 'maxlength' => '50', 'id' => 'steceno_radno_iskustvo', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('ostvareni_radni_staz', __('Ostvareni radni staž').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('ostvareni_radni_staz', $prethod_r_i_s->ostvareni_radni_staz, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'ostvareni_radni_staz', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('staz_osiguranja', __('Staž osiguranja').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('staz_osiguranja', $prethod_r_i_s->staz_osiguranja ,['class' => 'form-control read_stuffs', 'maxlength' => '50', 'id' => 'staz_osiguranja', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('dobrovoljno_osiguranje', __('Dobrovoljno osiguranje').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('dobrovoljno_osiguranje', $prethod_r_i_s->dobrovoljno_osiguranje, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'dobrovoljno_osiguranje', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('penzioni_staz', __('Penzioni staž').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('penzioni_staz', $prethod_r_i_s->penzioni_staz ,['class' => 'form-control read_stuffs', 'maxlength' => '50', 'id' => 'penzioni_staz', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('staz_sa_uvecanim_trajanjem', __('Staž sa uvećanim trajanjem').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('staz_sa_uvecanim_trajanjem', $prethod_r_i_s->staz_sa_uvecanim_trajanjem, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'staz_sa_uvecanim_trajanjem', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('drzava_sa_stazom', __('Država gdje je ostvaren staž u drugoj državi').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('drzava_sa_stazom', $prethod_r_i_s->drzava_sa_stazom ,['class' => 'form-control read_stuffs', 'maxlength' => '50', 'id' => 'drzava_sa_stazom', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('trajanje_staza_u_drzavi', __('Trajanje staža u državi').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('trajanje_staza_u_drzavi', $prethod_r_i_s->trajanje_staza_u_drzavi, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'trajanje_staza_u_drzavi', 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('napomena', __('Napomena').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('napomena', $prethod_r_i_s->napomena ,['class' => 'form-control read_stuffs', 'id' => 'napomena', 'maxlength' => '500', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('radni_staz_godina', __('Radni staž - godina').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!!  Form::text('radni_staz_godina', $prethod_r_i_s->radni_staz_godina ,['class' => 'form-control read_stuffs', 'id' => 'napomena', 'maxlength' => '500', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('radni_staz_mjeseci', __('Radni staž - mjeseci').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('radni_staz_mjeseci', $prethod_r_i_s->radni_staz_mjeseci ,['class' => 'form-control read_stuffs', 'id' => 'napomena', 'maxlength' => '500', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('radni_staz_dana', __('Radni staž - dana').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('radni_staz_dana', $prethod_r_i_s->radni_staz_dana ,['class' => 'form-control read_stuffs', 'id' => 'napomena', 'maxlength' => '500', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('koeficijent', __('Koeficijent').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::number('koeficijent', $prethod_r_i_s->koeficijent ,['class' => 'form-control read_stuffs', 'id' => 'koeficijent', 'maxlength' => '500', 'min' => '0', 'max' => '100', 'readonly', 'autocomplete' => 'off', 'number']) !!}
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
        {!! Form::hidden('tabela', 'sluzbenik_prethodno_radno_iskustvo', ['class' => 'form-control']) !!}
        @csrf <!-- {{ csrf_field() }} -->
            <div class="add_new_elements">
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('poslodavac', __('Poslodavac').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('poslodavac', '', ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'poslodavac', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('sjediste_poslodavca', __('Sjedište poslodavca').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('sjediste_poslodavca', '', ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'sjediste_poslodavca', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('period_zaposlenja_od', __('Datum početka').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('period_zaposlenja_od', '', ['class' => 'form-control datepicker', 'maxlength' => '50', 'rows' => 1, 'id' => 'period_zaposlenja_od', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('period_zaposlenja_do', __('Datum završetka').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('period_zaposlenja_do', '', ['class' => 'form-control datepicker', 'maxlength' => '50', 'rows' => 1, 'id' => 'period_zaposlenja_do', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>
                <div class="single_row">
                    {!! Form::label('radno_vrijeme', __('Radno vrijeme').' : ', ['class' => ' control-label'] )  !!}
                    <div class="col-lg-12">
                        {!!  Form::select('radno_vrijeme', $radno_vrijeme, '0' ,['class' => 'form-control', 'id' => 'radno_vrijeme']) !!}
                    </div>
                </div>
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('opis_poslova', __('Opis poslova').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('opis_poslova', '', ['class' => 'form-control', 'maxlength' => '9000', 'rows' => 1, 'id' => 'opis_poslova', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('steceno_radno_iskustvo', __('Stečeno radno iskustvo').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::text('steceno_radno_iskustvo', '' ,['class' => 'form-control',  'maxlength' => '50', 'id' => 'steceno_radno_iskustvo', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('ostvareni_radni_staz', __('Ostvareni radni staž').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('ostvareni_radni_staz', '', ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'ostvareni_radni_staz', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('staz_osiguranja', __('Staž osiguranja ').': ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::text('staz_osiguranja', '' ,['class' => 'form-control', 'maxlength' => '50', 'id' => 'staz_osiguranja', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('dobrovoljno_osiguranje', __('Dobrovoljno osiguranje').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('dobrovoljno_osiguranje', '', ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'dobrovoljno_osiguranje', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('penzioni_staz', __('Penzioni staž').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::text('penzioni_staz', '' ,['class' => 'form-control', 'maxlength' => '50', 'id' => 'penzioni_staz', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('staz_sa_uvecanim_trajanjem', __('Staž sa uvećanim trajanjem').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('staz_sa_uvecanim_trajanjem', '', ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'staz_sa_uvecanim_trajanjem', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('drzava_sa_stazom', __('Država gdje je ostvaren staž u drugoj državi').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::text('drzava_sa_stazom', '' ,['class' => 'form-control', 'maxlength' => '50', 'id' => 'drzava_sa_stazom', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('trajanje_staza_u_drzavi', __('Trajanje staža u državi').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('trajanje_staza_u_drzavi', '', ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'trajanje_staza_u_drzavi', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('napomena', __('Napomena').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::text('napomena', '' ,['class' => 'form-control', 'maxlength' => '500', 'id' => 'napomena', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>

                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('koeficijent', __('Koeficijent').' : ', ['class' => ' control-label'] )  !!}
                        <div class="col-lg-12">
                            {!!  Form::number('koeficijent', '' ,['class' => 'form-control read_stuffs', 'id' => 'koeficijent', 'maxlength' => '500', 'min' => '0', 'max' => '100', 'autocomplete' => 'off', 'number']) !!}
                        </div>
                    </div>
                </div>

                <div class="single_row">
                    <div class="col-lg-12">
                        {!! Form::submit(__('Spasite podatke o prethodnom radnom iskustvu'), ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>