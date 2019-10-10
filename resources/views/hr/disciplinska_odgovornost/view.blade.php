@extends('template.main')

@section('content')

    <div class="container">
        <div class="card ">
            <div class="card-header ads-darker">
                <button style="float:right;" class="btn btn-light" ><i class="fa fa-save"></i>{{__(' Sačuvaj')}}</button>
                <button style="float:right;margin-right:5px;" class="btn btn-light" ><i class="fa fa-pen"></i>{{__(' Izmijeni')}}</button>
                {{__('Viši stručni saradnik za upravljanje poslovnim procesom')}}
            </div>
            <div class="card-body hr-activity tab">
                <div class="row">
                    <div class="col-md-8">
                        <table class="table table-sm">
                            <tbody>
                            <tr>
                                <td><b>{{__('Opis povrede:')}}</b></td>
                                <td>{{__('Neki opis povrede')}}</td>
                            </tr>
                            <tr>
                                <td><b>{{__('Datum povrede:')}}</b></td>
                                <td>1.1.2019</td>
                            </tr>
                            <tr>
                                <td><b>{{__('Opis disciplinske mjere:')}}</b></td>
                                <td>{{__('Neki opis disciplinske mjere')}}</td>
                            </tr>
                            <tr>
                                <td><b>{{__('Broj rješenja zabrane:')}}</b></td>
                                <td>123</td>
                            </tr>
                            <tr>
                                <td><b>{{__('Datum rješenja zabrane:')}}</b></td>
                                <td>1.1.2019</td>
                            </tr>
                            <tr>
                                <td><b>{{__('Datum završetka zabrane:')}}</b></td>
                                <td>1.2.2019</td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="table table-sm">
                        <thead>{{__('Disciplinska komisija')}}</thead>
                        <tbody>
                            <tr>
                                <td><b>{{__('Ime i prezime:')}}</b></td>
                                <td>NN</td>
                            </tr>
                            <tr>
                                <td><b>{{__('Institucija:')}}</b></td>
                                <td></td>
                            </tr>
                        </tbody>
                        </table>
                        <table class="table table-sm">
                            <tbody>
                            <thead>{{__('Medijatori')}}</thead>
                            <tr>
                                <td><b>{{__('Ime i prezime:')}}</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>{{__('Institucija:')}}</b></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="table table-sm">
                            <tbody>
                            <thead>{{__('Žalba')}}</thead>
                            <tr>
                                <td><b>{{__('Broj uložene žalbe:')}}</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>{{__('Datum uložene žalbe:')}}</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>{{__('Broj odluke žalbe:')}}</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>{{__('Datum odluke žalbe:')}}</b></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="table table-sm">
                            <tbody>
                            <thead>{{__('Suspenzija')}} </thead>
                            <tr>
                                <td><b>{{__('Razlog udaljenja:')}}</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>{{__('Datum udaljenja:')}}</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>{{__('Broj rješenja:')}}</b></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <div class="card" style="text-align: center;">
                            <div class="card-header ads-darker">
                                {{__('Trenutno uposleni/a na ovom radnom mjestu')}}
                            </div>
                            <div class="col-md-6" style="margin:0 auto;">
                                <br />
                                <img class="card-img-top rounded-circle img-thumbnail mx-auto d-block"  src="/images/amke.png" alt="Card image cap">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{__('Amina Spahić')}}</h5>
                                <p class="card-text">{{__('Viši stručni saradnik za upravljanje poslovnim procesom')}}</p>
                                <a href="#" class="btn btn-primary">{{__('Pregled kartona zaposlenika')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection