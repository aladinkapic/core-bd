@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('ugovor.index') => __('Radni status i raspored na radno mjesto'),
        route('ugovor.radni_status.edit', ['id' => $ugovor->id]) => 'Izmjena ugovora',
    ]) !!}

@stop

@section('content')

    <div class="container ">
        @include('hr.ugovori.snippets.menu')

        <div class="" style="margin-left:20px; width:calc(100% - 46px); padding-left:4px;">
            <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{__('Izmjena ugovora o rasporedu na radno mjesto')}}
                    </div>
                    <div class="card-body">

                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach

                        <form method="POST" action="{{ route('ugovor.radni_status.update', ['id' => $ugovor->id]) }}">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Broj ugovora/odluke')}}
                                </div>
                                <div class="col-md-7">
                                    <input required="required" class="form-control" value="{{ $ugovor->broj }}" type="text" name="broj"
                                           placeholder="Unesite broj ugovora..." />
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Službenik')}}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::text('e_slu', $e_slu->ime_prezime ?? '', ['class' => 'form-control', 'readonly']) !!}
{{--                                    <select class="form-control" name="sluzbenik">--}}
{{--                                        @foreach($sluzbenici as $sluzbenik)--}}
{{--                                            <option @if($sluzbenik->id == $ugovor->sluzbenik) selected="selected" @endif value="{{ $sluzbenik->id ?? '1'}}">{{ $sluzbenik->ime ?? '/'}} {{ $sluzbenik->prezime ?? '/'}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Organ javne uprave')}}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::text('e_org', $e_org->naziv ?? '', ['class' => 'form-control', 'readonly'])!!}
{{--                                    {!! Form::select('organ', $organi, $ugovor->organ ?? '', ['class' => 'form-control radna-mjesta-organa',]) !!}--}}
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Radno mjesto')}}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::text('e_rm', $e_rm->naziv_rm ?? '', ['class' => 'form-control', 'readonly'])!!}
{{--                                    {!! Form::select('radno_mjesto', $radnaMjesta, $ugovor->radno_mjesto, ['class' => 'form-control select-2', 'id' => 'privremeno_radno_mjesto']) !!}--}}
{{--                                    <select class="form-control select-2" name="radno_mjesto" id="privremeno_radno_mjesto">--}}
{{--                                        <option value="1">{{__('Aktivna radna mjesta iz organa javne uprave')}}</option>--}}
{{--                                    </select>--}}
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Datum ugovora/odluke')}}
                                </div>
                                <div class="col-md-7">
                                    <input value="{{ \Carbon\Carbon::parse($ugovor->datum)->format('d.m.Y') }}" id="datum-ugovora" required="required" class="form-control datepicker" type="text" name="datum"
                                           placeholder="Datum ugovora/odluke..."/>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Datum isteka ugovora/odluke')}}
                                </div>
                                <div class="col-md-7">
                                    <input value="{{isset($ugovor) ? $ugovor->datumIsteka() : ''}}" id="datum-isteka-ugovora" class="form-control datepicker" type="text" name="datum_isteka"
                                           placeholder="Datum isteka ugovora/odluke..."/>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Datum isteka probnog perioda')}}
                                </div>
                                <div class="col-md-7">
                                    <input value="{{isset($ugovor) ? $ugovor->datumIstekaProbni() : ''}}" id="datum-isteka-probnog" class="form-control datepicker" type="text" name="datum_isteka_probni"
                                           placeholder="Datum isteka probnog perioda..."/>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Broj sati')}}
                                </div>
                                <div class="col-md-7">
                                    {!! Form::select('broj_sati', $radno_v, $ugovor->broj_sati ?? '', ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    {{__('Datum početka rada')}}
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control datepicker-2" type="text" id="datum3" name="datum_pocetka_rada"
                                           placeholder="Datum početka rada..." value="{{$ugovor->datumPocetkaRada() ?? ''}}"/>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">

                                </div>
                                <div class="col-md-7">
                                    <button class="btn btn-success">
                                        <i class="fa fa-plus"></i> {{__('Sačuvaj')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </div>




@endsection
