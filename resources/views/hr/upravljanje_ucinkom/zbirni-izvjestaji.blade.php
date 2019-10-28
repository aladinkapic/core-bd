@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/hr/upravljanje_ucinkom/home' => 'Upravljanje učinkom detaljno',
    ]) !!}
@stop


@section('content')
    <div class="container">

        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var'  => $jedinice])
            <table id="filtering" class="table table-condensed table-bordered">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    @include('template.snippets.filters_header')
                    <th class="akcije text-center" width="120px">{{__('Akcija')}}</th>
                </tr>
                </thead>
                <tbody>
                @php $counter=1; @endphp
                @foreach($jedinice as $jedinica)
                    <tr>
                        <td>{{$counter++}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center">
                            <a href="#">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
{{--                @foreach($ucinci as $ucinak)--}}
{{--                    <tr>--}}
{{--                        <td class="text-center">{{$i++}}</td>--}}
{{--                        <td>--}}
{{--                            <a href="{{route('sluzbenik.dodatno', ['id' => $ucinak -> usluzbenik->id ?? '1'])}}">--}}
{{--                                {{$ucinak -> usluzbenik->ime_prezime ?? ''}}--}}
{{--                            </a>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <a href="{{route('radnamjesta.pregledaj', ['id' => $ucinak -> mjesto->rm->id ?? '1'])}}">--}}
{{--                                {{ $ucinak -> mjesto->rm->naziv_rm ?? '/' }}--}}
{{--                            </a>--}}
{{--                        </td>--}}
{{--                        <td>{{$ucinak -> kategorija_ocjene->name ?? '/'}}</td>--}}
{{--                        <td>{{$ucinak -> godina ?? '/'}}</td>--}}
{{--                        <td>{{$ucinak -> ocjena ?? '/'}}</td>--}}
{{--                        <td>{{$ucinak -> opisna_ocjena ?? '/'}}</td>--}}
{{--                        <td class="text-center">--}}
{{--                            <a href="/hr/upravljanje_ucinkom/viewUcinak/{{$ucinak -> id ?? '1'}}">--}}
{{--                                <i class="fa fa-eye"></i>--}}
{{--                            </a>--}}
{{--                            <a href="/hr/upravljanje_ucinkom/editUcinak/{{$ucinak -> id ?? '1'}}" style="margin-left:10px;">--}}
{{--                                <i class="fas fa-edit"></i>--}}
{{--                            </a>--}}
{{--                            <a href="/hr/upravljanje_ucinkom/delete/{{$ucinak -> id ?? '1'}}" style="margin-left:10px;">--}}
{{--                                <i class="fas fa-times"></i>--}}
{{--                            </a>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
                </tbody>
            </table>
        </div>
    </div>
@endsection