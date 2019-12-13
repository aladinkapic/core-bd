<div class="card">
    <div class="card-header">
        {{__('Akcije')}}
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            @if($organizacija->active == 1)
                <button class="btn btn-success"> {{__('Unutrašnja organizacija je aktivna!')}}</button>
            @else

                <form method="POST" id="set-active" action="{{ route('organizacija.active', ['id' => $organizacija->id]) }}" v-on:submit.prevent="confirmText('Jeste li sigurni da želite ovu unutrašnju organizaciju za organ javne uprave {{ $organizacija->organ->naziv }} postaviti kao aktivnu? Izmjene će biti izmijenjene trenutno!', '#set-active')" >
                    @csrf
                    <button class="btn btn-success" > <i class="fa fa-check-circle"></i>  {{__('Postavi kao aktivnu')}}</button>
                </form>
            @endif

        </li>
    </ul>
</div>
<br />

<div class="card">
    <div class="card-header">
        {{__('Broj izmjena ')}}
    </div>
    <ul class="list-group list-group-flush">
        @if(!isset($organizacija->brojIzmjena))
            <div class="single-form">
                <p>Nije bilo izmjena do sad !</p>

                <a href="{{route('organizacija.izmjena', ['id' => $organizacija->id ?? '/'])}}">
                    <div class="izmijenite-sistematizaciju">
                        Zabilježite izmjenu
                    </div>
                </a>
            </div>
        @else
            <div class="single-form">
                <p>Broj izmjena organizacije : {{ $organizacija->brojIzmjena ?? '0' }} !</p>

                @if($organizacija->brojIzmjena < 5)
                    <a href="{{route('organizacija.izmjena', ['id' => $organizacija->id ?? '/'])}}">
                        <div class="izmijenite-sistematizaciju">
                            Zabilježite izmjenu
                        </div>
                    </a>
                @endif
            </div>
        @endif
    </ul>
</div>
<br />

<div class="card">
    <div class="card-header">
        {{__('Organ javne uprave')}}
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">{{ $organizacija->organ->naziv ?? '(!) Nije postavljeno' }}</li>
    </ul>
</div>
<br />
<div class="card">
    <div class="card-header">
        {{__('Preuzmite dokument')}}
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <a target="_blank" href="/pravilnici/{{$organizacija->pravilnik}}">
                <i class="fa fa-file"></i> {{__('Preuzmi pravilnik')}}
            </a>
        </li>
    </ul>
</div>
<br />
<div class="card">
    <div class="card-header">
        {{__('Naziv organizacionog plana / Pravilnika')}}
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">{{ $organizacija->naziv }}</li>
    </ul>
</div>
<br />
<div class="card">
    <div class="card-header">
        {{__('Datum važenja od')}}
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">{{ Carbon\Carbon::parse($organizacija->datum_od)->format('d.m.Y') }}</li>
    </ul>
</div>
<br />
<div class="card">
    <div class="card-header">
        {{__('Datum važenja do')}}
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">{{ Carbon\Carbon::parse($organizacija->datum_od)->format('d.m.Y') }}</li>
    </ul>
</div>
<br />

<div class="card">
    <div class="card-header">
        {{__('Status')}}
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
                            <span class="badge {{ $organizacija->active == 1 ? "badge-success" : "badge-danger" }}">
                                {{ $organizacija->active == 1 ? "Aktivno" : "Neaktivno" }}
                            </span>
        </li>
    </ul>
</div>
<br />