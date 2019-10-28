<div class="">
    <br />
    <table class="table table-bordered"  id="filtering">
        <thead >
        <tr >
            <th scope="col" width="40px;" class="text-center">{{__('ID')}}</th>
            <th scope="col">{{__('Naziv radnog mjesta')}}</th>
            <th scope="col">{{__('Šifra radnog mjesta')}}</th>
            <th scope="col">{{__('Broj izvršilaca')}}</th>
            <th scope="col">{{__('Organizacijska jedinica')}}</th>
            <th scope="col" class="text-center">{{__('Akcije')}}</th>
        </tr>
        </thead>
        <tbody>

        @php $i=1; @endphp
        @foreach($radna_mjesta as $radno_mjesto)
            <tr>
                <td scope="row" width="40px;" class="text-center">{{$radno_mjesto->id ?? '1'}}</td>
                <td>
                    {{$radno_mjesto->naziv_rm ?? '/'}}
                </td>
                <td>
                    {{$radno_mjesto->sifra_rm ?? '/'}}
                </td>
                <td>
                    {{$radno_mjesto->broj_izvrsilaca ?? '/'}}
                </td>
                <td>
                    {{ \App\Models\OrganizacionaJedinica::where('id', '=', $radno_mjesto->id_oj)->first()->naziv }}
                </td>
                @php

                if(isset($organizacija_id)){
                    $org_id = $organizacija_id;
                }else{
                    $org_id = $radno_mjesto->id_oj;
                }

                @endphp
                <td class="text-center">
                    <a href="/hr/radna_mjesta/pregledaj_radno_mjesto/{{$radno_mjesto->id ?? '1'}}" title="Pregledajte radno mjesto">
                        <i class="fa fa-eye" style="margin-right:10px;"></i>
                    </a>

                    <a href="/hr/radna_mjesta/uredi_radno_mjesto/{{$radno_mjesto->id ?? '1'}}" title="Uredite radno mjesto">
                        <i class="fas fa-edit"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="text-center">
        {{--{!! $radna_mjesta->links(); !!}--}}
    </div>
    <br />
    <br />
</div>