@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('obavijesti') => 'Pregled obavijesti',
    ]) !!}

@stop

@section('content')
    <div class="container">
        <div class="fine-header">
            <h4>{{__('Pregled obavijesti')}}</h4>

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
            @include('template.snippets.filters', ['var' => $obavijesti])
            <table class="table table-bordered" id="filtering">
                <thead>
                <tr>
                    <th scope="col" style="text-align:center;">#</th>
                    @include('template.snippets.filters_header')
                </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @foreach($obavijesti as $obavijest)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$obavijest->toWho->ime_prezime ?? '/'}}</td>
                            <td>{{$obavijest->message ?? '/'}}</td>
                            <td>{{$obavijest->readAt() ?? '/'}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection