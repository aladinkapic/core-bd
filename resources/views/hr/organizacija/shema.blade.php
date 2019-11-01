@extends('template.main')


@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('organizacija.index') => 'Unutrašnja organizacija',
        route('organizacija.edit', ['id' => $organizacija->id]) => $organizacija->naziv,
        route('organizacija.shema', ['id' => $organizacija->id]) => 'Organizaciona shema',
    ]) !!}

@stop
<link href="https://unpkg.com/treeflex/dist/css/treeflex.css" rel="stylesheet">
@section('content')
    <div class="container">
        @include('hr.organizacija.snippets.menu')

        <div class="fine-header">
            <h4>{{__('Organizaciona shema')}}</h4>

            <div class="buttons">
                <a href="{{route('home')}}">
                    <div class="small-button small-button-border">
                        <div class="small-button">
                            <i class="fas fa-angle-left"></i>
                        </div>
                        <p>{{__('Početna stranica')}}</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="card-body hr-activity tab full_container">
            <div class="tree-wrapper">
                <div class="zoom-buttons">
                    <div class="single-zoom-button zoom-out-it">
                        <i class="fas fa-search-minus"></i>
                    </div>
                    <div class="single-zoom-button zoom-in-it">
                        <i class="fas fa-search-plus"></i>

                    </div>
                </div>
                <div class="tree-inside-wrapper">
                    <div class="tf-tree tf-gap-lg" title="Klikom miša možete pomjerati shemu">
                        <ul>
                            <li>
                                <span class="tf-nc custom-tf-nc">
                                    <span class="tree-element tree-element-sm">
                                        {{$organizacija->naziv}}
                                    </span>
                                </span>

                                <ul>
                                    @foreach($org_jedinice as $jed)
                                        @if($jed->parent_id == null)
                                            <li>
                                                <span class="tf-nc custom-tf-nc">
                                                    <span class="tree-element tree-element-sm">
                                                        {{ $jed->naziv ?? 'Nema imena' }}
                                                    </span>
                                                </span>

                                                @if(count($jed->childs))
                                                    @include('hr.organizacija.snippets.tree-extended',['childs' => $jed->childs])
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>

    </div>

@stop