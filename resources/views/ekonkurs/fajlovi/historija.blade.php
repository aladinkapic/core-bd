<table class="table table-bordered">
    <thead>
    <tr>
        <th width="40px" class="text-center">#</th>
        <th>{{__('Ime i prezime službenika')}}</th>
        <th>{{__('Datum ')}}</th>
        <th class="text-center">{{__('Odgovorna osoba')}}</th>
        <th width="120px" class="text-center">{{__('Akcije')}}</th>
    </tr>
    </thead>
    <tbody>
    @php $i = 1; @endphp
    @foreach(\App\Models\eKonkurs::all() as $historija)
        @php
            $sluzbenik = \App\Models\Sluzbenik::where('id', '=', $historija->id_sluzbenika)->first();
            $root = \App\Models\Sluzbenik::where('id', '=', $historija->id_roota)->first()
        @endphp
        <tr>
            <th class="text-center">{{$i++}}</th>
            <th><a href="{{ route('sluzbenik.dodatno', ['id' => $sluzbenik->id]) }}">{{ $sluzbenik->ime }} {{ $sluzbenik->prezime }}</a></th>
            <th>{{ \Carbon\Carbon::parse($historija->created_at)->format('d.m.Y') }}</th>
            <th class="text-center"><a href="{{ route('sluzbenik.dodatno', ['id' => $root->id]) }}">{{ $root->ime }} {{ $root->prezime }}</a></th>
            <th width="120px" class="text-center">
                <a href="{{route('dodaj.sifrarnik', ['type' => ''])}}">
                    {{__('Pregled')}}
                    <i class="fas fa-angle-right"></i>
                </a>
            </th>
        </tr>
    @endforeach
    </tbody>
</table>