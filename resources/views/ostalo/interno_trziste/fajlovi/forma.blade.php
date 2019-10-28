<div class="pop_forma" id="rjesenje_forma">
    <div class="forma_za_unos">
        <div class="forma_za_unos_header">
            <h4>{{__('Rješenje za')}} <span id="naziv_radnog_mjesta"></span></h4>
            <i class="fas fa-times" onclick="zatvoriteRjesenje();"></i>
        </div>

        <div class="forma_za_unos_body">
            {!! Form::textarea('naziv', "", ['class' => 'form-control', 'row' => '10', 'id' => 'rjesenje']) !!}
            <button type="submit" class="btn btn-secondary" onclick="spremiRjesenje();">
                <i class="fab fa-telegram"></i>
                {{__('Spremite')}}
            </button>
        </div>
    </div>
</div>