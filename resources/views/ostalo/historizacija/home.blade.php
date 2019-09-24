@extends('template.main')

@section('breadcrumbs')

    {!! \App\Http\Controllers\HelpController::breadcrumbs([
        route('home') => 'Početna stranica',
        '/ostalo/historizacija/home' => 'Historija izmjena',
    ]) !!}
@stop

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h3 >{{__('Historija izmjena')}}</h3>
                <button v-on:click="fireTable()" class="btn btn-primary btn-xs"> <i class="fa fa-filter" style="font-size: 11px;"></i> {{__('Filteri')}}</button>
                @include('snippets.buttons')
            </div>
        </div>
        <br />
        <br />
        <table id="filtering" class="table table-condensed table-bordered">
            <thead><tr>
            <th width="100">{{__('ID')}}</th>
            <th>{{__('Službenik')}}</th>
            <th>{{__('Modul')}}</th>
            <th>{{__('Operacija')}}</th>
            <th>{{__('Izvršeno')}}</th>
            <th width="100">{{__('Akcije')}}</th>
            </tr>
            </thead>
            <tbody>
            @if (isset($logs))
            @foreach($logs as $log)
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

                <tr class="org-row">
                    <td>{{$log -> id}}</td>
                    <td>{{$log -> sluzbenik -> ime}} {{$log -> sluzbenik -> prezime}}</td>
                    <td>{{$model }}</td>
                    <td>{{$operacija }}</td>
                    <td>{{$log->created_at}}</td>
                    <td class="text-center">
                        <a href="/ostalo/historizacija/detalji/{{$log -> id}}">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
                @else
                    <tr>
                        <td colspan="6">{{__('Nema Podataka!')}}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection