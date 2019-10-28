<div class="single-element">
    <div class="element-header">
        <h4>Karton službenika</h4>
    </div>

    <div class="all-elements">
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
                <p>Korisničko ime :</p>
            </div>
            <div class="element-input">
                <p>{{$sluzbenik->korisnicko_ime ?? '-'}}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Email :</p>
            </div>
            <div class="element-input">
                <p>{{ $sluzbenik->email ?? '-' }}</p>
            </div>
        </div>

        <div class="element-inside">
            <div class="element-label">
                <p>JMBG :</p>
            </div>
            <div class="element-input">
                <p>{{ $sluzbenik->jmbg ?? '/'}}</p>
            </div>
        </div>

        <div class="element-inside">
            <div class="element-label">
                <p>Ime roditelja :</p>
            </div>
            <div class="element-input">
                <p>{{ $sluzbenik->ime_roditelja ?? '-'}}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Spol :</p>
            </div>
            <div class="element-input">
                <p>{{$sluzbenik->spol_sl->name ?? '-'}}</p>
            </div>
        </div>

        <div class="element-inside">
            <div class="element-label">
                <p>Kategorija :</p>
            </div>
            <div class="element-input">
                <p>{{ $sluzbenik->kategorija_sl->name ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Državljanstvo 1 :</p>
            </div>
            <div class="element-input">
                <p>{{$sluzbenik->drzavljanstvo_1 ?? '-'}}</p>
            </div>
        </div>

        <div class="element-inside">
            <div class="element-label">
                <p>Državljanstvo 2 :</p>
            </div>
            <div class="element-input">
                <p>{{$sluzbenik->drzavljanstvo_2 ?? '-'}}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Nacionalnost :</p>
            </div>
            <div class="element-input">
                <p>{{ $sluzbenik->nacionalnost_sl->name ?? '-' }}</p>
            </div>
        </div>

        <div class="element-inside">
            <div class="element-label">
                <p>Bračni status :</p>
            </div>
            <div class="element-input">
                <p>{{ $sluzbenik->bracni_status_sl->name ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Mjesto rođenja :</p>
            </div>
            <div class="element-input">
                <p>{{$sluzbenik->mjesto_rodjenja ?? '-'}}</p>
            </div>
        </div>

        <div class="element-inside">
            <div class="element-label">
                <p>Datum rođenja :</p>
            </div>
            <div class="element-input">
                <p>{{$sluzbenik->datumRodjenja() ?? '-'}}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Lična karta :</p>
            </div>
            <div class="element-input">
                <p>{{$sluzbenik->licna_karta ?? '-'}}</p>
            </div>
        </div>

        <div class="element-inside">
            <div class="element-label">
                <p>Mjesto izdavanja LK :</p>
            </div>
            <div class="element-input">
                <p>{{ $sluzbenik->mjesto_izdavanja_lk ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>PIO :</p>
            </div>
            <div class="element-input">
                <p>{{ $sluzbenik->PIO ?? '-' }}</p>
            </div>
        </div>

        <div class="element-inside">
            <div class="element-label">
                <p>Trenutno zaposlen :</p>
            </div>
            <div class="element-input">
                <p>{{ $sluzbenik->trenutno_zaposlen_sl->name ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Organ javne uprave :</p>
            </div>
            <div class="element-input">
                <p>{{ $organ_ju }}</p>
            </div>
        </div>

        <div class="element-inside">
            <div class="element-label">
                <p>Organizaciona jedinica :</p>
            </div>
            <div class="element-input">
                <p>{{ $organizaciona_jed->naziv ?? '-'}}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Radno mjesto :</p>
            </div>
            <div class="element-input">
                <p>{{ $radno_mjesto ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside">
            <div class="element-label">
                <p>Privremeni premještaj :</p>
            </div>
            <div class="element-input">
                <p>{{ $sluzbenik->privremeni_premjestaj ?? '-' }}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Radni staž - godina :</p>
            </div>
            <div class="element-input">
                <p>{{ $godina }}</p>
            </div>
        </div>

        <div class="element-inside">
            <div class="element-label">
                <p>Radni staž - mjeseci :</p>
            </div>
            <div class="element-input">
                <p>{{ $mjeseci ?? '-'}}</p>
            </div>
        </div>
        <div class="element-inside element-inside-2">
            <div class="element-label">
                <p>Radni staž - dana :</p>
            </div>
            <div class="element-input">
                <p>{{ $dana ?? '-'}}</p>
            </div>
        </div>
    </div>
</div>