<section class="">
    <div class="container_block" >
        @if(isset($preview))
            @foreach($medijatori as $med)
                <div class="split_container split_container5">
                    <div class="copied_form" id="nekaamo">

                        @if(isset($med->sluzbenik->ime_prezime))
                            <div class="form-group row">
                                <div class="col">
                                    {!! Form::label('sluzbenik_id_med', __('Ime i prezime medijatora').' : ', ['class' => 'control-label']) !!}
                                    <div class="col-lg-12">
                                        {!!  Form::text('sluzbenik_id_med[]', $med->sluzbenik->ime_prezime ?? '' ,['class' => 'form-control', 'id' => 'sluzbenik_id_med_e', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col">
                                    {!! Form::label('oju_med', __('Organ javne uprave').' : ', ['class' => 'control-label']) !!}
                                    <div class="col-lg-12">
                                        {!!  Form::select('oju_med[]', $organi, $med->oju_med ,['class' => 'form-control', 'id' => 'oju_med', 'disabled' => true]) !!}
                                    </div>
                                </div>
                            </div>
                        @elseif(isset($med->sluzbenik_id_med_e))
                            <div class="form-group row">
                                <div class="col">
                                    {!! Form::label('sluzbenik_id_med_e[]', __('Ime i prezime medijatora').' : ', ['class' => 'control-label']) !!}
                                    <div class="col-lg-12">
                                        {!!  Form::text('sluzbenik_id_med_e[]', $med->sluzbenik_id_med_e ,['class' => 'form-control', 'id' => 'sluzbenik_id_med_e', 'readonly']) !!}
                                    </div>
                                </div>

                                <div class="col">
                                    {!! Form::label('oju_med_e', __('Institucija').'  : ', ['class' => 'control-label']) !!}
                                    <div class="col-lg-12">
                                        {!!  Form::text('oju_med_e[]', $med->oju_med_e ,['class' => 'form-control', 'id' => 'oju_med_e', 'readonly']) !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="split_container">
                <div class="copied_form" id="nekaamo">

                    {!! Form::hidden('medijatori_id[]', 'empty', ['class' => 'form-control']) !!}

                    <div class="form-group row">
                        <div class="col">
                            {!! Form::label('sluzbenik_id_med', __('Ime i prezime službenika').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::select('sluzbenik_id_med[]', $nizsluzbenika, '0', ['class' => 'js-example-basic-single form-control', 'style' => 'width:100%;']) !!}
                            </div>
                        </div>
                        <div class="col">
                            {!! Form::label('sluzbenik_id_med_e[]', __('Ime i prezime službenika').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!!  Form::text('sluzbenik_id_med_e[]', '' ,['class' => 'form-control', 'id' => 'sluzbenik_id_med_e']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            {!! Form::label('oju_med', __('Organ javne uprave').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!!  Form::select('oju_med[]', $organi, '' ,['class' => 'form-control', 'id' => 'oju_med']) !!}
                            </div>
                        </div>

                        <div class="col">
                            {!! Form::label('oju_med_e', __('Institucija').' : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!!  Form::text('oju_med_e[]', '' ,['class' => 'form-control', 'id' => 'oju_med_e']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="text-align:right; padding-right:16px; margin-top:30px;">
                    <button type="button" class="btn btn-dark" id="custom_button" onclick="createNewDomElements('korisnici', 'nekaamo');">
                        {{__('Dodajte medijatora')}}
                        <i class="fas fa-save"></i>
                    </button>
                </div>
            </div>
            <div class="split_container" style="padding:0px;">
                <div id="korisnici">
                    @php $i = 0; @endphp
                    @foreach($medijatori as $med)
                        <div class="">
                            <div class="copied_form sluzbenici*{{$med->id}}" id="korisnici" style="padding-top:20px;">

                                {!! Form::hidden('medijatori_id[]', $med->id, ['class' => 'form-control']) !!}

                                <div class="shadow_delete">
                                    <div class="delete_item" onclick="obrisiDomElement('korisnici', '{{$i}}'); obrisiIzBaze('{{$med->id}}', 'medijatori'); ">
                                        <i class="fas fa-times"></i>
                                    </div>

                                    <div class="delete_item edit_item" onclick="urediDomElement('korisnici', '{{$i++}}');">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col">
                                        {!! Form::label('sluzbenik_id_med', __('Ime i prezime medijatora').' : ', ['class' => 'control-label']) !!}
                                        <div class="col-lg-12">
                                            {!! Form::select('sluzbenik_id_med[]', $nizsluzbenika, $med->sluzbenik->id ?? '0', ['class' => 'js-example-basic-single form-control', 'style' => 'width:100%;']) !!}
                                        </div>

{{--                                        <div class="col-lg-12">--}}
{{--                                            {!!  Form::text('sluzbenik_id_med_e[]', $med->sluzbenik->ime_prezime ?? '' ,['class' => 'form-control', 'id' => 'sluzbenik_id_med_e', 'readonly']) !!}--}}
{{--                                        </div>--}}
                                    </div>
                                    <div class="col">
                                        {!! Form::label('sluzbenik_id_med_e[]', __('Ime i prezime medijatora').' : ', ['class' => 'control-label']) !!}
                                        <div class="col-lg-12">
                                            {!!  Form::text('sluzbenik_id_med_e[]', $med->sluzbenik_id_med_e ,['class' => 'form-control', 'id' => 'sluzbenik_id_med_e', '']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        {!! Form::label('oju_med', __('Organ javne uprave').' : ', ['class' => 'control-label']) !!}
                                        <div class="col-lg-12">
                                            {!!  Form::select('oju_med[]', $organi, $med->oju_med ,['class' => 'form-control', 'id' => 'oju_med']) !!}
                                        </div>
                                    </div>

                                    <div class="col">
                                        {!! Form::label('oju_med_e', __('Institucija').'  : ', ['class' => 'control-label']) !!}
                                        <div class="col-lg-12">
                                            {!!  Form::text('oju_med_e[]', $med->oju_med_e ,['class' => 'form-control', 'id' => 'oju_med_e', '']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
