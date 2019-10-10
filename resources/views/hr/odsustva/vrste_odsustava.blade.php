@extends('template.main')

@section('other_js_links')

@stop

@section('content')
    <div class="container">
        <div class="col-sm-12">
            <div class="card ">
                <div class="card-header ads-darker">
                    <button onClick="window.location='/hr/odsustva/dodaj_vrstu_odsust';" class="btn btn-light float-right" ><i class="fa fa-plus-circle"></i> {{__('Dodaj novo odsustvo')}}</button>
                    <h4>{{__('Pregled vrsta odsustava')}}</h4>
                </div>
                <div class="card-body hr-activity tab">
                    <br />
                    <table class="table table-bordered">
                        <thead >
                        <tr >
                            <th scope="col" width="40px;" style="text-align:center;">#</th>
                            <th scope="col">{{__('Vrsta odsustva')}}</th>
                            <th scope="col" width="120px;" style="text-align:center;">{{__('Akcije')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $counter = 0; @endphp

                        @foreach($odsustva as $odsustvo)
                            <tr>
                                <th scope="row">{{ ++$counter }}</th>
                                <td>{{$odsustvo -> naziv_odsustva ?? '/'}}</td>

                                <td style="text-align:center;">
                                    <a href="/hr/odsustva/obrisi_vrstu_ods/{{$odsustvo->id ?? '1'}}">
                                        <i class="fas fa-trash-alt"></i> {{__('Izbrišite')}}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <br />
                    <br />
                </div>
            </div>

        </div>
    </div>
@endsection