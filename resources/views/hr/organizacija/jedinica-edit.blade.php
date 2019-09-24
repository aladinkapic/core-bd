@extends('template.main')

@section('other_js_links')
    <script src="{{ asset('js/organizacija.js') }}"></script>
@stop

@section('content')


    <div class="container">



        <br />




        <div class="row">
            <div class="col-md-9">

                @include('hr.organizacija.snippets.menu')

                <div class="card">
                    <div class="card-header">
                        {{ $org_jedinica->naziv }}
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('organizaciona.jedinica.edit') }}" >
                            {{ csrf_field() }}

                            <input type="hidden" name="id" value="{{ $org_jedinica->id }}" />
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Broj</label>
                                <div class="col-sm-9">
                                    <input type="text" name="broj" value="{{ $org_jedinica->broj }}" class="form-control" placeholder="Unesite broj organizacine jedinice... npr. 2.1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Naziv</label>
                                <div class="col-sm-9">
                                    <input type="text" name="naziv" value="{{ $org_jedinica->naziv }}" class="form-control" placeholder="Unesite naziv organizacione jedinice...">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Tip</label>
                                <div class="col-sm-9">
                                    {{ Form::select('tip', $tipovi, $org_jedinica->tip, ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Nadređena organizaciona jedinica</label>
                                <div class="col-sm-9">
                                    <select name="parent" class="form-control" id="parent" v-on:change="setNoviBroj">
                                        <option value="">Glavna organizaciona jedinica</option>
                                        @foreach($org_jedinice as $jedinica)
                                            <option @if($org_jedinica->parent_id == $jedinica->id) selected="selected" @endif value="{{ $jedinica->id }}">{{ $jedinica->naziv }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Opis</label>
                                <div class="col-sm-9">
                                    <textarea name="opis" class="form-control">{{ $jedinica->opis }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <button class="btn btn-success">Spasi</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>


            </div>

            <div class="col-md-3">
                @include('hr.organizacija.snippets.sidebar')
            </div>
        </div>

    </div>

@stop