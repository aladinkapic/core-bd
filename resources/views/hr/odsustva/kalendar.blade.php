@extends('template.main')

<!-- css links -->
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('sluzbenik.pregled') => 'Lista državnih službenika',
        route('odsustva.kalendar', ['id_sluzbenika' => $sluzbenik_id]) => 'Pregled kalendara državnog službenika',
    ]) !!}

@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="steps-wizard" style="width:100%; margin-left:10px;">
                <ul class="four">
                    <li class="{{ Request::path() == 'hr/odsustva/kalendar/'.$sluzbenik_id ? 'active' : '' }} single_bar">
                        <i class="far fa-calendar-alt"></i>
                        <a href="{{asset('/hr/odsustva/kalendar/'.$sluzbenik_id ?? '1')}}">{{__('Pregled kalendara državnog službenika')}}</a>
                    </li>
                    <li class="single_bar">
                        <i class="fa fa-list-ul"></i>
                        <a href="/hr/odsustva/lista_odsustava/01.{{date('m')}}.{{date('Y')}}/{{cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'))}}.{{date('m')}}.{{date('Y')}}/{{$sluzbenik_id}}">{{__('Lista odsustava')}}</a>
                    </li>
                    <li class="single_bar">
                        <i class="far fa-calendar-times"></i>
                        <a href="/hr/odsustva/limiti_pojedinca/{{$sluzbenik_id}}/{{date('Y')}}">{{__('Limit odsustava')}}</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="registruj_odsustvo">
            <div class="registruj_odsustvo_values">
                <div class="registruj_odsustvo_header">
                    <h4>{{__('Registrujte odsustvo')}}</h4>
                    <i class="fas fa-times" title="Zatvorite" onclick="openDialbox();"></i>
                </div>

                <div class="registruj_odustvo_body"  id="inset_new_leav">
                    <div class="split_container">
                        <div class="form-group row">
                            {!! Form::hidden('sluzbenik_id', $sluzbenik_id, ['class' => 'control-label']) !!}
                            {!! Form::hidden('id_odsustva', 0, ['class' => 'control-label', 'id' => 'id_odsustva']) !!}
                            <!-- Ime -->
                            <div class="col">
                                {!! Form::label('vrsta_odsustva', 'Vrsta odsustva : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!!  Form::select('vrsta_odsustva', $odsustva, '0' ,['class' => 'form-control',  'id' => 'vrsta_odsustva']) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('putni_nalog', 'Putni nalog : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('putni_nalog', $value = null, ['class' => 'form-control', 'rows' => 1, 'id' => 'putni_nalog']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('naknade', 'Naknade : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('naknade', $value = null, ['class' => 'form-control', 'rows' => 1, 'id' => 'naknade']) !!}
                                </div>
                            </div>
                            <div class="col">
                                {!! Form::label('troskovi', 'Troškovi : ', ['class' => 'control-label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('troskovi', $value = null, ['class' => 'form-control', 'rows' => 1, 'id' => 'troskovi']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                {!! Form::label('datum_od', __('Datum od').' : ', ['class' => 'control-label', 'id' => 'datum_od_label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('datum_od', '' , ['class' => 'form-control datepicker', 'id' => 'datum_od', 'autocomplete' => 'off']) !!}
                                </div>
                            </div>
                            <div class="col" id="datum_do_w">
                                {!! Form::label('datum_do', __('Datum do').' : ', ['class' => 'control-label', 'id' => 'datum_od_label']) !!}
                                <div class="col-lg-12">
                                    {!! Form::text('datum_do', '' , ['class' => 'form-control datepicker', 'id' => 'datum_do', 'autocomplete' => 'off']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="napomena" class="col-form-label">{{__('Napomena :')}}</label>
                            <textarea class="form-control" id="napomena"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"  onclick="openDialbox();">{{__('Zatvorite')}}</button>
                            <button type="button" class="btn btn-primary" onclick="unesiOdsustvo();">{{__('Unesite odsustvo')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="calendar"> </div>
        {!! Form::hidden('sluzbenik_id', $sluzbenik_id, ['class' => 'form-control', 'id' => 'sluzbenik_id' ]) !!}
    </div>
@endsection


@section('other_js_links')
    <script>
        window.onload = function(){
            init_calendar(true);
        }
    </script>
@endsection