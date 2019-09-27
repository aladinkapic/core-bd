@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/ostalo/historizacija/home' => 'Historija izmjena',
    ]) !!}
@stop

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h3>{{__('Historija izmjena')}}</h3>
            </div>
        </div>
        <br/>
        <br/>
        @include('template.snippets.filters', ['var'  => $logs])

        <table id="filtering" class="table table-condensed table-bordered">
            <thead>
            <tr>
                @include('template.snippets.filters_header')
                <th width="100">{{__('Akcije')}}</th>
            </tr>
            </thead>
            <tbody>
            @if (isset($logs))
                @foreach($logs as $log)
<!--                    --><?php
//                    $model = null;
//                    for ($i = strlen($log->operation); $i > 0; $i--) {
//                        if ($log->operation[$i - 1] === '\\') break;
//                        $model .= $log->operation[$i - 1];
//                    }
//                    $model = implode(array_reverse(str_split($model)));
//                    ?>

<!--                    --><?php
//                    $operacija = null;
//                    if ($log->old_data == $log->new_data)
//                        $operacija = __('Brisanje');
//                    else if ($log->old_data == "[]")
//                        $operacija = __('Spremanje');
//                    else $operacija = __('Uređivanje');
//
//                    ?>

                    <tr class="org-row">
                        <td>{{$log -> sluzbenik->ime_prezime}}</td>
                        <td>{{$log -> modul }}</td>
                        <td>{{$log-> operation }}</td>
                        <td>{{$log->created_at}}</td>
                        <td class="text-center">
                            <a href="/ostalo/historizacija/detalji/{{$log -> id}}">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">{{__('Nema Podataka!')}}</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection