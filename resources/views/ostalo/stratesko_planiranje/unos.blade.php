@extends('template.main')
@section('title') {{__('Planiranje kadrova')}} @endsection

@section('content')
    <div class="container">
        <div class="card-header ads-darker" style="height:60px;">
            <button onClick="window.location='{{ route('pregled.strateskogplaniranja') }}';" class="btn btn-light float-right" ><i class="fas fa-chevron-left"></i> {{__('Strateško planiranje')}}</button>
            <h4 style="padding-top:6px; margin-top:0px;">
                {{__('Strateško planiranje - planiranje kadrova')}}
            </h4>
        </div>

        @php
            if(isset($sp)){
                $url = route('azurira.strateskoplaniranje');
            }else{
                $url = route('spremi.strateskoplaniranje');
            }
        @endphp

        <form action="{{$url}}" method="post">
            @csrf
            {!! Form::hidden('id', isset($sp) ? $sp->id : '', ['class' => 'form-control']) !!}
            <section class="active">
                <div class="container_block">
                    <div class="split_container">
                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('naziv', 'Naziv : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('naziv', isset($sp) ? $sp->naziv : '', ['class' => 'form-control', 'rows' => 1, 'autocomplete' => 'off', 'maxlength' => 255, isset($id) ? 'readonly' : '']) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('br_plan_godina', 'Broj planiranih godina : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::number('br_plan_godina', isset($sp) ? $sp->br_plan_godina : '', ['class' => 'form-control', 'id' => 'br_plan_godina', 'autocomplete' => 'off', isset($id) ? 'readonly' : '', 'min' =>  1]) !!}
                                </div>
                            </div>
                        </div>



                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('id_rm', 'Radno mjesto : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!!  Form::select('id_rm', $radna_mjesta, isset($sp) ? $sp->id_rm : '' ,['class' => 'form-control', isset($id) ? 'disabled  = "true"' : '']) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('id_oju', 'Organ Javne uprave : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!!  Form::select('id_oju', $organ_ju, isset($sp) ? $sp->id_oju : '' ,['class' => 'form-control', isset($id) ? 'disabled  = "true"' : '']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('datum_broj', 'Datum i broj akta : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::textarea('datum_broj', isset($sp) ? $sp->datum_broj : '', ['class' => 'form-control', 'rows' => 4, 'maxlength' => 255, isset($id) ? 'readonly' : '']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="split_container">
                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('pb_neodredjeno', 'Postojeći broj na neodređeno : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::number('pb_neodredjeno', isset($sp) ? $sp->pb_neodredjeno : '', ['class' => 'form-control', 'id' => 'pb_neodredjeno', 'autocomplete' => 'off', isset($id) ? 'readonly' : '', 'min' => 0]) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('pb_odredjeno', 'Postojeći broj na određeno : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::number('pb_odredjeno', isset($sp) ? $sp->pb_odredjeno : '', ['class' => 'form-control', 'id' => 'pb_odredjeno', 'autocomplete' => 'off', isset($id) ? 'readonly' : '', 'min' => 0]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('pb_prekobrojnih', 'Postojeći broj prekobrojnih : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::number('pb_prekobrojnih', isset($sp) ? $sp->pb_prekobrojnih : '', ['class' => 'form-control', 'id' => 'pb_prekobrojnih', 'autocomplete' => 'off', isset($id) ? 'readonly' : '', 'min' => 0]) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('pb_godina', 'Postojeći broj - godina : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::number('pb_godina', isset($sp) ? $sp->pb_godina : '', ['class' => 'form-control', 'id' => 'pb_godina', 'autocomplete' => 'off', isset($id) ? 'readonly' : '', 'min' => 0]) !!}
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('pot_b_neodredjeno', 'Potreban broj na neodređeno vrijeme : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::number('pot_b_neodredjeno', isset($sp) ? $sp->pot_b_neodredjeno : '', ['class' => 'form-control', 'id' => 'pot_b_neodredjeno', 'autocomplete' => 'off', isset($id) ? 'readonly' : '', 'min' => 0]) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('pot_b_odredjeno', 'Potreban broj na određeno : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::number('pot_b_odredjeno', isset($sp) ? $sp->pot_b_odredjeno : '', ['class' => 'form-control', 'id' => 'pot_b_odredjeno', 'autocomplete' => 'off', isset($id) ? 'readonly' : '', 'min' => 0]) !!}
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('pot_b_godina', 'Potreban broj - godina : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::number('pot_b_godina', isset($sp) ? $sp->pot_b_godina : '', ['class' => 'form-control', 'id' => 'pot_b_godina', 'autocomplete' => 'off', isset($id) ? 'readonly' : '', 'min' => 0]) !!}
                                </div>
                            </div>
                        </div>

                        @if(!isset($id))
                            <div class="form-group" style="text-align:right; padding-right:16px; margin-top:30px;">
                                <button type="submit" class="btn btn-dark" id="custom_button" onclick="createNewDomElements('korisnici', 'nekaamo');">
                                    {{__('Spremite')}}
                                    <i class="fas fa-save"></i>
                                </button>
                            </div>
                        @endif

                    </div>
                </div>
            </section>
        </form>


    </div>
@endsection
