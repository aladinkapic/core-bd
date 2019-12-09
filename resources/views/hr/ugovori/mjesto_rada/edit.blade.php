@extends('template.main')

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

                            <form method="POST" action="{{ route('ugovor.mjesto_rada.update', ['id' => $ugovor->id]) }}">
                                @csrf
                                @method('PATCH')

                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Službenik')}}
                                    </div>
                                    <div class="col-md-7">
                                        <select class="form-control" name="sluzbenik">
                                            @foreach($sluzbenici as $sluzbenik)
                                                <option @if($sluzbenik->id == $ugovor->sluzbenik) selected="selected" @endif value="{{ $sluzbenik->id ?? '1'}}">{{ $sluzbenik->ime ?? '/'}} {{ $sluzbenik->prezime ?? '/'}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Adresa')}}
                                    </div>
                                    <div class="col-md-7">
                                        <input value="{{ $ugovor->adresa ?? '/'}}" required="required" class="form-control" type="text" name="adresa"
                                               placeholder="Unesite adresu..." />
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Sprat')}}
                                    </div>
                                    <div class="col-md-7">
                                        <input value="{{ $ugovor->sprat ?? '/'}}" required="required" class="form-control" type="text" name="sprat"
                                               placeholder="Sprat..."/>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Broj kancelarije')}}
                                    </div>
                                    <div class="col-md-7">
                                        <input value="{{ $ugovor->broj_kancelarije ?? '/'}}" class="form-control" type="text" name="broj_kancelarije"
                                               placeholder="Broj kancelarije..."/>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Službeno auto na raspolaganju')}}
                                    </div>
                                    <div class="col-md-7">
                                        <input @if($ugovor->sluzbeno_auto == 1) checked="checked" @endif type="checkbox" value="1" name="sluzbeno_auto"
                                               placeholder="Službeno auto na raspolaganju..." >
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">
                                        {{__('Povjerena stalna sredstva')}}
                                    </div>
                                    <div class="col-md-7">
                                    <textarea class="form-control"  name="povjerena_stalna_sredstva"
                                              placeholder="Povjerena stalna sredstva..." >{{ $ugovor->povjerena_stalna_sredstva ?? '/'}}</textarea>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-md-5">

                                    </div>
                                    <div class="col-md-7">
                                        <button class="btn btn-success">
                                            <i class="fa fa-plus"></i> {{__('Dodaj')}}
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