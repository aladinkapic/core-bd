<div class="single-element">
    <div class="element-header">
        <h4>Kontakt informacije</h4>
    </div>

    @foreach($sluzbenik->kontaktDetalji as $kontakt)
    <div class="all-elements">
        <div class="element-inside">
            <div class="element-label">
                <p>Službeni telefon :</p>
            </div>
            <div class="element-input">
                <p>{{ $kontakt->sluzbeni_tel ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Službeni email :</p>
            </div>
            <div class="element-input">
                <p>{{ $kontakt->sluzbeni_mail ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Privatni telefon :</p>
            </div>
            <div class="element-input">
                <p>{{ $kontakt->mobilni_tel ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Privatni email :</p>
            </div>
            <div class="element-input">
                <p>{{ $kontakt->email ?? '-' }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>