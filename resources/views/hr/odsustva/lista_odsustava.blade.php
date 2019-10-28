@extends('template.main')
@section('title') Dodajte novog službenika @stop

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('sluzbenik.pregled') => 'Lista državnih službenika',
        '#' => 'Lista odsustava državnog službenika',
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
                        <li class="{{ Request::path() == 'hr/odsustva/lista_odsustava/'.$od.'/'.$do.'/'.$sluzbenik_id ? 'active' : '' }} single_bar">
                            <i class="fa fa-list-ul"></i>
                            <a href="/hr/odsustva/lista_odsustava/01-{{date('m')}}-{{date('Y')}}/{{cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'))}}-{{date('m')}}-{{date('Y')}}/{{$sluzbenik_id}}">{{__('Lista odsustava')}}</a>
                        </li>
                        <li class="{{ Request::path() == 'hr/absence/pretraga' ? 'active' : '' }} single_bar">
                            <i class="far fa-calendar-times"></i>
                            <a href="/hr/odsustva/limiti_pojedinca/{{$sluzbenik_id}}/{{date('Y')}}">{{__('Limit odsustava')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="split_container split_container2 split_container4">
            <div class="drop_down_option">
                <div class="double_row">
                    <div class="single_row">
                        {!! Form::label('period_od', __('Period od').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('period_od', isset($od) ? $od : '' , ['class' => 'form-control datepicker', 'id' => 'period_od']) !!}
                        </div>
                        {!! Form::hidden('sluzbenik_id', $sluzbenik_id, ['id' => 'sluzbenik_id']) !!}
                    </div>
                    <div class="single_row">
                        {!! Form::label('period_do', __('Period od').' : ', ['class' => 'control-label']) !!}
                        <div class="col-lg-12">
                            {!! Form::text('period_do', isset($do) ? $do : '' , ['class' => 'form-control datepicker', 'id' => 'period_do', 'onInput' => 'blur("period_od", "period_do")']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr >
                        <th scope="col" width="40px;" style="text-align:center;">#</th>
                        <th scope="col">{{__('Period')}} </th>
                        <th scope="col">{{__('Vrsta odsustva')}}</th>
                        <th scope="col" width="120px;" style="text-align:center;">{{__('Broj dana')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @foreach($lista as $odsustvo)
                        <tr>
                            <th scope="col" width="40px;" style="text-align:center;">{{$i++}}</th>
                            <th scope="col"> {{$odsustvo['period']}} </th>
                            <th scope="col">{{$odsustvo['vrsta_odsustva']}}</th>
                            <th scope="col" width="120px;" style="text-align:center;">{{$odsustvo['br_dana']}}</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="split_container split_container3">
            <div class="slika_sluzbenika">
                <img src="{{ asset('slike/slike_sluzbenika/'.$sluzbenik->fotografija) }}" id="slika_sluz" alt="">
                <input type="hidden" name="fotografija" id="fotografija">
                <div class="slika_sluzbenika_sjena" title="Fotografija "></div>
            </div>

            <div class="basic_info">
                <h3>{{$sluzbenik->ime.' '.$sluzbenik->prezime}}</h3>
            </div>
            <div class="basic_info">
                <h5>{{__('Rukovodilac poslova')}}</h5>
            </div>

            <div class="basic_info">
                <a href="{{asset('/hr/sluzbenici/uredi_sluzbenika/'.$sluzbenik->id)}}">
                    <p>{{__('Karton radnika')}}</p>
                </a>
            </div>
        </div>
    </div>
@endsection