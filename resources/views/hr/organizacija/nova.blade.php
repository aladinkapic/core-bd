@extends('template.main')

@section('other_js_links')
{{--    <script async src="{{ asset('js/organizacija.js') }}"></script>--}}
{{--    <script>--}}
{{--        app.getOrganizacija = function(){--}}
{{--            $.post({--}}
{{--                "url": "{{ route('organizacija.api') }}",--}}
{{--                "data": { action: "getOrganizacija", "_token": "{{ csrf_token() }}", org_id: $("#oju_id").val() }--}}
{{--            }).done(function(data){--}}

{{--                app.items = JSON.parse(data);--}}

{{--            });--}}
{{--        };--}}
{{--    </script>--}}
@stop

@section('content')
    <div class="container">
        <!-- Multi step form -->
        <section class="multi_step_form">
            <div id="msform">

            </div>
        </section>
    </div>
    <!-- End Multi step form -->

@stop