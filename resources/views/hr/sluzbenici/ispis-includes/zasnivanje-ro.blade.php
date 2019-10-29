<div class="single-element">
    <div class="element-header">
        <h4>Zasnivanje radnog odnosa</h4>
    </div>

    @foreach($sluzbenik->zasnivanjeRORel as $zasnivanje)
    <div class="all-elements">
        <div class="element-inside">
            <div class="element-label">
                <p>Datum zasnivanja radnog odnosa :</p>
            </div>
            <div class="element-input">
                <p>{{ $zasnivanje->datumZasnivanjaRO() ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Način zasnivanja:</p>
            </div>
            <div class="element-input">
                <p>{{ $zasnivanje->nacin_zasnivanja_sl->name ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Vrsta radnog odnosa :</p>
            </div>
            <div class="element-input">
                <p>{{ $zasnivanje->vrsta_radnog_sl->name ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Obračunati staž :</p>
            </div>
            <div class="element-input">
                <p>{{ $zasnivanje->obracunati_staz_sl->name ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Obračunati radni staž godina :</p>
            </div>
            <div class="element-input">
                <p>{{ $zasnivanje->obracunati_r_s_god ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Obračunati radni staž mjeseci :</p>
            </div>
            <div class="element-input">
                <p>{{ $zasnivanje->obracunati_r_s_mje ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Obračunati radni staž dana :</p>
            </div>
            <div class="element-input">
                <p>{{ $zasnivanje->obracunati_r_s_dan ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Napomena :</p>
            </div>
            <div class="element-input">
                <p>{{ $zasnivanje->napomena ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Datum donošenja sve potrebne dokumentacije :</p>
            </div>
            <div class="element-input">
                <p>{{ $zasnivanje->datumDonosenjaDokumentacije() ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Minuli radni staž :</p>
            </div>
            <div class="element-input">
                <p>{{ $zasnivanje->minuli_radni_staz ?? '-' }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>