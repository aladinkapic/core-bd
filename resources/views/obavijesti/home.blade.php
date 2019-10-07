@extends('template.main')

@section('content')
    <div class="container">
        <h3>{{__('Obavijesti')}}</h3>

        <table class="table table-hover" id="tabelaObavijesti">
            <thead>
            <tr>
                <th scope="col">{{__('Subjekt')}}</th>
                <th scope="col">{{__('Službenik')}}</th>
                <th scope="col">{{__('Poruka')}}</th>
                <th scope="col">{{__('Kreirano')}}</th>
                <th scope="col" style="width: 8%;text-align: center;">{{__('Označi kao urađeno')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($notifications as $notification)
                <tr {{$notification->class ?? '/'}}>
                    <td>{{$notification->what ?? '/'}}</td>
                    <td>{{$notification->sluzbenik ?? '/'}}</td>
                    <td>{{$notification->message ?? '/'}}</td>
                    <td>{{$notification->created_at ?? '/'}}</td>
                    @if($notification->read_at == null)
                    <td id="celijaPregledaj" style="text-align: center;" onclick="pregledaj(this);" onmouseleave="checkhide(this);" onmouseover="checkhover(this);">
                        <i style="display: none;" id="{{$notification->id ?? '1'}}" class="fas fa-check"></i>
                        <p id="hiddenid" style="display:none;">{{$notification->id ?? '1'}}</p>
                    </td>
                        @else
                    <td><p id="hiddenid" style="display:none;">{{$notification->id ?? '1'}}</p>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
            <?php echo $notifications->render(); ?>
        </table>
    </div>
@endsection