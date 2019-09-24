@extends('template.main')

@section('content')
    <div class="container">
        <select class="form-control select2">
        </select>
    </div>
@stop

@section('other_js_links')
    <script>
        $(document).ready(function(){
           $(".select2").select2({
               minimumInputLength: 2,
               ajax: {
                   url: "{{ route('api.pretraga.sluzbenik') }}",
                   dataType: 'json',
                   type: "POST",
                   quietMillis: 50,
                   data: function (params) {
                       return {
                           data: params.term,
                           _token: $('meta[name="csrf-token"]').attr('content')
                       };
                   },
                   processResults: function (data) {
                       return {
                           results: $.map(data, function(obj) {
                               return { id: obj.id, text: obj.ime };
                           })
                       };
                   },

               }
           });
        });
    </script>
@stop