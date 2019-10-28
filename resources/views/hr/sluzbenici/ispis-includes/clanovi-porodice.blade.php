<div class="single-element">
    <div class="element-header">
        <h4>Članovi porodice</h4>
    </div>

    @foreach($sluzbenik->clanoviPorodiceRel as $porodica)
    <div class="all-elements">
        <div class="element-inside">
            <div class="element-label">
                <p>Datum rođenja :</p>
            </div>
            <div class="element-input">
                <p>{{ $porodica->datumRodjenja() ?? '-'}}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Srodstvo :</p>
            </div>
            <div class="element-input">
                <p>{{ $porodica->srodstvo_sl->name ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Napomena :</p>
            </div>
            <div class="element-input">
                <p>{{ $porodica->napomena ?? '-' }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>