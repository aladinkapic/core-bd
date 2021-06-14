<div class="card">
    <div class="card-header">
        {{__('Akcije')}}
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            @if($organizacija->active == 1)
                <button class="btn btn-success" style="width: 100%;"> {{__('Unutrašnja organizacija je aktivna!')}}</button>
            @else

                <form method="POST" id="set-active" action="{{ route('organizacija.active', ['id' => $organizacija->id]) }}" v-on:submit.prevent="confirmText('Jeste li sigurni da želite ovu unutrašnju organizaciju za organ javne uprave {{ $organizacija->organ->naziv }} postaviti kao aktivnu? Izmjene će biti izmijenjene trenutno!', '#set-active')" >
                    @csrf
                    <button class="btn btn-success"  style="width: 100%;"> <i class="fa fa-check-circle"></i>  {{__('Postavi kao aktivnu')}}</button>
                </form>
            @endif

        </li>
    </ul>
</div>
<br />

<div class="card">
    <div class="card-header">
        {{__('Broj izmjena')}}
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
                <p>Organizacioni plan / Pravilnik je do sad izmijenjen {{ $organizacija->brojIzmjena ?? '0' }} puta!</p>

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
        {{__('Naziv organizacionog plana / Pravilnika')}}
    </div>
    <ul class="list-group list-group-flush">
        @foreach($organizacija->fajlovi as $fajl)
            <li class="list-group-item">
                <a target="_blank" href="/pravilnici/{{$fajl->hash ?? '/'}}">
                    <i class="fa fa-file"></i> {{$fajl->naziv_dokumenta ?? '/'}}
                </a>
            </li>
        @endforeach
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
        <li class="list-group-item">{{ Carbon\Carbon::parse($organizacija->datum_do)->format('d.m.Y') }}</li>
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

<div class="card">
    <div class="card-header">
        {{__('Akcije')}}
    </div>
    <ul class="list-group list-group-flush">
        <a href="{{route('organizacija.izmjene-sistematizacije', ['id' => $organizacija->id ?? '/'])}}">
            <li class="list-group-item" style="width: 100%;">
                <button class="btn btn-success" style="width: 100%;"> {{__('Pregled')}}</button>
            </li>
        </a>
    </ul>
</div>
<br />
