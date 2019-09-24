<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/grb-bih.ico')}}"/>

        <title>@yield('title', 'Upravljanje ljudskim resursima - ' . env('APP_NAME'))</title>
        <!-- Styles -->
        <link href="{{ asset('css/all.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/datepicker.css') }}" rel="stylesheet">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
              integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        @yield('other_css_links')
    </head>
    <body>
        <div class="alert alert-fill-success mb-0" style="background: #e9681c; border-radius: 0px;">
            <div class="container">
                <i class="fa fa-exclamation-triangle"></i> Poštovani korisnici. Sistem je u fazi finalizacije te je moguće da primijetite funkcionalnosti koje nisu potpune ili se ne ponašaju shodno pretpostavljenom. Molimo Vas da <a href="{{ route('feedback.index') }}" class="text-white font-weight-bold">ovdje</a> prijavite Vaše komentare.
            </div>
        </div>
        <div class="unload">
            <div class="unload-img">
                <img src="{{ asset('images/grb-bih.png') }}" />
            </div>

        </div>

        @include('template.menu')                      <!-- include menu -->
        @include('template.notifications')             <!-- include notifications -->
        @include('template/dodatni_fajlovi/loading')   <!-- include loading -->

        @yield('breadcrumbs', '')

        <main class="py-4" id="app">
            @yield('content')
        </main>

        @include('template.footer')

        <!---- Javascript Files ---->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script defer src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

        <script src="{{ asset('js/sluzbenik.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script>@yield('vue-code')</script>


        @yield('other_js_links')

    </body>
</html>