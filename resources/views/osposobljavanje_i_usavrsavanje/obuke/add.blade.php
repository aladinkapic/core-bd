@extends('template.main')
<?php
if (isset($instanca) and ($instanca === 'new')) {
    $save = true;
    $naslov = __('Pregled obuke');
    $naslov2 = __('Dodavanje instance obuke');
} else if (isset($pregled) and $pregled === true) {
    $naslov = __('Pregled obuke');
    $save = false;
} else {
    $save = true;
    if (isset($obuka)) {
        $naslov = __('Uređivanje obuke');
    } else {
        $naslov = __('Nova obuka');
    }
}

if (isset($instanca) and ($instanca) === 'new') {
    $formlink = "/osposobljavanje_i_usavrsavanje/obuke/storeInstancu";
} else if (isset($obuka)) {
    $formlink = '/osposobljavanje_i_usavrsavanje/obuke/update/' . $obuka->id;
} else $formlink = "/osposobljavanje_i_usavrsavanje/obuke/add";

if (isset($naslov2) and ($naslov2 === 'Dodavanje instance obuke')) $naslov = $naslov2;

if (isset($instanca) and $instanca != 'new') {
    $naslov = 'Pregled instance obuke';
    $save = false;
}

?>
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        '/osposobljavanje_i_usavrsavanje/obuke/home' => 'Katalog obuka',
    ]) !!}
@stop

