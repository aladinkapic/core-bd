@extends('template.main')

@section('content')

<div class="container">

    <div class="card ">
        <div class="card-header ads-darker">
            <button class="btn btn-light float-right" ><i class="fa fa-save"></i> {{__('Sačuvaj')}}</button>
            <button class="btn btn-light float-right mr-3" ><i class="fa fa-pen"></i> {{__('Izmijeni')}}</button>
            {{__('Registar ugovora - Radni status i raspored na radno mjesto')}}
        </div>
        <div class="card-body hr-activity tab">
            <div class="row">
                <div class="col-md-8">
                    <table class="table table-sm">
                        <tbody>
                        <tr>
                            <td><b>{{__('Broj ugovora/odluke:')}}</b></td>
                            <td>PC-1234</td>
                        </tr>
                        <tr>
                            <td><b>{{__('Službenik:')}}</b></td>
                            <td>Amina Spahić</td>
                        </tr>
                        <tr>
                            <td><b>{{__('Datum ugovora/odluke:')}}</b></td>
                            <td>09.09.2010.</td>
                        </tr>
                        <tr>
                            <td><b>{{__('Datum isteka ugovora/odluke:')}}</b></td>
                            <td>09.07.2019.</td>
                        </tr>
                        <tr>
                            <td><b>{{__('Datum isteka probnog perioda:')}}</b></td>
                            <td>10.10.2011.</td>
                        </tr>
                        <tr>
                            <td><b>{{__('Broj sati:')}}</b></td>
                            <td>8</td>
                        </tr>
                        <tr>
                            <td><b>{{__('Službeni telefonski broj:')}}</b></td>
                            <td>+387 33 233 331</td>
                        </tr>
                        <tr>
                            <td><b>{{__('E-mail adresa:')}}</b></td>
                            <td>amina.spahic@teneo.ba</td>
                        </tr>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">

                    <div class="card text-center">
                        <div class="col-md-6 mx-auto">
                            <br />
                            <img class="card-img-top rounded-circle img-thumbnail mx-auto d-block"  src="/images/amke.png" alt="Card image cap">
                        </div>
                        <div class="card-body">

                            <h5 class="card-title">{{__('Amina Spahić')}}</h5>
                            <p class="card-text">{{__('Viši stručni saradnik za upravljanje poslovnim procesom')}}</p>
                            <button class="btn btn-info" ></i> {{__('Karton radnika')}}</button>
                        </div>
                    </div>
                </div>
                <br />
                <br />
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">{{__('Prethodno')}}</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">{{__('Sljedeće')}}</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>




</div>

@endsection
