@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        '/hr/organ_javne_uprave/home' => __('Organi javne uprave'),
    ]) !!}
@stop

@section('content')
    <?php $i=0; ?>
    <div class="container">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif
        <div class="row">
            <div class="col-md-10">
                <h4 >{{__('Organi javne uprave')}}</h4>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success" onClick="window.location='/hr/organ_javne_uprave/add';"> <i class="fa fa-plus fa-1x"></i> {{__('Novi organ javne uprave')}}</button>
            </div>
        </div>

            @include('template.snippets.filters', ['var' => $uprave])

        <table id="filtering" class="table table-condensed table-bordered">
            <thead>
            {{--<th>{{__('Naziv organa javne uprave')}}</th>--}}
            {{--<th>{{__('Tip organa javne uprave')}}</th>--}}
            @include('template.snippets.filters_header')

            <th width="150" class="text-center">{{__('Akcije')}}</th>
            </thead>
            <tbody>
            @if (isset($uprave))
                @php $counter = 1; @endphp
            @foreach($uprave as $uprava)
            <tr class="org-row">
                <td>{{$counter++}}</td>
                <td>{{$uprava -> naziv ?? '/'}}</td>
                <td>{{$uprava->tip_javne_uprave->name ?? '/'}}</td>
                <td>{{$uprava->ulica ?? '/'}}</td>
                <td>{{$uprava->broj ?? '/'}}</td>
                <td>{{$uprava->telefon ?? '/'}}</td>
                <td>{{$uprava->fax ?? '/'}}</td>
                <td>{{$uprava->web ?? '/'}}</td>
                <td class="text-center">
                    <a href="/hr/uprava/viewUprava/{{$uprava -> id ?? '1'}}">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a href="/hr/uprava/editUprava/{{$uprava -> id ?? '1'}}" style="margin-left:10px;">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="/hr/uprava/delete/{{$uprava -> id ?? '1'}}" style="margin-left:10px;">
                        <i class="fas fa-times"></i>
                    </a>
                </td>
            </tr>
                <?php $i++; ?>
                @endforeach
                @else
            <tr>
                <td colspan="4">{{__('Nema podataka')}}</td>
            </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection