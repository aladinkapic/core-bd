@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        '/hr/organ_javne_uprave/home' => __('Organ javne uprave'),
    ]) !!}
@stop

@section('content')
    <div class="container">
        <div class="fine-header">
            <h4>{{__('Organi javne uprave')}}</h4>

            <div class="buttons">
                <a href="{{route('home')}}" title="Nazad">
                    <div class="small-button small-button-border small-button-edit">
                        <i class="fas fa-angle-left"></i>
                    </div>
                </a>
                <a href="{{route('novi-organ-javne-uprave')}}">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-plus-square"></i>
                        </div>
                        <p>{{__('Novi organ javne uprave')}}</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="card-body hr-activity tab full_container">
            @include('template.snippets.filters', ['var' => $uprave])

            <table id="filtering" class="table table-condensed table-bordered">
                <thead>
                <th class="text-center">#</th>
                @include('template.snippets.filters_header')

                <th width="150" class="text-center">{{__('Akcije')}}</th>
                </thead>
                <tbody>
                @php $counter = 1; @endphp
                @foreach($uprave as $uprava)
                    <tr class="org-row">
                        <td class="text-center">{{$counter++}}</td>
                        <td>{{$uprava -> naziv ?? '/'}}</td>
                        <td>{{$uprava -> kod ?? '/'}}</td>
                        <td>{{$uprava->tip_javne_uprave->name ?? '/'}}</td>
                        <td>{{$uprava->ulica ?? '/'}}</td>
                        <td>{{$uprava->broj ?? '/'}}</td>
                        <td>{{$uprava->telefon ?? '/'}}</td>
                        <td>{{$uprava->fax ?? '/'}}</td>
                        <td>{{$uprava->web ?? '/'}}</td>
                        <td class="text-center">
                            <a href="/hr/uprava/viewUprava/{{$uprava -> id ?? '1'}}">
                                <button class="btn my-button">Pregled</button>
                            </a>
{{--                            <a href="/hr/uprava/editUprava/{{$uprava -> id ?? '1'}}" style="margin-left:10px;">--}}
{{--                                <i class="fas fa-edit"></i>--}}
{{--                            </a>--}}
{{--                            <a href="/hr/uprava/delete/{{$uprava -> id ?? '1'}}" style="margin-left:10px;">--}}
{{--                                <i class="fas fa-times"></i>--}}
{{--                            </a>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
