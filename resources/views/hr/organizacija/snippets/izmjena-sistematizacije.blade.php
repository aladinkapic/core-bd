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
                    <h2>{{__('Izmjena Organizacionog plana / Pravilnika')}}</h2>
                    <p>{{__('Molimo Vas da popunite sva potrebna polja za unos. Sve aktivnosti na ovoj stranici će biti
                        zabilježene.')}}</p>
                </div>

                <form method="POST" action="{{ route('organizacija.update-files') }}" enctype="multipart/form-data">
                    @csrf

                    <div id="steps-window" class="cookie-saves" cookie-name="organizacija-create">
                        <ul>
                            <li class="active">
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
                            <div class="card">
                                <div class="card-body">
                                    {{__('Molimo Vas da priložite dokument - Organizacioni plan / Pravilnik sa izmjenama / dopunama kako bi uspješno spasili izmjene Organizacionog plana / Pravilnika.')}}
                                    <br />
                                    <br />
                                    <div class="text-center">

                                        {!! Form::hidden('id', $organizacija->id ?? '1') !!}

                                        <div class="custom-file col-md-4">
                                            <input type="file" name="dokument" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile"><i class="fa fa-file" style="padding-right: 10px;"></i> {{__('Kliknite za odabir dokumenta')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <br><br>
                        <button class="btn btn-success" type="submit">
                            <i class="fab fa-telegram"></i>
                            {{__('Spremite')}}
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <!-- End Multi step form -->

@stop
