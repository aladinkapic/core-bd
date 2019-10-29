<div class="single-element">
    <div class="element-header">
        <h4>Prestanak radnog odnosa</h4>
    </div>

    @foreach($sluzbenik->prestanakRORel as $prestanak)
    <div class="all-elements">
        <div class="element-inside">
            <div class="element-label">
                <p>Datum prestanka :</p>
            </div>
            <div class="element-input">
                <p>{{ $prestanak->datumPrestanka() ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Osnov za prestanak :</p>
            </div>
            <div class="element-input">
                <p>{{ $prestanak->osnov_za_prestanak_sl->name ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Napomena :</p>
            </div>
            <div class="element-input">
                <p>{{ $prestanak->napomena ?? '-' }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>