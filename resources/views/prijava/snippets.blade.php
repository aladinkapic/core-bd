<span v-if="sluzbenik.uloge.length">
    <span v-for="uloga in sluzbenik.uloge">
        <div class="specific_role text-left" >
            <p> Radna mjesta</p>
            <span v-if="uloga.keyword == 'radna_mjesta'">
                <input type="checkbox" v-if="uloga.vrijednost == 1" checked class="specific_role_value" keyword="radna_mjesta" v-bind:sluzbenik_id="sluzbenik.id">
                <input type="checkbox" v-else class="specific_role_value" keyword="radna_mjesta" v-bind:sluzbenik_id="sluzbenik.id">
            </span>
            <span v-else-if>
                <input type="checkbox" class="specific_role_value" keyword="radna_mjesta" v-bind:sluzbenik_id="sluzbenik.id">
            </span>
        </div>
    </span>

</span>
<span v-else>
    <div class="specific_role text-left">
        <p> Radna mjesta</p>
        <input type="checkbox" class="specific_role_value" keyword="radna_mjesta" v-bind:sluzbenik_id="sluzbenik.id">
    </div>
</span>


