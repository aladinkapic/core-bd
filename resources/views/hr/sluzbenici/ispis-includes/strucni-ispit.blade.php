<div class="single-element">
    <div class="element-header">
        <h4>Podaci o stručnoj spremi</h4>
    </div>

    @foreach($sluzbenik->strucnaSprema as $strucna)
    <div class="all-elements">
        <div class="element-inside">
            <div class="element-label">
                <p>Stepen stručne spreme :</p>
            </div>
            <div class="element-input">
                <p>{{ $strucna->stepen_s_s ?? '-'}}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Vrsta stručne spreme :</p>
            </div>
            <div class="element-input">
                <p>{{ $strucna->vrsta_s_s ?? '-'}}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Komentar o diplomi :</p>
            </div>
            <div class="element-input">
                <p>{{ $strucna->komenta_o_diplomi ?? '-'}}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Datum završetka :</p>
            </div>
            <div class="element-input">
{{--                <p>{{ $strucna->datumZavršetka() ?? '-'}}</p>--}}
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Obrazovna institucija :</p>
            </div>
            <div class="element-input">
                <p>{{ $strucna->obrazovna_institucija ?? '-'}}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Nostrifikacija :</p>
            </div>
            <div class="element-input">
                <p>{{ $strucna->nostrifikacija ?? '-'}}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Diploma poslana na provjeru :</p>
            </div>
            <div class="element-input">
                <p>
                    @if($strucna->diploma_poslana_na_provjeru == '1')
                        DA
                    @else
                        NE
                    @endif
                </p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Diploma vraćena sa provjere :</p>
            </div>
            <div class="element-input">
                <p>
                    @if($strucna->diploma_vracena_sa_provjere == '1')
                        DA
                    @else
                        NE
                    @endif
                </p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Broj obavještenja :</p>
            </div>
            <div class="element-input">
                <p>{{ $strucna->broj_obavijestenja_provjere ?? '-'}}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Datum zaprimanja diplome nazad :</p>
            </div>
            <div class="element-input">
{{--                <p>{{ $strucna->datumZaprimanja() ?? '-'}}</p>--}}
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Datum dostavljanja diplome :</p>
            </div>
            <div class="element-input">
{{--                <p>{{ $strucna->datumDostavljanja() ?? '-'}}</p>--}}
            </div>
        </div>
    </div>
    @endforeach
</div>