@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/ostalo/historizacija/home' => 'Historija izmjena',
    ]) !!}
@stop

@section('content')

    <?php
    $model = null;
    for($i = strlen($log->operation);$i>0; $i--){
        if($log -> operation[$i-1] === '\\') break;
        $model.=$log -> operation[$i-1];
    }
    $model = implode(array_reverse(str_split($model)));
    ?>

    <?php
    $operacija = null;
    if ($log->old_data == $log->new_data)
        $operacija = __('Brisanje');
    else if($log->old_data == "[]")
        $operacija = __('Spremanje');
    else $operacija = __('Uređivanje');

    ?>
    <div class="container">

        <div class="card ">
            <div class="card-header ads-darker">
                <h3>{{__('Historija izmjena')}}</h3>
            </div>
            <div class="card-body hr-activity tab">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-group row">
                            <div class="card col-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{__('Službenik')}}</h5>
                                    <h4 class="card-text">{{$log -> sluzbenik -> ime}} {{$log -> sluzbenik -> prezime}}</h4>
                                </div>
                            </div>
                            <div class="card col-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{__('Modul')}}</h5>
                                    <h4 class="card-text">{{$model}}</h4>
                                </div>
                            </div>
                            <div class="card col-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{__('Operacija')}}</h5>
                                    <h4 class="card-text">{{$operacija}}</h4>
                                </div>
                            </div>
                            <div class="card col-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{__('Izvršeno')}}</h5>
                                    <h4 class="card-text">{{$log->created_at }}</h4>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                        <div class="col-6">
                        <h4>{{__('Stare Vrijednosti')}}</h4>
                        <br>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>
                                    {{__('Kolona')}}
                                </th>
                                <th>
                                    {{__('Vrijednost')}}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php  $olddata = $log->old_data; ?>
                                @foreach($log->old_data as $data => $key)
                            <tr>
                                <td>
                                    {{$data}}
                                </td>
                                <td>
                                    <?php
                                        if (gettype ($key)==='object'){
                                            echo "<table><thead><th>Naziv</th><th>Vrijednost</th></thead><tbody>";
                                            foreach ($key as $key2 =>$value2){
                                                echo "<tr><td>$key2</td><td>$value2</td></tr>" ;
                                            }
                                            echo "</tbody></table>";
                                        }
                                        else
                                             echo $key;
                                    ?>
                                </td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </table>
                    </div>
                            <?php
                            if ($operacija != 'Brisanje'){  ?>
                            <div class="col-6">
                                <h4>{{__('Nove Vrijednosti')}}</h4>
                                <br>
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>
                                            {{__('Kolona')}}
                                        </th>
                                        <th>
                                            {{__('Vrijednost')}}
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php  $newdata = $log->new_data;
                                     ?>

                                    @foreach($newdata as $data => $key)
                                        <?php
                                        $datanew =$data;
                                        $keynew=$key;
                                        $color = null;
                                       if($operacija == 'Uređivanje') {

                                           $olddata = $log->old_data;
                                           foreach ($olddata as $data => $key)
                                               if ($datanew == $data)
                                                   if ($keynew != $key){
                                                       $color = 'background-color: #ffb2b2;';}
                                                   else $color = null;
                                        } ?>
                                        <tr style="{{$color}}">
                                            <td>
                                                {{$datanew}}
                                            </td>
                                            <td>
                                                <?php
                                                if (gettype ($keynew)==='object'){
                                                    echo "<table><thead><th>Naziv</th><th>Vrijednost</th></thead><tbody>";
                                                    foreach ($keynew as $key2 =>$value2){
                                                        echo "<tr><td>$key2</td><td>$value2</td></tr>" ;
                                                    }
                                                    echo "</tbody></table>";
                                                }
                                                    else echo $keynew;
                                                ?>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                </table>
                            </div>
                            <?php } ?>
                        </div>
                </div>
            </div>
        </div>
    </div>

@endsection