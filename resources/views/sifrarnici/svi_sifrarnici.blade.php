@extends('template.main')
@section('title') Pregled svih šifrarnika @endsection
@section('other_js_links')
    <script>
        app.fireTable();
    </script>
@endsection
@section('content')
    <div class="container container_w">
        <div class="card" style=" width:100%;">
            <div class="card-header ads-darker" style="height: 60px;">
                <h4>Pregled svih šifrarnika</h4>
            </div>
        </div>

        <table class="table table-bordered" id="filtering">
            <thead>
            <tr>
                <th width="40px" class="text-center">#</th>
                <th>Naziv tabele</th>
                <th width="160px" class="text-center">Broj instanci u tabeli</th>
                <th width="120px" class="text-center">Akcije</th>
            </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($kljucne_rijec as $rijec)
                    <tr>
                        <th class="text-center">{{$i++}}</th>
                        <th>{{$rijec[1]}}</th>
                        <th class="text-center">{{$rijec[2]}}</th>
                        <th width="120px" class="text-center">
                            <a href="{{route('dodaj.sifrarnik', ['type' => $rijec[0]])}}">
                                Pregled
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
