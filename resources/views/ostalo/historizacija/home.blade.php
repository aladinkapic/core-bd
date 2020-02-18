@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        '/ostalo/historizacija/home' => __('Historija izmjena'),
    ]) !!}
@stop

@section('content')
    <div class="container">
        <div class="fine-header">
            <h4>{{__('Historija izmjena')}}</h4>

            <div class="buttons">
                <a href="{{route('home')}}">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-angle-left"></i>
                        </div>
                        <p>{{__('Nazad')}}</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var'  => $logs])
            <table id="filtering" class="table table-condensed table-bordered">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    @include('template.snippets.filters_header')
                    <th width="120" class="text-center">{{__('Akcije')}}</th>
                </tr>
                </thead>
                <tbody>
                @php $i=1; @endphp
                @foreach($logs as $log)
                    <tr class="org-row">
                        <td class="text-center">{{$i++}}</td>
                        <td>{{$log -> sluzbenik->ime_prezime ?? '/'}}</td>
                        <td>{{$log -> modul ?? '/'}}</td>
                        <td>{{$log-> operation ?? '/'}}</td>
                        <td>{{$log->created_at ?? '/'}}</td>
                        <td class="text-center">
                            <a href="/ostalo/historizacija/detalji/{{$log -> id ?? '1'}}">
                                <button class="btn my-button">{{__('Pregled')}}</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
