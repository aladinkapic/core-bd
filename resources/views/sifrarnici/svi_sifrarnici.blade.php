@extends('template.main')
@section('title') {{__('Pregled svih šifrarnika')}} @endsection

@section('content')
    <div class="container container_w">
        <div class="card" style=" width:100%;">
            <div class="card-header ads-darker" style="height: 60px;">
                <h4>{{__('Pregled svih šifrarnika')}}</h4>
            </div>
        </div>

        <table class="table table-bordered" id="filtering">
            <thead>
            <tr>
                <th width="40px" class="text-center">#</th>
                <th>{{__('Naziv tabele')}}</th>
                <th width="160px" class="text-center">{{__('Broj instanci u tabeli')}}</th>
                <th width="120px" class="text-center">{{__('Akcije')}}</th>
            </tr>
            @php $i = 1; @endphp
            @foreach($kljucne_rijec as $rijec)
                <tr>
                    <td class="text-center">{{$i++ ?? '/'}}</td>
                    <td>{{$rijec[1] ?? '/'}}</td>
                    <td class="text-center">{{$rijec[2] ?? '/'}}</td>
                    <td width="120px" class="text-center">
                        <a href="{{route('dodaj.sifrarnik', ['type' => $rijec[0]])}}">
                            {{__('Pregled')}}
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