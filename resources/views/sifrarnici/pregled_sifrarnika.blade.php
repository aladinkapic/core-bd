@extends('template.main')
@section('title') Naziv šifrarnika @endsection

@section('content')
    <div class="container">
        <div class="card" style="width:100%;">
            <div class="card-header ads-darker">
                <button style="float:right;" onClick="window.location='{{route('unos.sifrarnika', ['type' => $type])}}';" class="btn btn-light" ><i class="fas fa-plus"></i> Nova instanca </button>
                <h4>{{$naziv_sifrarnika ?? '/'}}</h4>
            </div>
        </div>


        <table class="table table-bordered">
            <thead>
            <tr>
                <th width="40px" class="text-center">#</th>
                <th>Stavka</th>
                <th width="160px" class="text-center">Vrijednost</th>
                <th width="120px" class="text-center">Akcije</th>
            </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($sifrarnici as $sifrarnik)
                    <tr>
                        <th width="40px" class="text-center">{{$i++ ?? '/'}}</th>
                        <th>{{$sifrarnik->name ?? '/'}}</th>
                        <th width="160px" class="text-center">{{$sifrarnik->value ?? '/'}}</th>
                        <th width="120px" class="text-center">
                            <a href="{{route('obrisi.sifrarnik', ['type' => $type, 'id' => $sifrarnik->id])}}" title="Obrišite šifrarnik">
                                <i class="fas fa-times"></i>
                            </a>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
