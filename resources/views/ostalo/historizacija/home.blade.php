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
                <th class="text-center">#</th>
                @include('template.snippets.filters_header')
                <th width="100">{{__('Akcije')}}</th>
            </tr>
            </thead>
            <tbody>
            @php $i=1; @endphp
            @if (isset($logs))
                @foreach($logs as $log)
                    <tr class="org-row">
                        <td class="text-center">{{$i++}}</td>
                        <td>{{$log -> sluzbenik->ime_prezime ?? '/'}}</td>
                        <td>{{$log -> modul ?? '/'}}</td>
                        <td>{{$log-> operation ?? '/'}}</td>
                        <td>{{$log->created_at ?? '/'}}</td>
                        <td class="text-center">
                            <a href="/ostalo/historizacija/detalji/{{$log -> id ?? '1'}}">
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