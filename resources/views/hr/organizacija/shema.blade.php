@extends('template.main')


@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('organizacija.index') => 'Unutrašnja organizacija',
        route('organizacija.edit', ['id' => $organizacija->id]) => $organizacija->naziv,
        route('organizacija.shema', ['id' => $organizacija->id]) => 'Organizaciona shema',
    ]) !!}

@stop

@section('other_js_links')

    <script src="{{ asset('js/organizacija.js') }}"></script>

    <script>

        /*
            Radna mjesta

        var chart = new OrgChart(document.getElementById("orgchart"), {
            template: "ula",
            showXScroll: BALKANGraph.scroll.visible,
            mouseScrool: BALKANGraph.action.xScroll,
            layout: BALKANGraph.mixed,
            scaleInitial: 0.5,
            /*nodeMouseClick: function(){
                return false;
            },
            nodeBinding: {
                field_0: "Naziv",
                field_1: "Sluzbenik"
            },
            tags: {

            },
            nodes: [

            ]
        });

        /*
            Organizacione jedinice
         */

        var chart = new OrgChart(document.getElementById("orgchart"), {
            template: "core",
            showXScroll: BALKANGraph.scroll.visible,
            mouseScrool: BALKANGraph.action.xScroll,
            layout: OrgChart.treeRightOffset,
            scaleInitial: 0.7,

            nodeBinding: {
                field_0: "Naziv",
            },

            menu: {
                pdf: { text: "Izvoz u PDF" },
                png: { text: "Izvoz u PNG" },
            },

            nodes: [
                @foreach($org_jedinice as $jedinica)
                     { id: {{ $jedinica->id }}, @if($jedinica->parent_id) pid: {{ $jedinica->parent_id }},@endif Naziv: "{{ $jedinica->broj }} {{ $jedinica->naziv }}" },
                @endforeach
            ]
    });

</script>

@stop

@section('content')

    <style>
        .shape_content {
            background: whitesmoke;
            width: 100% !important;
        }
        foreignObject {
            width: 10% !important;
        }
        rect {
            width:10% !important;
        }
        svg {
            width: 100% !important;
        }
    </style>

    <div class="container">

        <h4>{{__('Organizaciona shema')}}</h4>

        <br />

        <div class="row">
            <div class="col-md-9">
                @include('hr.organizacija.snippets.menu')
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-expand" style="float: right; cursor: pointer;" v-on:click="expand()"></i>
                        {{__('Prikaz organizacione sheme')}}
                    </div>
                    <div class="card-body" style="padding: 0px;">
                        <div style="width:100%; height:700px;" id="orgchart"/>
                    </div>
                </div>
            </div>
            </div>

            <div class="col-md-3">

                @include('hr.organizacija.snippets.sidebar')
            </div>
        </div>

    </div>

@stop