<div class="single-element">
    <div class="element-header">
        <h4>Podaci o prebivalištu</h4>
    </div>

    @foreach($sluzbenik->prebivaliste as $prebivaliste)
    <div class="all-elements">
        <div class="element-inside">
            <div class="element-label">
                <p>Mjesto prebivališta :</p>
            </div>
            <div class="element-input">
                <p>{{ $prebivaliste->mjesto_prebivalista }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Adresa prebivališta :</p>
            </div>
            <div class="element-input">
                <p>{{ $prebivaliste->adresa_prebivalista }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Adresa boravišta :</p>
            </div>
            <div class="element-input">
                <p>{{ $prebivaliste->adresa_boravista }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>