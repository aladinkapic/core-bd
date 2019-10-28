<div class="single-element">
    <div class="element-header">
        <h4>Položeni ispiti</h4>
    </div>

    @foreach($sluzbenik->ispitiRel as $ispit)
    <div class="all-elements">
        <div class="element-inside">
            <div class="element-label">
                <p>Kategorija ispita :</p>
            </div>
            <div class="element-input">
                <p>{{ $kategorija_ispita ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Naziv ispita :</p>
            </div>
            <div class="element-input">
                <p>{{ $ispit->naziv_ovog_ispita ?? '-'}}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Ispit za rad u organima javne uprave :</p>
            </div>
            <div class="element-input">
                <p>{{ $ispit->ispit_za_rad ?? '-'}}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Pravosudni ispit :</p>
            </div>
            <div class="element-input">
                <p>{{ $ispit->pravosudni_isp ?? '-'}}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Stručni ispit :</p>
            </div>
            <div class="element-input">
                <p>{{ $ispit->strucni_isp ?? '-'}}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Nostrifikacija :</p>
            </div>
            <div class="element-input">
                <p>{{ $ispit->nostrifikacija ?? '-'}}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Datum završetka :</p>
            </div>
            <div class="element-input">
                <p>{{ $ispit->datum_zavrsetka ?? '-'}}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>