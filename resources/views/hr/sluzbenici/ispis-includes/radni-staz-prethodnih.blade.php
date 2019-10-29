<div class="single-element">
    <div class="element-header">
        <h4>Radni staž kod prethodnih poslodavaca</h4>
    </div>

    @foreach($sluzbenik->prethodnoRIRel as $iskustvo)
    <div class="all-elements">
        <div class="element-inside">
            <div class="element-label">
                <p>Poslodavac :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->poslodavac ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Sjedište poslodavca :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->sjediste_poslodavca ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Datum početka :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->datumPocetka() ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Datum završetka :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->datumZavrsetka() ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Radno vrijeme :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->radno_vrijeme_sl->name ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Opis poslova :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->opis_poslova ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Stečeno radno iskustvo :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->steceno_radno_iskustvo ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Ostvareni radni staž :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->ostvareni_radni_staz ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Staž osiguranja :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->staz_osiguranja ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Dobrovoljno osiguranje :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->dobrovoljno_osiguranje ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Penzioni staž :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->penzioni_staz ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Staž sa uvećanim trajanjem :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->staz_sa_uvecanim_trajanjem ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Država gdje je ostvaren staž u drugoj državi :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->drzava_sa_stazom ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Trajanje staža u državi :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->trajanje_staza_u_drzavi ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Napomena :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->napomena ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Radni staž - godina :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->radni_staz_godina ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Radni staž - mjeseci :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->radni_staz_mjeseci ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Radni staž - dana :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->radni_staz_dana ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Koeficijent :</p>
            </div>
            <div class="element-input">
                <p>{{ $iskustvo->koeficijent ?? '-' }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>