@extends('template.main')

@section('other_js_links')

@stop

@section('content')
    <div class="container">
        <!-- Multi step form -->
        <section class="multi_step_form">
            <div id="msform">
                <!-- Tittle -->
                <div class="tittle">
                    <h2>{{ $organizacija->naziv ?? '' }}</h2>
                    <p>{{__('Molimo Vas da popunite sva potrebna polja za unos. Sve aktivnosti na ovoj stranici će biti zabilježene.')}}</p>

                    <br />

                    @if ($errors->any())
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                </div>

                <form method="POST" action="{{ route('organizacija.update-this-org') }}" enctype="multipart/form-data">
                    @csrf

                    <div id="steps-window" class="cookie-saves" cookie-name="organizacija-create">
                        <ul>
                            <li class="active">
                                <div class="list_div">
                                    <div class="back_div"></div>
                                    <div class="icon_circle">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <p>
                                        {{__('Osnovne informacije')}}
                                    </p>
                                </div>
                            </li>
                            <li class="">
                                <div class="list_div">
                                    <div class="back_div"></div>
                                    <div class="icon_circle">
                                        <i class="fa fa-folder-open"></i>
                                    </div>
                                    <p>
                                        {{__('Pravilnik')}}
                                    </p>
                                </div>
                            </li>
                        </ul>
                        <section class="active">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            {!! Form::hidden('id', $organizacija->id, ['class' => 'form-control']) !!}
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label">{{__('Organ javne uprave')}}</label>
                                                <div class="col-sm-9 col">
                                                    {!! Form::select('oju_id', $organi, $organizacija->oju_id, ['class' => 'form-control', 'disabled' => 'true']) !!}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label">{{__('Naziv')}}</label>
                                                <div class="col-sm-9">
                                                    <input required="required" type="text" value="{{ $organizacija->naziv ?? '' }}" name="naziv" class="form-control" id="staticEmail"
                                                           placeholder="Unesite naziv organizacionog plana..." autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label">{{__('Opis')}}</label>
                                                <div class="col-sm-9">
                                                    <textarea required="required" class="form-control"  name="opis" autocomplete="off">{{ $organizacija->opis ?? '' }}</textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label">{{__('Početni datum')}}</label>
                                                <div class="col-sm-9">
                                                    <input required="required" type="text" name="datum_od" value="{{ Carbon\Carbon::parse($organizacija->datum_od)->format('d.m.Y') }}" autocomplete="off" id="datum_od" class="form-control datepicker" placeholder="d.m.Y">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label">{{__('Krajnji datum')}}</label>
                                                <div class="col-sm-9">
                                                    <input required="required" type="text" name="datum_do" value="{{ Carbon\Carbon::parse($organizacija->datum_do)->format('d.m.Y') }}" autocomplete="off" id="datum_do" class="form-control datepicker" placeholder="d.m.Y">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label">{{__('Kopiranje organizacionog plana')}} </label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="org_plan" disabled>
                                                        <option value="">{{__('Nije moguće kopiranje organizacionog plana')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </section>
                        <section>

                            <div class="card">
                                <div class="card-body">
                                    {{__('Molimo Vas da priložite dokument - Pravilnik o unutrašnjoj organizaciji sa sistematizacijom radnih mjesta kako bi nastavili sa procesom dodavanja organizacionog plana')}}

                                    <br />
                                    <br />
                                    <div class="text-center">
                                        <div class="custom-file col-md-4">
                                            <input type="file" name="dokument" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile"><i class="fa fa-file" style="padding-right: 10px;"></i> {{__('Kliknite za odabir dokumenta')}}</label>
                                        </div>
                                    </div>


                                </div>
                            </div>

                        </section>


                        <div class="buttons" style="text-align:center;">
                            <button class="btn btn-dark">
                                <i class="fas fa-chevron-left"></i>
                                {{__('Nazad')}}
                            </button>
                            <button style="" class="btn btn-blue">
                                {{__('Dalje')}}
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            <button class="btn btn-success">
                                <i class="fab fa-telegram"></i>
                                {{__('Pošalji')}}
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </section>
    </div>
    <!-- End Multi step form -->

@stop
