<div class="single-element">
    <div class="element-header">
        <h4>Obrazovanje službenika</h4>
    </div>

    @foreach($obrazovanje_sluzbenika as $obraz)
    <div class="all-elements">
        <div class="element-inside">
            <div class="element-label">
                <p>Naziv ustanove :</p>
            </div>
            <div class="element-input">
                <p>{{ $obraz->naziv_ustanove ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Sjedište ustanove :</p>
            </div>
            <div class="element-input">
                <p>{{ $obraz->sjediste_ustanove ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Broj diplome :</p>
            </div>
            <div class="element-input">
                <p>{{ $obraz->broj_diplome ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Vrsta obrazovanja :</p>
            </div>
            <div class="element-input">
                <p>{{ $obraz->vrsta_obrazovanja ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Datum početka :</p>
            </div>
            <div class="element-input">
                <p>{{ $obraz->datum_izdavanja_dipl ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Datum završetka :</p>
            </div>
            <div class="element-input">
                <p>{{ $obraz->datum_diplomiranja ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Ciklus obrazovanja :</p>
            </div>
            <div class="element-input">
                <p>{{ $obraz->ciklus_obrazovanja ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Stručno zvanje :</p>
            </div>
            <div class="element-input">
                <p>{{ $obraz->strucno_zvanje ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Odsjek :</p>
            </div>
            <div class="element-input">
                <p>{{ $obraz->odsjek ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Broj nostrifikacije :</p>
            </div>
            <div class="element-input">
                <p>{{ $obraz->broj_nostrifikacije ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Datum završetka :</p>
            </div>
            <div class="element-input">
                <p>{{ $obraz->datum_nostrifikacije ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Rješenje izdato od :</p>
            </div>
            <div class="element-input">
                <p>{{ $obraz->rjesenje_izdato_od ?? '-' }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>