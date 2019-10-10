<section class="active">
    <div class="container_block" >
        @if(isset($preview))
            @foreach($komisije as $clan_kom)
                <div class="split_container split_container5">
                    <div class="copied_form" id="form_for_copy">
                        {{--<div class="form-group row">--}}
                            {{--<div class="col">--}}
                                {{--{!! Form::label('discp_odg_____', 'Opis povrede : ', ['class' => 'control-label']) !!}--}}
                                {{--<div class="col-lg-12">--}}
                                    {{--{!! Form::text('discp_odg_____[]', $disciplinska->opis_povrede, ['class' => 'form-control readmeebaby', 'rows' => 1, 'id' => 'disc_odg__', 'readonly']) !!}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('sluzbenik_id_kom', 'Ime i prezime člana komisije : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!!  Form::text('sluzbenik_id_kom[]', $clan_kom->sluzbenik->ime.' '.$clan_kom->sluzbenik->prezime ,['class' => 'form-control', 'id' => 'sluzbenik_id_kom', 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('sluzbenik_id_kom_e[]', 'Ime i prezime člana komisije : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!!  Form::text('sluzbenik_id_kom_e[]', $clan_kom->sluzbenik_id_kom_e ,['class' => 'form-control', 'id' => 'sluzbenik_id_kom_e', 'readonly']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('oju_kom', 'Organ Javne uprave : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!!  Form::select('oju_kom[]', $organi, $clan_kom->oju_kom ,['class' => 'form-control', 'id' => 'oju_kom', 'disabled' => true]) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('oju_kom_e', 'Institucija : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!!  Form::text('oju_kom_e[]', $clan_kom->oju_kom_e ,['class' => 'form-control', 'id' => 'oju_kom_e', 'readonly']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="split_container">
                <div class="copied_form" id="form_for_copy">

                    {!! Form::hidden('komisija_id[]', 'empty', ['class' => 'form-control']) !!}

                    <div class="form-group row">
                        <div class="col">
                            {!! Form::label('sluzbenik_id_kom', 'Ime i prezime službenika : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!! Form::select('sluzbenik_id_kom[]', $nizsluzbenika, '0', ['class' => 'js-example-basic-single form-control']) !!}
                            </div>
                        </div>
                        <div class="col">
                            {!! Form::label('sluzbenik_id_kom_e[]', 'Ime i prezime službenika : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!!  Form::text('sluzbenik_id_kom_e[]', '' ,['class' => 'form-control', 'id' => 'sluzbenik_id_kom_e']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            {!! Form::label('oju_kom', 'Organ Javne uprave : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!!  Form::select('oju_kom[]', $organi, '' ,['class' => 'form-control', 'id' => 'oju_kom']) !!}
                            </div>
                        </div>
                        <div class="col">
                            {!! Form::label('oju_kom_e', 'Institucija : ', ['class' => 'control-label']) !!}
                            <div class="col-lg-12">
                                {!!  Form::text('oju_kom_e[]', '' ,['class' => 'form-control', 'id' => 'oju_kom_e']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="text-align:right; padding-right:16px; margin-top:30px;">
                    <button type="button" class="btn btn-dark" id="custom_button" onclick="createNewDomElements('uslovi_za_radno_mjesto', 'form_for_copy');">
                        {{__('Dodajte člana komisije')}}
                        <i style="margin-left:15px;" class="fas fa-save"></i>
                    </button>
                </div>
            </div>



            <div class="split_container" style="padding:0px;">
                <div id="uslovi_za_radno_mjesto">
                    @php $i = 0; @endphp
                    @foreach($komisije as $clan_kom)
                        <div class="">
                            <div class="copied_form radno_mjesto_uslovi*{{$clan_kom->id}}"  id="form_for_copy" style="padding-top:20px;">

                                {!! Form::hidden('komisija_id[]', $clan_kom->id, ['class' => 'form-control']) !!}

                                <div class="shadow_delete">
                                    <div class="delete_item" onclick="obrisiDomElement('uslovi_za_radno_mjesto', '{{$i}}'); obrisiIzBaze('{{$clan_kom->id}}', 'disciplinska_komisija'); ">
                                        <i class="fas fa-times"></i>
                                    </div>

                                    <div class="delete_item edit_item" onclick="urediDomElement('uslovi_za_radno_mjesto', '{{$i++}}');">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col">
                                        {!! Form::label('sluzbenik_id_kom', 'Ime i prezime člana komisije : ', ['class' => 'control-label']) !!}
                                        <div class="col-lg-12">
                                            {!! Form::select('sluzbenik_id_kom[]', $nizsluzbenika, $clan_kom->sluzbenik->id, ['class' => 'js-example-basic-single form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col">
                                        {!! Form::label('sluzbenik_id_kom_e[]', 'Ime i prezime člana komisije : ', ['class' => 'control-label']) !!}
                                        <div class="col-lg-12">
                                            {!!  Form::text('sluzbenik_id_kom_e[]', $clan_kom->sluzbenik_id_kom_e ,['class' => 'form-control', 'id' => 'sluzbenik_id_kom_e']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        {!! Form::label('oju_kom', 'Organ Javne uprave : ', ['class' => 'control-label']) !!}
                                        <div class="col-lg-12">
                                            {!!  Form::select('oju_kom[]', $organi, $clan_kom->oju_kom ,['class' => 'form-control', 'id' => 'oju_kom']) !!}
                                        </div>
                                    </div>
                                    <div class="col">
                                        {!! Form::label('oju_kom_e', 'Institucija : ', ['class' => 'control-label']) !!}
                                        <div class="col-lg-12">
                                            {!!  Form::text('oju_kom_e[]', $clan_kom->oju_kom_e ,['class' => 'form-control', 'id' => 'oju_kom_e']) !!}
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