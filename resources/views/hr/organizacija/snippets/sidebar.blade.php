<div class="card">
    <div class="card-header">
        Akcije
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            @if($organizacija->active == 1)
                <button class="btn btn-success"> Unutrašnja organizacija je aktivna!</button>
            @else

                <form method="POST" id="set-active" action="{{ route('organizacija.active', ['id' => $organizacija->id]) }}" v-on:submit.prevent="confirmText('Jeste li sigurni da želite ovu unutrašnju organizaciju za organ javne uprave {{ $organizacija->organ->naziv }} postaviti kao aktivnu? Izmjene će biti izmijenjene trenutno!', '#set-active')" >
                    @csrf
                    <button class="btn btn-success" > <i class="fa fa-check-circle"></i>  Postavi kao aktivnu</button>
                </form>
            @endif

        </li>
    </ul>
</div>
<br />
<div class="card">
    <div class="card-header">
        Organ javne uprave
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">{{ $organizacija->organ->naziv ?? '(!) Nije postavljeno' }}</li>
    </ul>
</div>
<br />
<div class="card">
    <div class="card-header">
        Pravilnik
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <a target="_blank" href="/pravilnici/{{$organizacija->pravilnik}}">
                <i class="fa fa-file"></i> Preuzmi pravilnik
            </a>
        </li>
    </ul>
</div>
<br />
<div class="card">
    <div class="card-header">
        Naziv organizacionog plana
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">{{ $organizacija->naziv }}</li>
    </ul>
</div>
<br />
<div class="card">
    <div class="card-header">
        Datum važenja od
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">{{ Carbon\Carbon::parse($organizacija->datum_od)->format('d.m.Y') }}</li>
    </ul>
</div>
<br />
<div class="card">
    <div class="card-header">
        Datum važenja do
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">{{ Carbon\Carbon::parse($organizacija->datum_od)->format('d.m.Y') }}</li>
    </ul>
</div>
<br />

<div class="card">
    <div class="card-header">
        Status
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