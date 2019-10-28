<div class="col-sm-3">
    <div class="box-body in">
        <h4 id="filteri-naslov" class="box" onClick="$('#filter-body').slideToggle();">
            <i class="fa fa-arrow-down float-right"></i>
            <i class="fa fa-filter" aria-hidden="true"></i>
            {{__('Filteri')}}
        </h4>
        <div id="filter-body">
            <ul style="list-style: none;">
                <li><input onClick="$('#ime').slideToggle();" type="checkbox" /> {{__('Ime i prezime')}}</li>
                <li><input onClick="$('#pozicija').slideToggle();" type="checkbox" /> {{__('Pozicija')}}</li>
                <li><input onClick="$('#spol').slideToggle();" type="checkbox" /> {{__('Spol')}}</li>
                <li><input onClick="$('#nacionalnost').slideToggle();" type="checkbox" /> {{__('Nacionalnost')}}</li>
                <li><input onClick="$('#mjesto').slideToggle();" type="checkbox" /> {{__('Mjesto rođenja')}}</li>
            </ul>
        </div>
    </div>
    <hr/>
    <div class="box box-panel" id="ime">
        <div class="box-head">
            <a href="javascript:;">
                {{__('Ime i prezime')}}
            </a>
        </div>
        <div class="box-body in">
            <input type="text" class="form-control" id="validationDefault01"  placeholder="Amina Spahić..." required>
        </div>
    </div>

    <div class="box box-panel" id="pozicija">
        <div class="box-head">
            <a href="javascript:;">
                {{__('Pozicija')}}
            </a>
        </div>
        <div class="box-body in">
            <input type="text" class="form-control" id="validationDefault02" placeholder="Rukovodilac"  required>
        </div>
    </div>
    <div class="box box-panel" id="spol">
        <div class="box-head">
            <a href="javascript:;">
                {{__('Spol')}}
            </a>
        </div>
        <div class="box-body in">
            <select class="form-control" id="validationDefaultUsername" placeholder=""  required>
                <option>{{__('Muško')}}</option>
                <option>{{__('Žensko')}}</option>
            </select>
        </div>
    </div>
    <div class="box box-panel" id="nacionalnost">
        <div class="box-head">
            <a href="javascript:;">
                {{__('Nacionalnost')}}
            </a>
        </div>
        <div class="box-body in">
            <input type="text" class="form-control" id="validationDefault04" placeholder="" required>
        </div>
    </div>
    <div class="box box-panel" id="mjesto">
        <div class="box-head">
            <a href="javascript:;">
                {{__('Mjesto rođenja')}}
            </a>
        </div>
        <div class="box-body in">
            <input type="text" class="form-control" id="validationDefault04" placeholder="Sarajevo" required>
        </div>
    </div>

    <br />

    <button class="btn btn-primary" type="submit">{{__('Filtriraj')}}</button>
</div>