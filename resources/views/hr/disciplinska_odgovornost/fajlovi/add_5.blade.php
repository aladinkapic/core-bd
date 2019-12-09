<section class="multi_step_form">

    <form id="msform" method="post" action="{{ (request()->is('hr/disciplinska_odgovornost/unos_suspenzija')) ? Route('suspenzije.spremi') : Route('suspenzije.azuriraj') }}">

        @csrf
        <div id="steps-window">
            <ul>
                <li class="active">
                    @if(isset($suspenzija))
                    <div class="tab_div">
                        <i class="fas fa-ban"></i>
                        <p>{{__('Pregled suspenzije - ')}}{{$suspenzija->broj_rjesenja}}</p>
                    </div>

                    @else
                    <div class="list_div">
                        <div class="back_div"></div>
                        <div class="icon_circle">
                            <i class="fas fa-ban"></i>
                        </div>
                        <p>{{__('Kreirajte novu suspenziju')}}</p>
                    </div>
                    @endif
                </li>
            </ul>

            <section class="active">
                <div class="container_block">
                    <div class="split_container">

                        @if(isset($suspenzija))
                        {!! Form::hidden('zalba_id', $suspenzija->id, ['class' => 'form-control']) !!}
                        @endif

                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('disciplinska_odgovornost_id', 'Disciplinska odgovornost : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::select('disciplinska_odgovornost_id', $disciplinska, isset($suspenzija) ? $suspenzija->disciplinska_odgovornost_id : '', ['class' => 'form-control', 'rows' => 1, 'autocomplete' => 'off', isset($preview) ? 'disabled' : '']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('broj_rjesenja', 'Broj rješenja : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('broj_rjesenja', isset($suspenzija) ? $suspenzija->broj_rjesenja : '', ['class' => 'form-control', 'autocomplete' => 'off', isset($preview) ? 'readonly' : '', 'rows' => 1, 'maxlength' => 50]) !!}
                                </div>
                            </div>

                            <div class="col steppsss">
                                {!! Form::label('datum_udaljenja', __('Datum udaljenja').' : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('datum_udaljenja', isset($suspenzija) ? $suspenzija->datum_udaljenja : '' , ['class' => 'form-control datepicker', 'id' => 'datum_udaljenja', 'autocomplete' => 'off', isset($preview) ? 'readonly' : '',]) !!}
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="split_container">
                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('razlog_udaljenja', 'Razlog udaljenja : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::textarea('razlog_udaljenja', isset($suspenzija) ? $suspenzija->razlog_udaljenja : '', ['class' => 'form-control', 'id' => 'razlog_udaljenja', 'autocomplete' => 'off', isset($preview) ? 'readonly' : '', 'rows' => 4, 'maxlength' => 50]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!isset($preview))
                        <div class="form-group row text-center" class="col-12" style=" width:100%; margin-left:0px; margin-top:25px;">
                            <div class="col-lg-12" >
                                {!! Form::submit(__(isset($suspenzija) ? 'Ažurirajte žalbu' : 'Završite sa unosom'), ['class' => 'btn btn-success', 'style' => 'margin-left:16px;']) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </div>

    </form>
</section>