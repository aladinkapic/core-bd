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

        <h4>{{__('Organizaciona shema')}}</h4>

        <br />

        @include('hr.organizacija.snippets.menu')

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
                                <span class="tree-element">
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
{{--                    <ul class="first-div">--}}
{{--                        <li>--}}
{{--                            <span class="tf-nc">1</span>--}}
{{--                            <ul>--}}
{{--                                <li>--}}
{{--                                    <span class="tf-nc">2</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><span class="tf-nc">4</span></li>--}}
{{--                                        <li>--}}
{{--                                            <span class="tf-nc">5</span>--}}
{{--                                            <ul>--}}
{{--                                                <li><span class="tf-nc">9</span></li>--}}
{{--                                                <li><span class="tf-nc">10</span></li>--}}
{{--                                            </ul>--}}
{{--                                        </li>--}}
{{--                                        <li><span class="tf-nc">6</span></li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                                <li>--}}
{{--                                    <span class="tf-nc">3</span>--}}
{{--                                    <ul>--}}
{{--                                        <li><span class="tf-nc">7</span></li>--}}
{{--                                        <li><span class="tf-nc">8</span></li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
                </div>
            </div>
        </div>

    </div>

@stop