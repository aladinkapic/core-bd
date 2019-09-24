@extends('template.main')
@section('title') Naziv šifrarnika @endsection

@section('content')
    <div class="container">
        <div class="card" style="width:100%;">
            <div class="card-header ads-darker">
                <button style="float:right;" onClick="window.location=' {{route('dodaj.sifrarnik', ['type' => $type])}} ';" class="btn btn-light" ><i class="fas fa-chevron-circle-left"></i> Nazad na šifrarnik </button>
                <h4>Naziv šifrarnika</h4>
            </div>
        </div>


        <div class="card-body hr-activity tab">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{route('spremi.sifrarnik')}}"  method="post">
                        @csrf
                        <table class="table table-sm">
                            <tbody>
                            {{ Form::hidden('type', $type, ['class' => 'form-control', 'readonly']) }}
                            <tr>
                                <td><b>Vrijednost :</b></td>
                                <td>{{ Form::number('value', '', ['class' => 'form-control', 'autocomplete' => 'off', 'min' => 0]) }}</td>
                            </tr>
                            <tr>
                                <td><b>Naslov :</b></td>
                                <td>{{ Form::text('name', '', ['class' => 'form-control', 'autocomplete' => 'off', 'maxlength' => 50]) }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    {{ Form::checkbox('check', 'value', ['class' => 'form-control']) }}
                                    Upisom podataka i spremanjem u bazu podataka potvrđujem da su svi uneseni podaci tačni te ne utiču na stabilnost, konzistentnost i integritet sistema i podataka. Svaka izmjena je zapisana.
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{ Form::submit( 'Spremite', ['class' => 'btn btn-primary', 'style' => 'margin-top:20px;']) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
