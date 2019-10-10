@extends('template.main')

@section('other_js_links')
    <script async src="{{ asset('js/organizacija.js') }}"></script>
    <script>



        app.getOrganizacija = function(){
          $.post({
              "url": "{{ route('organizacija.api') }}",
              "data": { action: "getOrganizacija", "_token": "{{ csrf_token() }}", org_id: $("#oju_id").val() }
          }).done(function(data){

              app.items = JSON.parse(data);

          });
        };
    </script>
@stop

@section('content')
    <div class="container">
        <!-- Multi step form -->
        <section class="multi_step_form">
            <div id="msform">
                <!-- Tittle -->
                <div class="tittle">
                    <h2>{{__('Novi organizacioni plan')}}</h2>
                    <p>{{__('Molimo Vas da popunite sva potrebna polja za unos. Sve aktivnosti na ovoj stranici će biti
                        zabilježene.')}}</p>

                    <br />

                    @if ($errors->any())
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                               {{ $error }}
                            </div>
                        @endforeach
                    @endif
                </div>

                <form method="POST" action="{{ route('organizacija.store') }}" enctype="multipart/form-data">
                    {{ method_field('PUT') }}
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
                        <li>
                            <div class="list_div">
                                <div class="back_div"></div>
                                <div class="icon_circle">
                                    <i class="fa fa-flag"></i>
                                </div>
                                <p>
                                    {{__('Zaključak')}}
                                </p>
                            </div>
                        </li>
                    </ul>
                    <section class="active">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 col-form-label">{{__('Organ javne uprave')}}</label>
                                            <div class="col-sm-9 col">
                                                <select required="required" class="form-control" name="oju_id" id="oju_id" v-on:change="getOrganizacija()">
                                                    <option selected="selected" value="">{{__('Odaberite...')}}</option>
                                                    @foreach(\App\Models\Organ::all() as $organ)
                                                        <option value="{{ $organ->id }}">{{ $organ->naziv ?? 'Ne postoji ime!' }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 col-form-label">{{__('Naziv')}}</label>
                                            <div class="col-sm-9">
                                                <input required="required" type="text" value="{{ old('naziv') }}" name="naziv" class="form-control" id="staticEmail"
                                                       placeholder="Unesite naziv organizacionog plana..." autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 col-form-label">{{__('Opis')}}</label>
                                            <div class="col-sm-9">
                                                <textarea required="required" class="form-control"  name="opis" autocomplete="off">{{ old('opis') }}</textarea>
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
                                                <input required="required" type="text" name="datum_od" value="{{ old('datum_od') }}" autocomplete="off" id="datum_od" class="form-control datepicker" placeholder="d.m.Y">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 col-form-label">{{__('Krajnji datum')}}</label>
                                            <div class="col-sm-9">
                                                <input required="required" type="text" name="datum_do" value="{{ old('datum_do') }}" autocomplete="off" id="datum_do" class="form-control datepicker" placeholder="d.m.Y">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-3 col-form-label">{{__('Kopiranje organizacionog plana:')}} </label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="org_plan" >
                                                    <option value="">{{__('Novi organizacioni plan')}}</option>
                                                    <option v-for="org in items" v-bind:value=" org.id ">@{{ org.naziv }}</option>
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
                                {{__('Molimo Vas da priložite dokument - Pravilnik o unutrašnjoj organizaciji sa sistematizacijom radnih mjesta kako bi nastavili sa procesom dodavanja organizacionog plana.')}}

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
                    <section>
                        <div class="card">
                            <div class="card-body">


                                <br />
                                <br />
                                <div class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input" name="agree" type="checkbox" value="1" id="defaultCheck1">

                                        <label class="form-check-label" for="defaultCheck1">
                                            <br {{__('/>Odabirom kvačice potvrđujem da su unesene informacije tačne i u skladu sa priloženim pravilnikom.')}}
                                        </label>
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