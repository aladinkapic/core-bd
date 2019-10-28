<div class="single-element">
    <div class="element-header">
        <h4>Karton službenika</h4>
    </div>
    <div class="element-inside">
        <div class="element-label">
            <p>Ime</p>
        </div>
        <div class="element-input">
            <p>{{$sluzbenik->ime ?? '-'}}</p>
        </div>
    </div>
    <div class="element-inside element-inside-2">
        <div class="element-label">
            <p>Prezime</p>
        </div>
        <div class="element-input">
            <p>{{$sluzbenik->prezime ?? '-'}}</p>
        </div>
    </div>

    <div class="element-inside">
        <div class="element-label">
            <p>JMBG :</p>
        </div>
        <div class="element-input">
            <p>{{$sluzbenik->jmbg ?? '-'}}</p>
        </div>
    </div>
    <div class="element-inside element-inside-2">
        <div class="element-label">
            <p>Djevojačko prezime :</p>
        </div>
        <div class="element-input">
            <p>
                {{--@if($sluzbenik->djevojacko_prezime != '')--}}
                    {{--{{$sluzbenik->djevojacko_prezime ?? '-'}}--}}
                {{--@else--}}
                    {{-----}}
                {{--@endif--}}
            </p>
        </div>
    </div>

    <div class="element-inside">
        <div class="element-label">
            <p>Ime roditelja :</p>
        </div>
        <div class="element-input">
            <p></p>
        </div>
    </div>

    <div class="element-inside">
        <div class="element-label">
            <p>Pol :</p>
        </div>
        <div class="element-input">
            <p>{{$sluzbenik->spolRel->name ?? '-'}}</p>
        </div>
    </div>
    <div class="element-inside element-inside-2">
        <div class="element-label">
            <p>Kategorija :</p>
        </div>
        <div class="element-input">
            <p>{{$sluzbenik->kategorija_prip->name ?? '-'}}</p>
        </div>
    </div>

    <div class="element-inside">
        <div class="element-label">
            <p>Prvo državljanstvo :</p>
        </div>
        <div class="element-input">
            <p></p>
        </div>
    </div>
    <div class="element-inside element-inside-2">
        <div class="element-label">
            <p>Drugo državljanstvo :</p>
        </div>
        <div class="element-input">
            <p>{{$sluzbenik->drzavljanstvo_drugo ?? '-'}}</p>
        </div>
    </div>

    <div class="element-inside">
        <div class="element-label">
            <p>Nacionalnost :</p>
        </div>
        <div class="element-input">
            <p>{{$sluzbenik->nacionalnostRel->name ?? '-'}}</p>
        </div>
    </div>
    <div class="element-inside element-inside-2">
        <div class="element-label">
            <p>Datum rođenja :</p>
        </div>
        <div class="element-input">
            <p></p>
        </div>
    </div>

    <div class="element-inside">
        <div class="element-label">
            <p>Mjesto rođenja :</p>
        </div>
        <div class="element-input">
            <p></p>
        </div>
    </div>
    <div class="element-inside element-inside-2">
        <div class="element-label">
            <p>Opština rođenja :</p>
        </div>
        <div class="element-input">
            <p>{{$sluzbenik->opstinaRodjenja->naziv ?? '-'}}</p>
        </div>
    </div>

    <div class="element-inside">
        <div class="element-label">
            <p>Opština rođenja - inostranstvo :</p>
        </div>
        <div class="element-input">
            <p>{{$sluzbenik->opcina_rodjenja_inostranstvo ?? '-'}}</p>
        </div>
    </div>
    <div class="element-inside element-inside-2">
        <div class="element-label">
            <p>Država rođenja :</p>
        </div>
        <div class="element-input">
            <p>{{$sluzbenik->drzavaRodjenja->name ?? '-'}}</p>
        </div>
    </div>

    <div class="element-inside">
        <div class="element-label">
            <p>Bračni status :</p>
        </div>
        <div class="element-input">
            <p></p>
        </div>
    </div>
    <div class="element-inside element-inside-2">
        <div class="element-label">
            <p>Broj lične karte :</p>
        </div>
        <div class="element-input">
            <p></p>
        </div>
    </div>

    <div class="element-inside">
        <div class="element-label">
            <p>Mjesto izdavanja lične karte :</p>
        </div>
        <div class="element-input">
            <p></p>
        </div>
    </div>
    <div class="element-inside element-inside-2">
        <div class="element-label">
            <p>Broj pasoša :</p>
        </div>
        <div class="element-input">
            <p></p>
        </div>
    </div>

    <div class="element-inside">
        <div class="element-label">
            <p>Status :</p>
        </div>
        <div class="element-input">
            <p>{{$sluzbenik->statusDZ->name ?? '-'}}</p>
        </div>
    </div>
    <div class="element-inside element-inside-2">
        <div class="element-label">
            <p>Operator :</p>
        </div>
        <div class="element-input">
            <p>{{$sluzbenik->operator ?? 'Root admin'}}</p>
        </div>
    </div>
</div>