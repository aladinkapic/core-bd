<div class="drop_down_option">
    <div class="single_row header header2">
        <p>Kontakt informacije</p>
        <i class="fas arrow-icon fa-chevron-down" onclick="prikazi_elemente(3);"></i>
        @if(!isset($pregled))
            <i class="fas fa-plus" title="Dodajte nove podatke o mjestu prebivališta" onclick="prikazi_elemente(3, 'hidden_input_form');"></i>
        @endif
    </div>

    <div class="predefined_elements">

    @php $elements_counter = 0; $index_counter = 0; @endphp <!-- counter za jedinstven ID svakog elementa -->

        @foreach($kontakt_detalji as $kontakt_detalj)
            <div class="preview_elements input_element{{$elements_counter}}">
                @if(!isset($pregled))
                    <div class="edit_elements_icons">
                        <div class="edit_element_icon" title="Uredite" onclick="edit_property(3, '{{$elements_counter}}');">
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
                            {!! Form::hidden('id', $kontakt_detalj->id, []) !!}
                            {!! Form::hidden('tabela', 'sluzbenik_kontakt_detalji_osobe', []) !!}
                            <input type="submit" id="input_form_ispit{{ $elements_counter}}" class="hidden">

                        </form>
                    </div>
                @endif


                <form action="/hr/sluzbenici/izmijeni_sadrzaj/" method="post">
                {!! Form::hidden('id_sluzbenika', $id_sluzbenika, ['class' => 'form-control']) !!}
                {!! Form::hidden('id', $kontakt_detalj->id, []) !!}
                {!! Form::hidden('tabela', 'sluzbenik_kontakt_detalji_osobe', ['class' => 'form-control']) !!}
                @csrf <!-- {{ csrf_field() }} -->
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('sluzbeni_tel'.$elements_counter, __('Službeni telefon').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('sluzbeni_tel', $kontakt_detalj->sluzbeni_tel, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'sluzbeni_tel'.$elements_counter, 'autocomplete' => 'off', 'placeholder' => '', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('sluzbeni_mail'.$elements_counter, __('Službeni email').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('sluzbeni_mail', $kontakt_detalj->sluzbeni_mail, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'sluzbeni_mail'.$elements_counter, 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('mobilni_tel'.$elements_counter, __('Privatni telefon').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('mobilni_tel', $kontakt_detalj->mobilni_tel, ['class' => 'form-control read_stuffs', 'maxlength' => '50', 'rows' => 1, 'id' => 'mobilni_tel'.$elements_counter, 'autocomplete' => 'off', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('email'.$elements_counter, __('Privatni email').' : ', ['class' => ' control-label'] )  !!}
                            <div class="col-lg-12">
                                {!!  Form::text('email', $kontakt_detalj->email,['class' => 'form-control read_stuffs', 'maxlength' => '50', 'id' => 'email'.$elements_counter, 'readonly', 'autocomplete' => 'off']) !!}
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
            @php $elements_counter++; @endphp
        @endforeach
    </div>

    <div class="hidden_input_form">
        <form action="/hr/sluzbenici/spremi_sadrzaj/" method="post">
        {!! Form::hidden('id_sluzbenika', $id_sluzbenika, ['class' => 'form-control']) !!}
        {!! Form::hidden('tabela', 'sluzbenik_kontakt_detalji_osobe', ['class' => 'form-control']) !!}
        @csrf <!-- {{ csrf_field() }} -->
            <div class="add_new_elements">
                <div class="double_row">
                    <div class="single_row">
                    {!! Form::label('sluzbeni_tel', __('Službeni telefon').' : ', ['class' => 'control-label']) !!}
                    <div class="col-lg-12">
                        {!! Form::text('sluzbeni_tel', $value = null, ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'sluzbeni_tel', 'autocomplete' => 'off', 'placeholder' => '']) !!}
                    </div>
                </div>
                <div class="single_row">
                    {!! Form::label('sluzbeni_mail', __('Službeni email').' : ', ['class' => 'control-label']) !!}
                    <div class="col-lg-12">
                        {!! Form::text('sluzbeni_mail', $value = null, ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'sluzbeni_mail', 'autocomplete' => 'off', 'onkeyup' => 'verifikuj_string("sluzbeni_mail", "Uneseni podaci nemaju formu maila. Jeste li zaboravili -@- ?", "email")']) !!}
                    </div>
                </div>
            </div>

            <div class="notificaiton_area" id="sluzbeni_mail_not"> <p id="sluzbeni_mail_not_v"></p> </div>

            <div class="double_row">
                <div class="single_row">
                    {!! Form::label('mobilni_tel', __('Privatni telefon').' : ', ['class' => 'control-label']) !!}
                    <div class="col-lg-12">
                        {!! Form::text('mobilni_tel', $value = null, ['class' => 'form-control', 'maxlength' => '50', 'rows' => 1, 'id' => 'mobilni_tel', 'autocomplete' => 'off']) !!}
                    </div>
                </div>
                <div class="single_row">
                    {!! Form::label('email', __('Privatni email').' : ', ['class' => ' control-label'] )  !!}
                    <div class="col-lg-12">
                        {!!  Form::text('email', '' ,['class' => 'form-control', 'id' => 'email', 'maxlength' => '50', 'autocomplete' => 'off', 'onkeyup' => 'verifikuj_string("email", "Uneseni podaci nemaju formu maila. Jeste li zaboravili -@- ?", "email")']) !!}
                    </div>
                </div>
            </div>

            <div class="notificaiton_area" id="email_not"> <p id="email_not_v"></p> </div>


            <div class="single_row">
                <div class="col-lg-12">
                    {!! Form::submit(__('Spasite podatke o kontakt detaljima'), ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
            </div>
        </form>
    </div>
</div>