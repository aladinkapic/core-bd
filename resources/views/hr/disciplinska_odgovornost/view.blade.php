@extends('template.main')

@section('content')

    <div class="container">
        <div class="card ">
            <div class="card-header ads-darker">
                <button style="float:right;" class="btn btn-light" ><i class="fa fa-save"></i> Sačuvaj</button>
                <button style="float:right;margin-right:5px;" class="btn btn-light" ><i class="fa fa-pen"></i> Izmijeni</button>
                Viši stručni saradnik za upravljanje poslovnim procesom
            </div>
            <div class="card-body hr-activity tab">
                <div class="row">
                    <div class="col-md-8">
                        <table class="table table-sm">
                            <tbody>
                            <tr>
                                <td><b>Opis povrede:</b></td>
                                <td>Neki opis povrede</td>
                            </tr>
                            <tr>
                                <td><b>Datum povrede:</b></td>
                                <td>1.1.2019</td>
                            </tr>
                            <tr>
                                <td><b>Opis disciplinske mjere:</b></td>
                                <td>Neki opis disciplinske mjere</td>
                            </tr>
                            <tr>
                                <td><b>Broj rješenja zabrane:</b></td>
                                <td>123</td>
                            </tr>
                            <tr>
                                <td><b>Datum rješenja zabrane:</b></td>
                                <td>1.1.2019</td>
                            </tr>
                            <tr>
                                <td><b>Datum završetka zabrane:</b></td>
                                <td>1.2.2019</td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="table table-sm">
                        <thead>Disciplinska komisija</thead>
                        <tbody>
                            <tr>
                                <td><b>Ime i prezime:</b></td>
                                <td>NN</td>
                            </tr>
                            <tr>
                                <td><b>Institucija:</b></td>
                                <td></td>
                            </tr>
                        </tbody>
                        </table>
                        <table class="table table-sm">
                            <tbody>
                            <thead>Medijatori</thead>
                            <tr>
                                <td><b>Ime i prezime:</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Institucija:</b></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="table table-sm">
                            <tbody>
                            <thead>Žalba</thead>
                            <tr>
                                <td><b>Broj uložene žalbe:</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Datum uložene žalbe:</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Broj odluke žalbe:</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Datum odluke žalbe:</b></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="table table-sm">
                            <tbody>
                            <thead>Suspenzija </thead>
                            <tr>
                                <td><b>Razlog udaljenja:</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Datum udaljenja:</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Broj rješenja:</b></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <div class="card" style="text-align: center;">
                            <div class="card-header ads-darker">
                                Trenutno uposleni/a na ovom radnom mjestu
                            </div>
                            <div class="col-md-6" style="margin:0 auto;">
                                <br />
                                <img class="card-img-top rounded-circle img-thumbnail mx-auto d-block"  src="/images/amke.png" alt="Card image cap">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Amina Spahić</h5>
                                <p class="card-text">Viši stručni saradnik za upravljanje poslovnim procesom</p>
                                <a href="#" class="btn btn-primary">Pregled kartona zaposlenika</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection