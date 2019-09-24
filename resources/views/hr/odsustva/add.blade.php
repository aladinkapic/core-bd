@extends('template.main')

@section('content')
    <div class="container">
        <div class="card ">
            <div class="card-header ads-darker">
                <button style="float:right;" onClick="window.location='/hr/odsustva/vrste_odsustva';" class="btn btn-light" ><i class="fas fa-chevron-circle-left"></i> Nazad na pregled odsustava</button>
                <h4>Pregledajte odsustva</h4>
            </div>
            <div class="card-body hr-activity tab">
                <div class="row">
                    <div class="col-md-12">
                        <form action="/hr/odsustva/spremi_vrstu_odsust"  method="post">
                            @csrf
                            <table class="table table-sm">
                                <tbody>
                                <tr>
                                    <td><b>Vrsta odsustva:</b></td>
                                    <td>{{ Form::text('vrstaodsustva', '', ['class' => 'form-control']) }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        {{ Form::checkbox('name', 'value', ['class' => 'form-control']) }}
                                        Upisom podataka i spremanjem u bazu podataka potvrđujem da su svi uneseni podaci tačni te ne utiču na stabilnost, konzistentnost i integritet sistema i podataka. Svaka izmjena je zapisana.
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>{{ Form::submit( 'Spremite odsustvo', ['class' => 'btn btn-primary', 'style' => 'margin-top:20px;']) }}</td>
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

