@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/osposobljavanje_i_usavrsavanje/obuke/home' => 'Katalog obuka',
    ]) !!}
@stop

@section('content')
    <div class="container">
        <div class="col-md-10">
            <h3 >{{__('Katalog obuka')}}</h3>
        </div>
        <br />
        <br />
        @include('template.snippets.filters', ['var'  => $instance])

        <table id="filtering" class="table table-condensed table-bordered">
            <thead>
            <th class="text-center">#</th>
            @include('template.snippets.filters_header')

            <th class="text-center" width="10%">{{__('Akcije')}}</th>
            </thead>
            <tbody>
            @php $i=1; @endphp
            @foreach($instance as $instanca)
                <?php
                if($instanca->status ==='Između') $color="#3dc582";
                if($instanca->status ==='Prije') $color="#ffc107";
                if($instanca->status ==='Nakon') $color="#6c757d";
                ?>
                <tr style="border-left: solid 5px {{$color}} ;">
                    <td class="text-center">{{$i++}}</td>
                    <td>
                        Od: {{$instanca->odrzavanje_od ?? '/'}}
                        <br>
                        Do: {{$instanca->odrzavanje_do ?? '/'}}
                    </td>
                    <td>
                        @if($instanca->status ==='Između')
                            <p class="badge badge-success">{{__('U toku')}}</p>
                        @endif
                        @if($instanca->status ==='Prije')
                                <h3 class="badge  badge-warning">{{__('Priprema')}}</h3>
                            @endif
                            @if($instanca->status ==='Nakon')
                                <h3 class="badge badge-secondary">{{__('Završeno')}}</h3>
                            @endif
                    </td>
                    <td>
                        @foreach($instanca->predavaci_real as $predavac)
                            {{$predavac['ime'].' '.$predavac['prezime']}}
                            <br>
                        @endforeach
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-6">
                                <?php
                                $n=0;
                                foreach($instanca->sluzbenici_real as $sluzbenik){
                                    if ($n%2==0)
                                        echo $sluzbenik['ime'].' '.$sluzbenik['prezime']."<br>";
                                    $n++;
                                }
                                ?>
                            </div>
                            <div class="col-6">
                                <?php
                                $n=0;
                                foreach($instanca->sluzbenici_real as $sluzbenik){
                                    if ($n%2!=0)
                                        echo $sluzbenik['ime'].' '.$sluzbenik['prezime']."<br>";
                                    $n++;
                                }
                                ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-6">
                        <?php
                            $counter = 0;
                            foreach ($postavke as $key => $value){
                                if ($counter % 2 ==0)
                                echo "<b>".$key."</b> : ".$value."<br>";
                                $counter++;
                            } ?>
                            </div>
                            <div class="col-6">
                                <?php
                            $counter = 0;
                            foreach ($postavke as $key => $value){
                                if ($counter % 2 !=0)
                                echo "<b>".$key."</b> : ".$value."<br>";
                                $counter++;
                            } ?>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="/osposobljavanje_i_usavrsavanje/obuke/ocjenaInstance/{{$instanca -> id ?? '1'}}" style="margin-left:10px;"
                        title="Ocjeni instancu">
                            <i class="fas fa-check-square"></i>
                        </a>
                        <a href="/osposobljavanje_i_usavrsavanje/obuke/deleteInstance/{{$instanca -> id ?? '1'}}" style="margin-left:10px;">
                            <i class="fas fa-times"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
