<div class="drop_down_option">
    <div class="single_row header">
        <p>{{__('Žalba')}}</p>
        <i class="fas arrow-icon fa-chevron-down" onclick="prikazi_elemente(0);"></i>
        @if(!isset($pregled))
            <i class="fas fa-plus" title="Dodajte nove podatke o žalbi" onclick="prikazi_elemente(0, 'hidden_input_form');"></i>
        @endif
    </div>

    <div class="predefined_elements">

    @php $elements_counter = 0; $index_counter = 0; @endphp <!-- counter za jedinstven ID svakog elementa -->

        @foreach($zalbe as $zalba)
            <div class="preview_elements zalbe input_element{{$elements_counter}}">
                @if(!isset($pregled))
                    <div class="edit_elements_icons">
                        <div class="edit_element_icon" title="Uredite" onclick="edit_property(0, '{{$elements_counter}}');">
                            <i class="fas edit_icoon fa-edit"></i>
                        </div>
                        <form action="/hr/disciplinska_odgovornost/obrisi_sadrzaj/" method="post">
                        @csrf <!-- {{ csrf_field() }} -->

                            <label for="input_form_zalba{{$elements_counter}}">
                                <div class="edit_element_icon edit_element_icon_2" title="Obrišite">
                                    <i class="fa fa-trash"></i>
                                </div>
                            </label>

                            {!! Form::hidden('disciplinska_odgovornost_id', $disciplinska_odgovornost_id, []) !!}
                            {!! Form::hidden('id', $podatak_o_zalbi->id, []) !!}
                            {!! Form::hidden('tabela', 'disciplinska_odgovornost_podaci_o_zalbama', []) !!}
                            <input type="submit" id="input_form_zalba{{ $elements_counter++ }}" class="hidden">

                        </form>
                    </div>
                @endif


                <form action="/hr/disciplinska_odgovornost/izmijeni_sadrzaj/" method="post">
                {!! Form::hidden('disciplinska_odgovornost_id', $disciplinska_odgovornost_id, ['class' => 'form-control']) !!}
                {!! Form::hidden('id', $podatak_o_zalbama->id, []) !!}
                {!! Form::hidden('tabela', 'disciplinska_odgovornost_podaci_o_zalbama', ['class' => 'form-control']) !!}
                @csrf <!-- {{ csrf_field() }} -->
                    <div class="double_row">
                        <div class="single_row">
                            {!! Form::label('broj_ulozene_zalbe', __('Broj uložene žalbe').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('broj_ulozene_zalbe', $podatak_o_zalbama->broj_ulozene_zalbe, ['class' => 'form-control read_stuffs', 'maxlength' => '100', 'rows' => 1, 'id' => 'broj_ulozene_zalbe', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('datum_ulozene_zalbe', __('Datum uložene žalbe').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('datum_ulozene_zalbe', $podatak_o_zalbama->datum_ulozene_zalbe, ['class' => 'form-control date_picker read_stuffs', 'maxlength' => '100', 'rows' => 1, 'id' => 'datum_ulozene_zalbe', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('broj_odluke_zalbe', __('Broj odluke žalbe').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('broj_odluke_zalbe', $podatak_o_zalbama->broj_odluke_zalbe, ['class' => 'form-control read_stuffs', 'maxlength' => '100', 'rows' => 1, 'id' => 'broj_odluke_zalbe', 'readonly', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                        <div class="single_row">
                            {!! Form::label('datum_odluke_zalbe', __('Datum odluke žalbe').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::text('datum_odluke_zalbe', $podatak_o_zalbama->datum_odluke_zalbe, ['class' => 'form-control date_picker read_stuffs', 'maxlength' => '100', 'rows' => 1, 'id' => 'datum_odluke_zalbe', 'readonly', 'autocomplete' => 'off']) !!}
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
        <form action="/hr/disciplinska_odgovornost/spremi_sadrzaj/" method="post">
        {!! Form::hidden('disciplinska_odgovornost_id', $disciplinska_odgovornost_id, ['class' => 'form-control']) !!}
        {!! Form::hidden('tabela', 'disciplinska_odgovornost_podaci_o_zalbama', ['class' => 'form-control']) !!}
        @csrf <!-- {{ csrf_field() }} -->
            <div class="add_new_elements">
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('broj_ulozene_zalbe', __('broj_ulozene_zalbe').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('broj_ulozene_zalbe', $value = null, ['class' => 'form-control', 'maxlength' => '100', 'rows' => 1, 'id' => 'broj_ulozene_zalbe_in', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('datum_ulozene_zalbe', __('Datum uložene žalbe').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('broj_ulozene_zalbe', $value = null, ['class' => 'form-control date_picker', 'maxlength' => '100', 'rows' => 1, 'id' => 'datum_ulozene_zalbe', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('broj_odluke_zalbe', __('broj_odluke_zalbe').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('broj_odluke_zalbe', $value = null, ['class' => 'form-control', 'maxlength' => '100', 'rows' => 1, 'id' => 'broj_odluke_zalbe_in', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="single_row">
                        {!! Form::label('datum_odluke_zalbe', __('Datum odluke žalbe').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('broj_odluke_zalbe', $value = null, ['class' => 'form-control date_picker', 'maxlength' => '100', 'rows' => 1, 'id' => 'datum_odluke_zalbe', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>

                <div class="single_row">
                    <div class="col-lg-12">
                        {!! Form::submit(__('Spasite podatke o žalbi'), ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>