@extends('template.main')

@section('content')
    <div class="calendar mini_calendar"> </div>

    <script>
        window.onload = function(){
            pickDate(true);
        }
    </script>
@endsection
