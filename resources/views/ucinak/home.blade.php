@extends('template.main')

@section('content')

    <div class="container">
        <div class="card ">
            <div class="card-header ads-darker">
                {{__('Obrazac za ocjenjivanje državnog službenika')}}
            </div>
            <div class="card-body hr-activity tab">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm">
                            <tbody>
                            <tr>
                                <td><b>{{__('Ime i prezime:')}}</b></td>
                                <td>{{ Form::text('imeiprezime', '', ['class' => 'form-control']) }}</td>
                            </tr>
                            <tr>
                                <td><b>{{__('Radno mjesto:')}}</b></td>
                                <td>{{ Form::text('radnomjesto', '', ['class' => 'form-control']) }}</td>
                            </tr>
                            <tr>
                                <td><b>{{__('Godina:')}}</b></td>
                                <td>{{ Form::number('vrstaodsustva', '', ['class' => 'form-control']) }}</td>
                            </tr>
                            <tr>
                                <td><b>{{__('Ocjena-brojčana:')}}</b></td>
                                <td>{{ Form::number('brojdana', '', ['class' => 'form-control']) }}</td>
                            </tr>
                            <tr>
                                <td><b>{{__('Ocjena-opisna:')}}</b></td>
                                <td>{{ Form::textarea('brojdana', '', ['class' => 'form-control']) }}</td>
                            </tr>
                            <tr>
                                <td><b>{{__('Kategorija ocjene:')}}</b></td>
                                <td>{{ Form::text('kategorijaocjene', '', ['class' => 'form-control']) }}</td>
                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td>
                                    {{ Form::checkbox('name', 'value', ['class' => 'form-control']) }}
                                    {{__('Upisom podataka i spremanjem u bazu podataka potvrđujem da su svi uneseni podaci tačni te ne utiču na stabilnost, konzistentnost i integritet sistema i podataka. Svaka izmjena je zapisana.')}}
                                </td>
                            </tr>

                            </tbody>
                        </table>
                        <button style="float:right;" class="btn btn-dark" ><i class="fa fa-plus"></i> {{__('Dodaj')}}</button>
                    </div>
                </div>
            </div>
@endsection

