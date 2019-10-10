@extends('template.main')

@section('other_js_links')
    <script src="{{ asset('js/organizacija.js') }}"></script>
    <script>

            // app.hidden_columns = [2,3];
            // app.mountHidden();
    </script>
@stop


@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('organizacija.index') => 'Unutrašnja organizacija',
    ]) !!}

@stop

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-md-10">
                <h4>{{__('Unutrašnja organizacija')}}</h4>
            </div>
            <div class="col-md-2">
                <button class="btn  btn-success" v-on:click="url('{{ route('organizacija.create') }}')"> <i class="fa fa-plus fa-1x"></i>{{__(' Novi organizacioni plan')}}</button>
            </div>
        </div>

        @include('template.snippets.filters', ['var' => $organizacija])

        <table id="filtering" class="table table-condensed table-bordered">
            <thead>
            <th class="text-center">#</th>
                @include('template.snippets.filters_header')
                <th width="150">Akcije</th>
            </thead>
            <tbody>
            @php $i=1; @endphp
            @foreach($organizacija as $org)
                <tr class="org-row">
                    <td class="text-center">{{ $i++ }}</td>
                    <td>{{ $org->naziv }}</td>
                    <td>{{ $org->organ->naziv ?? 'NE POSTOJI!' }}</td>
                    <td>{{ \App\Http\Controllers\HelpController::obrniDatum($org->datum_od) }}</td>
                    <td>{{ \App\Http\Controllers\HelpController::obrniDatum($org->datum_do) }}</td>
                    <td>
                        <span class="badge badge-{{ ($org->active == 0) ? 'danger':'success' }}">{{$org->aktivan->name}}</span>
                    </td>
                    <td>
                        <a class="btn btn-primary btn-xs" href="/organizacija/edit/{{ $org->id}}">
                            <i class="fa fa-pen"></i> Izmjena
                        </a>

                         <form style="display: inline-block;" method="POST" action="/organizacija/destroy/{{ $org->id  }}">
                            {{ method_field('DELETE') }}
                            @csrf
                            <button style="display: none;" class="btn btn-danger btn-xs remove-org">
                                <i class="fa fa-times"></i>
                            </button>
                        </form>

                    </td>
                </tr>
                    @endforeach

            </tbody>

        </table>




    </div>

@stop