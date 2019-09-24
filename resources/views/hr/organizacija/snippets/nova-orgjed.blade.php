<h5>Nova organizaciona jedinica</h5>
<br />
<form method="POST" action="{{ route('organizaciona.jedinica.store') }}" >
    {{ method_field('PUT') }}
    {{ csrf_field() }}

    <input type="hidden" name="org_id" value="{{ $organizacija->id }}" />
    <div class="form-group row">
        <label for="staticEmail" class="col-sm-3 col-form-label">Broj</label>
        <div class="col-sm-9">
            <input type="text" name="broj" value="{{ @$novi_broj->broj + 1 }}" class="form-control" placeholder="Unesite broj organizacine jedinice... npr. 2.1">
        </div>
    </div>
    <div class="form-group row">
        <label for="staticEmail" class="col-sm-3 col-form-label">Naziv</label>
        <div class="col-sm-9">
            <input type="text" name="naziv" value="{{ old('naziv') }}" class="form-control" placeholder="Unesite naziv organizacione jedinice...">
        </div>
    </div>
    <div class="form-group row">
        <label for="staticEmail" class="col-sm-3 col-form-label">Tip</label>
        <div class="col-sm-9">
            {{ Form::select('tip', $tipovi, '', ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <label for="staticEmail" class="col-sm-3 col-form-label">Nadređena organizaciona jedinica</label>
        <div class="col-sm-9">
            <select name="parent" class="form-control" id="parent" v-on:change="setNoviBroj">
                <option value="">Glavna organizaciona jedinica</option>
                @foreach($org_jedinice as $jedinica)
                    <option value="{{ $jedinica->id }}">{{ $jedinica->broj }} {{ $jedinica->naziv }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="staticEmail" class="col-sm-3 col-form-label">Opis</label>
        <div class="col-sm-9">
            <textarea name="opis" class="form-control">{{ old('opis') }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="staticEmail" class="col-sm-3 col-form-label"></label>
        <div class="col-sm-9">
            <button class="btn btn-success">Dodaj</button>
        </div>
    </div>

</form>