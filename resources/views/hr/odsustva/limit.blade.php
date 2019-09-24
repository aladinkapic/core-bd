@extends('template.main')
@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '#' => 'Postavke',
        route('limiti.dodajlimit') => 'Dodajte - uredite novi opšti limit',
    ]) !!}

@stop

@section('content')

    <div class="container">
        <div class="card ">
            <div class="card-header ads-darker">
                Opšti limit odsustva za {{date('Y')}} godinu
            </div>
            <div class="card-body hr-activity tab">
                <div class="row">
                    <div class="col-md-12">
                            @php
                                if(isset($limit)){
                                    $url = '/hr/odsustva/azuriraj_limite';
                                }else $url = '/hr/odsustva/spremi_limit';
                            @endphp

                        <form action="{{$url}}" method="post">
                            @csrf

                            @if(isset($limit))
                                {{ Form::hidden('id', $limit->id, ['class' => 'form-control']) }}
                            @endif

                            <table class="table table-sm">
                                <tbody>
                                @if(isset($ime_sluzbenika))
                                    <tr>
                                        <td><b>Ime i prezime :</b></td>
                                        <td>{{ Form::text('imeiprezime', isset($ime_sluzbenika) ? $ime_sluzbenika : '', ['class' => 'form-control', 'readonly']) }}</td>
                                    </tr>
                                @endif

                                <!-- Ako je službenik_id = 0, znači da se odnosi na apsolutno sve službenike !!!!! -->
                                {{ Form::hidden('sluzbenik_id', isset($sluzbenik_id) ? $sluzbenik_id : '0', ['class' => 'form-control']) }}

                                <tr>
                                    <td style="width:140px;"><b>Vrsta odsustva :</b></td>
                                    <td>
                                        {!!  Form::select('odsustvo', $odsustva, isset($limit->odsustvo) ? $limit->odsustvo : '' ,['class' => 'form-control',  'id' => 'odsustvo']) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Ukupno radnih dana :</b></td>
                                    <td>{{ Form::number('ukupno', isset($limit->ukupno) ? $limit->ukupno : '', ['class' => 'form-control', 'min' => 10]) }}</td>
                                </tr>
                                <tr>
                                    <td><b>Kalendarska godina :</b></td>
                                    <td>
                                        {!!  Form::select('godina', [(date('Y') - 1) => (date('Y') - 1), date('Y') => date('Y'), (date('Y') + 1) => (date('Y') + 1), (date('Y') + 2     ) => (date('Y') + 2) ], isset($limit->godina) ? $limit->godina : date('Y') ,['class' => 'form-control',  'id' => 'godina']) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        {{ Form::checkbox('name', 'value', ['class' => 'form-control']) }}
                                        Upisom podataka i spremanjem u bazu podataka potvrđujem da su svi uneseni podaci tačni te ne utiču na stabilnost, konzistentnost i integritet sistema i podataka. Svaka izmjena je zapisana.
                                    </td>
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td>
                                        <div class="modal-footer">
                                            {!! Form::submit('Postavite limit odsustva', ['class' => 'btn btn-primary']) !!}
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

