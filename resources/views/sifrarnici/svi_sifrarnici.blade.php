@extends('template.main')
@section('title') Pregled svih šifrarnika @endsection

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
                <td width="40px" class="text-center">#</td>
                <td>Naziv tabele</td>
                <td width="160px" class="text-center">Broj instanci u tabeli</td>
                <td width="120px" class="text-center">Akcije</td>
            </tr>
            @php $i = 1; @endphp
            @foreach($kljucne_rijec as $rijec)
                <tr>
                    <td class="text-center">{{$i++ ?? '/'}}</td>
                    <td>{{$rijec[1] ?? '/'}}</td>
                    <td class="text-center">{{$rijec[2] ?? '/'}}</td>
                    <td width="120px" class="text-center">
                        <a href="{{route('dodaj.sifrarnik', ['type' => $rijec[0]])}}">
                            Pregled
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
@endsection
{{--@section('other_js_links')--}}
    {{--<script>--}}
        {{--app.fireTable();--}}
    {{--</script>--}}
{{--@endsection--}}