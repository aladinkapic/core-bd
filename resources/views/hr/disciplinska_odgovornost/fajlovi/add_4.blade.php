<section class="multi_step_form">
    <form id="msform" method="post" action="{{ (request()->is('hr/disciplinska_odgovornost/unos_zalbe')) ? Route('zalbe.spremi') : Route('zalba.azuriraj') }}">

        @csrf
        <div id="steps-window">
            <ul>
                <li class="active">
                    @if(isset($zalba))
                        <div class="tab_div">
                            <i class="fas fa-volume-up"></i>
                            <p>{{__('Pregled žalbe - ')}}{{$zalba->broj_ulozene_zalbe}}</p>
                        </div>

                    @else
                        <div class="list_div">
                            <div class="back_div"></div>
                            <div class="icon_circle">
                                <i class="fas fa-volume-up"></i>
                            </div>
                            <p>{{__('Kreirajte novu žalbu')}}</p>
                        </div>
                    @endif
                </li>
            </ul>

            <section class="active">
                <div class="container_block">
                    <div class="split_container">

                        @if(isset($zalba))
                            {!! Form::hidden('zalba_id', $zalba->id, ['class' => 'form-control']) !!}
                        @endif

                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('disciplinska_odgovornost_id', 'Disciplinska odgovornost : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::select('disciplinska_odgovornost_id', $disciplinska, isset($zalba) ? $zalba->disciplinska_odgovornost_id : '', ['class' => 'form-control', 'rows' => 1, 'autocomplete' => 'off', isset($preview) ? 'disabled' : '']) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('broj_ulozene_zalbe', 'Broj uložene žalbe : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('broj_ulozene_zalbe', isset($zalba) ? $zalba->broj_ulozene_zalbe : '', ['class' => 'form-control', 'autocomplete' => 'off', isset($preview) ? 'readonly' : '', 'rows' => 1, 'maxlength' => 50]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="notificaiton_area" id="opis_povrede_not"> <p id="opis_povrede_not_v"></p> </div>
                        <div class="form-group row steppsss">
                            <div class="col">
                                {!! Form::label('datum_ulozene_zalbe', 'Datum uložene žalbe : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('datum_ulozene_zalbe', isset($zalba) ? $zalba->datum_ulozene_zalbe : '', ['class' => 'form-control datepicker', 'id' => 'datum_ulozene_zalbe', 'autocomplete' => 'off', isset($preview) ? 'readonly' : '',]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="split_container">

                        <div class="form-group row steppsss">
                            <div class="col">
                                {!! Form::label('broj_odluke_zalbe', __('Broj odluke žalbe').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('broj_odluke_zalbe', isset($zalba) ? $zalba->broj_odluke_zalbe : '' , ['class' => 'form-control', 'id' => 'broj_odluke_zalbe', 'autocomplete' => 'off', isset($preview) ? 'readonly' : '', 'maxlength' => 50]) !!}
                                </div>
                            </div>

                            <div class="col">
                                {!! Form::label('datum_odluke_zalbe', 'Datum odluke žalbe : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('datum_odluke_zalbe', isset($zalba) ? $zalba->datum_odluke_zalbe : '', ['class' => 'form-control datepicker', 'id' => 'datum_odluke_zalbe', 'autocomplete' => 'off', isset($preview) ? 'readonly' : '',]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!isset($preview))
                        <div class="form-group row text-center" class="col-12" style=" width:100%; margin-left:0px; margin-top:25px;">
                            <div class="col-lg-12" >
                                {!! Form::submit(__(isset($zalba) ? 'Ažurirajte žalbu' : 'Završite sa unosom'), ['class' => 'btn btn-success', 'style' => 'margin-left:16px;']) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </div>

    </form>
</section>