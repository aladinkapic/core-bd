@extends('template.main')
@section('title') @php echo isset($radno_mjesto) ? $radno_mjesto->naziv_rm : 'Dodajte novo radno mjesto' @endphp @stop

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => __('Početna stranica'),
        route('organizacija.index') => __('Organizacioni planovi / Pravilnici'),
        route('organizacija.edit', ['id' => $organizacija->id]) => $organizacija->naziv,
        route('organizacija.radna-mjesta', ['id' => $organizacija->id]) => 'Radna mjesta',
        route('radnamjesta.pregledaj', ['id' => $rm->id]) => $rm->naziv_rm,
    ]) !!}

@stop
<!-- js  links -->
@section('other_js_links')
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                @include('hr.radna_mjesta.novo.forme.forma')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @include('hr.organizacija.snippets.sidebar')
            </div>
        </div>
    </div>
@endsection
