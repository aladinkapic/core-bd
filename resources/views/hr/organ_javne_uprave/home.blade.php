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
                <h4 >Organi javne uprave</h4>
                <button v-on:click="fireTable()" class="btn btn-primary btn-xs"> <i class="fa fa-filter" style="font-size: 11px;"></i> Filteri</button>
                @include('snippets.buttons')
            </div>
            <div class="col-md-2">
                <button class="btn btn-success" onClick="window.location='/hr/organ_javne_uprave/add';"> <i class="fa fa-plus fa-1x"></i> Novi organ javne uprave</button>
            </div>
        </div>
        <br />
        <br />
        <table id="filtering" class="table table-condensed table-bordered">
            <thead>
            <th>{{__('Naziv organa javne uprave')}}</th>
            <th>{{__('Tip organa javne uprave')}}</th>
            <th width="150">{{__('Akcije')}}</th>
            </thead>
            <tbody>
            @if (isset($uprave))
            @foreach($uprave as $uprava)
            @if($i>10)<?php break; ?> @endif
            <tr class="org-row">
                <td>{{$uprava -> naziv}}</td>
                <td>{{ \App\Models\Sifrarnik::dajInstancu('tip_javne_uprave', $uprava->tip) }}</td>
                <td class="text-center">
                    <a href="/hr/uprava/viewUprava/{{$uprava -> id}}">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a href="/hr/uprava/editUprava/{{$uprava -> id}}" style="margin-left:10px;">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="/hr/uprava/delete/{{$uprava -> id}}" style="margin-left:10px;">
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