@section('content')
    <div class="container">
        <section class="multi_step_form">
            <div id="msform">
                <div class="tittle">
                    <h2>
                        <?php
                        if (isset($naslov2) and ($naslov2 === 'new')) echo $naslov2; else
                            echo $naslov;
                        ?>
                    </h2>
                    <p>{{__('Molimo Vas da popunite sva potrebna polja za unos. Sve aktivnosti na ovoj stranici će biti
                        zabilježene.')}}</p>
                    <br/>
                </div>
                <div id="steps-window">
                    <ul>
                        <li class="active">
                            <div class="list_div">
                                <div class="back_div"></div>
                                <div class="icon_circle">
                                    <i class="fab fa-leanpub"></i>
                                </div>
                                <p>
                                    {{$naslov ?? '/'}}
                                </p>
                            </div>
                        </li>
                        @if (isset($instanca) and ($instanca) === 'new')
                            <li class="">
                                <div class="list_div">
                                    <div class="back_div"></div>
                                    <div class="icon_circle">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </div>
                                    <p>
                                        {{__('Dodjeljivanje predavača i polaznika')}}
                                    </p>
                                </div>
                            </li>
                            <li>
                                <div class="list_div">
                                    <div class="back_div"></div>
                                    <div class="icon_circle">
                                        <i class="fas fa-pen-fancy"></i>
                                    </div>
                                    <p>
                                        {{__('Objavljivanje obuke')}}
                                    </p>
                                </div>
                            </li>
                        @endif
                    </ul>
                    <form method="POST" id="kreiranje" action="{{$formlink}}" enctype="multipart/form-data">
                        @csrf
                        @if (isset($instanca) and ($instanca) === 'new')
                            <input type="hidden" value="{{$obuka->id ?? '1'}}" name="obukaid"/>
                        @endif
                        <input type="hidden" name="status" value="0"/>
                        <section class="active">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label"> {{__('Naziv obuke')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::text('naziv', isset($obuka) ? $obuka->naziv : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'naziv', 'autocomplete' => 'off', $readonly]) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('naziv'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('naziv')}}</p></div>@endif

                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Vrsta obuke')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::text('vrsta', isset($obuka) ? $obuka->vrsta : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'vrsta', 'autocomplete' => 'off', $readonly]) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('vrsta'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('vrsta')}}</p></div>@endif
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Opis obuke')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::textarea('opis', isset($obuka) ? $obuka->opis : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'opis', 'autocomplete' => 'off', $readonly]) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('opis'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('opis')}}</p></div>@endif
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Oblast obuke')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::select('oblast',$oblasti, isset($obuka) ? $obuka->oblast : '', ['class' => 'form-control', 'rows' => 3, 'id' => 'oblast', 'autocomplete' => 'off', $readonly]) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('oblast'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('oblast')}}</p></div>@endif
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Tema obuke')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::select('podtema', [], isset($obuka) ? $obuka->podtema : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'podtema', 'autocomplete' => 'off', $readonly]) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('podtema'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('podtema')}}</p></div>@endif
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Organizator obuke')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::text('organizator', isset($obuka) ? $obuka->organizator : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'organizator', 'autocomplete' => 'off', $readonly]) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('organizator'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('organizator')}}</p></div>@endif
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Sjedište organizatora obuke')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::text('sjediste', isset($obuka) ? $obuka->sjediste : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'sjediste', 'autocomplete' => 'off', $readonly]) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('sjediste'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('sjediste')}}</p></div>@endif

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{__('Zemlja organizatora')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::select('zemlja_organizatora', $drzava,isset($obuka) ? $obuka->zemlja_organizatora : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'zemlja_organizatora', 'autocomplete' => 'off', $readonly]) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('zemlja_organizatora'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('zemlja_organizatora')}}</p></div>@endif

                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Izdavanje potvrde')}}</label>
                                                <div class="col-sm-9">
                                                    {!!  Form::select('potvrda',array('0' => 'NE', '1' => 'DA'),  isset($obuka) ? $obuka->potvrda : '' ,['class' => 'form-control',  'id' => 'potvrda', $readonly]) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Datum certifikata')}}  </label>
                                                <div class="col-lg-9">
                                                    {!! Form::text('datum_certifikata', isset($obuka) ? \App\Http\Controllers\HelpController::obrniDatum($obuka->datum_certifikata) : '' , ['class' => 'form-control datepicker required', 'id' => 'datum_certifikata', 'autocomplete' => 'off', $readonly]) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Broj certifikata')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::text('broj_certifikata', isset($obuka) ? $obuka->broj_certifikata : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'broj_certifikata', 'autocomplete' => 'off', $readonly]) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('broj_certifikata'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('broj_certifikata')}}</p></div>@endif
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Finansiranje obuke')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::text('finansiranje_obuke', isset($obuka) ? $obuka->finansiranje_obuke : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'finansiranje_obuke', 'autocomplete' => 'off', $readonly]) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('finansiranje_obuke'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('finansiranje_obuke')}}</p></div>@endif
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Stečena znanja')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::textarea('stecena_znanja', isset($obuka) ? $obuka->stecena_znanja : '', ['class' => 'form-control', 'rows' => 1, 'id' => 'stecena_znanja', 'autocomplete' => 'off', $readonly]) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('stecena_znanja'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('stecena_znanja')}}</p></div>@endif
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label">{{ __('Maksimalan broj polaznika')}}</label>
                                                <div class="col-sm-9">
                                                    {!! Form::number('broj_polaznika', isset($obuka) ? $obuka->broj_polaznika : '', ['class' => 'form-control', 'max' => 100, 'min' => 1, 'id' => 'broj_polaznika', 'autocomplete' => 'off', $readonly]) !!}
                                                </div>
                                            </div>
                                            @if ($errors ->has('broj_polaznika'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('broj_polaznika')}}</p></div>@endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        @if (isset($instanca))
                            <section>
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row">
                                            @if(isset($instanca->sviPredavaci))
                                                <div class="col-6">
                                                    <h4 class="col-12">{{__('Predavači')}}</h4>
                                                    @foreach($instanca->sviPredavaci as $predavac)
                                                        <h6>{{$predavac->imePredavaca->ime.' '.$predavac->imePredavaca->prezime}}</h6>
                                                    @endforeach
                                                </div>
                                            @else
                                                @if (!empty($nizpredavaca))
                                                    <div class="form-group col-md-6 align-top" id="predavacidiv"
                                                         style="vertical-align: top !important;padding-left:15px; ">
                                                        <h4 class="col-12">{{__('Predavači')}}</h4>

                                                        <select class="js-example-basic-single" style="width: 100%;"
                                                                name="predavaci[]" multiple="multiple">
                                                            @foreach($nizpredavaca as $id => $imeprezime)
                                                                <option value="{{$id}}">{{$imeprezime}}</option>
                                                            @endforeach
                                                        </select>

                                                        <br>
                                                        @if ($errors ->has('predavacidiv'))
                                                            <div class="notificaiton_area alert-danger">
                                                                <p> {{ $errors->first('predavacidiv')}}</p></div>@endif
                                                    </div>
                                                @endif

                                                @if (empty($nizpredavaca))
                                                    <div class="col-6">
                                                        {{__('Nema predavača sa selektovanom oblasti')}}
                                                        <br/>
                                                        <a href="/osposobljavanje_i_usavrsavanje/predavaci/add">
                                                            {{__('Klikite ovdje kako biste dodali predavača')}}
                                                        </a>
                                                    </div>
                                                @endif
                                            @endif




                                            @if(isset($instanca->sviSluzbenici))
                                                <div class="col-6">
                                                    <h4 class="col-12">{{__('Službenici')}}</h4>
                                                    @foreach($instanca->sviSluzbenici as $predavac)
                                                        <h6>{{$predavac->imeSluzbenika->ime_prezime}}</h6>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="col-md-6">
                                                    <h4 class="col-12">{{__('Službenici')}}</h4>
                                                    <select class="js-example-basic-multiple" style="width: 100%;"
                                                            name="sluzbenici[]" multiple="multiple">
                                                        @foreach($nizsluzbenika as $id => $imeprezime)

                                                            <option value="{{$id}}">{{$imeprezime}}</option>
                                                        @endforeach
                                                    </select>
                                                    <br>
                                                    @if ($errors ->has('sluzbenici'))
                                                        <div class="notificaiton_area alert-danger">
                                                            <p> {{ $errors->first('sluzbenici')}}</p></div>@endif
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row vertical-align">

                                            <div class="form-group col-md-6 " id="sluzbenikDiv"
                                                 style="vertical-align: top !important;">
                                            </div>
                                            @if ($errors ->has('predavac_id'))
                                                <div class="notificaiton_area alert-danger">
                                                    <p> {{ $errors->first('predavac_id')}}</p></div>@endif
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <div class="card">
                                    <div class="card-body">

                                        <div class="form-group row">
                                            <label for="staticEmail"
                                                   class="col-sm-3 col-form-label">{{ __('Početak obuke')}}  </label>
                                            <div class="col-lg-9">
                                                {!! Form::text('pocetak',  $instanca->odrzavanje_od ?? '' , ['class' => 'form-control datepicker required', 'id' => 'pocetak', 'autocomplete' => 'off', $instanca != 'new' ? 'disabled' : '']) !!}
                                            </div>
                                        </div>
                                        @if ($errors ->has('pocetak'))
                                            <div class="notificaiton_area alert-danger">
                                                <p> {{ $errors->first('pocetak')}}</p></div>@endif

                                        <div class="form-group row">
                                            <label for="staticEmail"
                                                   class="col-sm-3 col-form-label">{{ __('Kraj obuke')}}  </label>
                                            <div class="col-lg-9">
                                                {!! Form::text('kraj',  $instanca->odrzavanje_do ?? '' , ['class' => 'form-control datepicker required', 'id' => 'kraj', 'autocomplete' => 'off', $instanca != 'new' ? 'disabled' : '']) !!}
                                            </div>
                                        </div>
                                        @if ($errors ->has('kraj'))
                                            <div class="notificaiton_area alert-danger">
                                                <p> {{ $errors->first('kraj')}}</p></div>@endif
                                    </div>
                                </div>
                            </section>
                    </form>
                    @endif
                    <div class="buttons" style="text-align:center;">
                        @if (isset($instanca))
                            <button class="btn btn-dark">
                                <i class="fas fa-chevron-left"></i>
                                {{__('Nazad')}}
                            </button>
                            <button style="" class="btn btn-blue">
                                {{__('Dalje')}}
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        @endif
                        @if($save)
                            <button class="btn btn-success" onclick="document.querySelector('#kreiranje').submit();">
                                <i class="fab fa-telegram"></i>
                                {{__('Spremi')}}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
    @if (isset($obuka))
        <div id="maxsluz" hidden>{{$obuka -> broj_polaznika ?? '/'}}</div>
    @endif

@stop
@section('js')
    <script>
        $('#oblast').change(function(){
            $("#podtema option").remove();
            let id =  $('#oblast').val();
            $.ajax({
                url : '{{ route( 'loadPodteme' ) }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                type: 'post',
                dataType: 'json',
                success: function( result )
                {
                    $.each( result, function(k, v) {
                        $('#podtema').append($('<option>', {value:k, text:v}));
                    });
                },
                error: function()
                {
                    //handle errors
                    alert('error...');
                }
            });
        });


    </script>
@endsection
