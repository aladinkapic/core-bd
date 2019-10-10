@extends('template.main')
@section('title') {{__('Pregled tržišta rada')}} @endsection

@section('content')
    <div class="container">
        <div class="card-header ads-darker" style="height:60px;">
            <button onClick="window.location='{{ route('unos.strateskogplaniranja') }}';" class="btn btn-light float-right" ><i class="fa fa-plus-circle"></i> {{__('Planiranje kadrova')}}</button>
            <h4 style="padding-top:6px; margin-top:0px;">
                {{__('Strateško planiranje - planiranje kadrova')}}
            </h4>
        </div>


        <table class="table table-bordered">
            <thead >
            <tr >
                <th scope="col" width="40px;" class="text-center">{{__('ID')}}</th>
                <th scope="col">{{__('Naziv')}}</th>
                <th scope="col">{{__('Broj planiranih godina')}}</th>
                <th scope="col">{{__('Ime i prezime')}}</th>
                <th scope="col">{{__('Datum zaključenja')}}</th>
                <th scope="col" class="text-center">{{__('Akcije')}}</th>
            </tr>
            </thead>
            <tbody>
            @php $i=1; @endphp
            @foreach($strat_plan as $plan)
                <tr >
                    <th scope="col" width="40px;" class="text-center">{{$i++ ?? '/'}}</th>
                    <th scope="col">{{$plan->naziv ?? '/'}}</th>
                    <th scope="col">{{$plan->br_plan_godina ?? '/'}} {{__('godina')}}</th>
                    <th scope="col">{{__('Ime i prezime')}}</th>
                    <th scope="col">
                        {{$plan->created_at ?? '/'}}
                    </th>
                    <th scope="col" class="text-center">
                        <a href="{{route('pregled.strateskoplaniranje', ['id' => $plan->id])}}" title="Pregledajte strateško planiranje">
                            <i class="fa fa-eye" style="margin-right:10px;"></i>
                        </a>

                        <a href="{{route('uredi.strateskoplaniranje', ['id' => $plan->id])}}" title="Uredite strateško planiranje">
                            <i class="fas fa-edit"></i>
                        </a>
                    </th>
                </tr>
            @endforeach

            </tbody>
        </table>


    </div>
@endsection
