<div class="single-element">
    <div class="element-header">
        <h4>Dodatne vještine službenika</h4>
    </div>

    @foreach($sluzbenik->vjestineRel as $vjestina)
    <div class="all-elements">
        <div class="element-inside">
            <div class="element-label">
                <p>Vrsta vještine :</p>
            </div>
            <div class="element-input">
                <p>{{ $vjestina->vrsta_vjestine_sl->name ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Nivo vještine :</p>
            </div>
            <div class="element-input">
                <p>{{ $vjestina->nivo_vjestine_sl->name ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Institucija :</p>
            </div>
            <div class="element-input">
                <p>{{ $vjestina->institucija ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Broj uvjerenja :</p>
            </div>
            <div class="element-input">
                <p>{{ $vjestina->broj_uvjerenja ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Datum uvjerenja:</p>
            </div>
            <div class="element-input">
                <p>{{ $vjestina->datumUvjerenja() ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Komentar:</p>
            </div>
            <div class="element-input">
                <p>{{ $vjestina->komentar ?? '-' }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>