@extends('template.main')

@section('other_js_links')
    <script src="{{ asset('js/organizacija.js') }}"></script>
@stop

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        route('organizacija.index') => 'Unutrašnja organizacija',
        route('organizacija.edit', ['id' => $organizacija->id]) => $organizacija->naziv,
    ]) !!}

@stop

@section('content')

    <div class="container">

        <h4>{{ $organizacija->naziv }}</h4>



        <div class="row">
            <div class="col-md-9">
                @include('hr.organizacija.snippets.menu')

                @if($errors->any())
                    <div class="alert alert-danger">
                        Molimo Vas da popunite sva polja kako bi uspješno spasili organizacionu jedinicu!
                    </div>
                @endif



                <table  class="table table-condensed">
                    <thead>
                        <th>#</th>
                        <th>Naziv</th>
                        <th>Tip</th>
                        <th>Nadređena organizaciona jedinica</th>
                        <th>Akcije</th>
                    </thead>
                    <tbody>
                        @foreach($org_jedinice as $jedinica)
                            <tr class="org-row">
                                @for($i = 0; $i < strlen($jedinica->broj); $i++)
                                    @php
                                        $length = $i * 10;
                                    @endphp
                                @endfor
                                <td>
                                <form method="POST" action="{{ route('organizaciona.jedinica.delete') }}" id="delete-{{ $jedinica->id }}">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $jedinica->id }}" />
                                    <input type="hidden" name="org" value="{{ $jedinica->org_id }}" />
                                </form>
                                    <small style="color: lightblue;">{{ $jedinica->id }}</small>
                                </td>

                                <td>

                                    <a style="padding-left: {{ $length }}px;" href="{{ route('organizacija.jedinica.edit', ['id' => $jedinica->id]) }}">

                                        @if($length == 0) <b> @endif
                                              {{ $jedinica->broj }}    {{ $jedinica->naziv }}
                                        @if($length == 0) </b> @endif
                                    </a>
                                </td>
                                <td>{{ \App\Models\Sifrarnik::dajInstancu('tip_organizacione_jedinice', $jedinica->tip) ?? '/' }}</td>
                                <td>
                                    <a href="{{ route('organizacija.jedinica.edit', ['id' => $jedinica->parent_id]) }}">
                                        {{ $jedinica->parent->naziv ?? '/' }}
                                    </a>
                                </td>
                                <td>
                                    <a href="#" style="display: none;" v-on:click="confirm('#delete-{{ $jedinica->id }}')"  class="btn remove-org btn-danger btn-xs">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <br />

                <button class="btn btn-success" v-on:click="alert('#nova-org-jed')"> <i class="fa fa-plus"></i> Nova organizaciona jedinica</button>

            </div>
            <div class="col-md-3">

                @include('hr.organizacija.snippets.sidebar')

            </div>
        </div>

        <div style="display: none;" id="nova-org-jed">
            @include('hr.organizacija.snippets.nova-orgjed')
        </div>


    </div>

@stop