@extends('template.main')

@section('breadcrumbs')
    {!! \App\Http\Controllers\HelpController::breadcrumbs([
            route('home') => __('Početna stranica'),
            '/hr/organ_javne_uprave/home' => __('Organi javne uprave'),
            '/hr/uprava/viewUprava/{id}' => __('Pregled uprave'),
        ]) !!}
@endsection

@section('content')

    <div class="container">

        <div class="card ">
            <div class="card-header ads-darker">
                <button style="float:right;" class="btn btn-light" ><i class="fa fa-save"></i> Sačuvaj</button>
                <button style="float:right;margin-right:5px;" class="btn btn-light" ><i class="fa fa-pen"></i> Izmijeni</button>

                Organ javne uprave
            </div>
            <div class="card-body hr-activity tab">
                <div class="row">
                    <div class="col-md-8">
                        <table class="table table-sm">
                            <tbody>
                            <tr>
                                <td><b>Identifikaciski broj – TIN:</b></td>
                                <td> {{$uprava -> tin ?? '/'}} </td>
                            </tr>
                            <tr>
                                <td><b>Naziv organa javne uprave:</b></td>
                                <td> {{$uprava -> naziv ?? '/'}} </td>
                            </tr>
                            <tr>
                                <td><b>Tip organa javne uprave:</b></td>
                                <td> {{$uprava -> tip ?? '/'}} </td>
                            </tr>
                            <tr>
                                <td><b>Ulica:</b></td>
                                <td> {{$uprava -> ulica ?? '/'}} </td>
                            </tr>

                            <tr>
                                <td><b>Broj:</b></td>
                                <td> {{$uprava -> broj ?? '/'}} </td>
                            </tr>
                            <tr>
                                <td><b>Telefon:</b></td>
                                <td>{{$uprava -> telefon ?? '/'}}</td>
                            </tr>

                            <tr>
                                <td><b>Fax:</b></td>
                                <td>{{$uprava -> fax ?? '/'}}</td>
                            </tr>
                            <tr>
                                <td><b>Web:</b></td>
                                <td>{{$uprava -> web ?? '/'}}</td>
                            </tr>
                            <tr>
                                <td><b>E-mail:</b></td>
                                <td>{{$uprava -> email ?? '/'}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection