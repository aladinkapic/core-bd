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
            <button v-on:click="fireTable()" class="btn btn-primary btn-xs"> <i class="fa fa-filter" style="font-size: 11px;"></i> {{__('Filteri')}}</button>
            @include('snippets.buttons')
        </div>
        <br>

        <table id="filtering" class="table table-condensed table-bordered">
            <thead>
            <th width="10%">{{__('Trajanje obuke')}}	</th>
            <th width="10%">{{__('Status')}}</th>
            <th width="10%">{{__('Predavači	')}}</th>
            <th width="30%">{{__('Službenici')}}</th>
            <th width="35%">{{__('Postavke')}}</th>
            <th width="5%">{{__('Akcije')}}</th>
            </thead>
            <tbody>
            @foreach($instance as $instanca)
                <?php
                if($instanca->status ==='Između') $color="#3dc582";
                if($instanca->status ==='Prije') $color="#ffc107";
                if($instanca->status ==='Nakon') $color="#6c757d";
                ?>
                <tr style="border-left: solid 5px {{$color}} ;">
                    <td>
                        Od: {{$instanca->odrzavanje_od}}
                        <br>
                        Do: {{$instanca->odrzavanje_do}}
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
                    <td>
                        <a href="/osposobljavanje_i_usavrsavanje/obuke/deleteInstance/{{$instanca -> id}}" style="margin-left:10px;">
                            <i class="fas fa-times"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
