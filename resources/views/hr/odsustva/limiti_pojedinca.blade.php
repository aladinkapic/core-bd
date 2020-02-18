@extends('template.main')
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('sluzbenik.pregled') => __('Lista državnih službenika'),
        '#' => __('Limiti odsustava po službeniku'),
    ]) !!}

@stop

@section('content')
    <div class="container container_block">
        <div class="full_container">
            <div class="row">
                <div class="steps-wizard" style="width:100%; margin-left:10px;">
                    <ul class="four">
                        <li class="{{ Request::path() == 'hr/odsustva/kalendar/'.$sluzbenik_id ? 'active' : '' }} single_bar">
                            <i class="far fa-calendar-alt"></i>
                            <a href="{{asset('/hr/odsustva/kalendar/'.$sluzbenik_id)}}">{{__('Pregled kalendara državnog službenika')}}</a>
                        </li>
                        <li class="single_bar">
                            <i class="fa fa-list-ul"></i>
                            <a href="/hr/odsustva/lista_odsustava/01-{{date('m')}}-{{date('Y')}}/{{cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'))}}-{{date('m')}}-{{date('Y')}}/{{$sluzbenik_id}}">{{__('Lista odsustava')}}</a>
                        </li>
                        <li class="{{ Request::path() == 'hr/odsustva/limiti_pojedinca/'.$sluzbenik_id.'/'.$godina ? 'active' : '' }} single_bar">
                            <i class="far fa-calendar-times"></i>
                            <a href="/hr/odsustva/limiti_pojedinca/{{$sluzbenik_id}}/{{date('Y')}}">{{__('Limit odsustava')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @foreach($svi_limiti as $limit)
            <div class="split_container" style="width:100%; margin-top:30px;">

                <div class="limits_edit_delete">
                    <a href="/hr/odsustva/uredi_limite/{{$limit->id.'/'.$sluzbenik_id}}">
                        <div class="icon_wrapper">
                            <i class="fas fa-edit"></i>
                        </div>
                    </a>
                    <a href="{{asset('/hr/odsustva/obrisi_limite/'.$limit->id.'/'.$sluzbenik_id)}}" title="Obrišite limit odsustva">
                        <div class="icon_wrapper">
                            <i class="fas fa-trash"></i>
                        </div>
                    </a>
                </div>

                <div class="form-group row">
                    <div class="col">
                        {!! Form::label('prezime', 'Vrsta odsustva : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!!  Form::select('vrsta_odsustva', $odsustva, $limit->odsustvo ,['class' => 'form-control',  'id' => 'vrsta_odsustva', 'disabled' => 'true']) !!}
                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col">
                        {!! Form::label('username', 'Ukupno trajanje odsustva : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('korisnicko_ime', $limit->ukupno.' radnih dana', ['class' => 'form-control', 'rows' => 1, 'placeholder' => '', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="col">
                        {!! Form::label('email', 'Godina : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!!  Form::select('godina', [(date('Y') - 1) => (date('Y') - 1), date('Y') => date('Y'), (date('Y') + 1) => (date('Y') + 1), (date('Y') + 2     ) => (date('Y') + 2) ], isset($limit->godina) ? $limit->godina : date('Y') ,['class' => 'form-control',  'id' => 'godina', 'disabled' => 'true']) !!}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

