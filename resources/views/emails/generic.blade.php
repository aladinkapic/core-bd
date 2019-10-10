<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{__('Obavijest sa stranice')}}</title>
        <!-- Styles -->
        <link href="{{ asset('css/all.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/datepicker.css') }}" rel="stylesheet">
        <link href="{{ asset('css/emails/email.css') }}" rel="stylesheet">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
              integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

        <style>
            #emails_wrapper {
                position: relative;
                left: 0px;
                width: 100%;
                min-height: 200px;
            }

            #emails_wrapper #email_header {
                position: relative;
                left: 0px;
                top: 0px;
                padding-top: 20px;
                padding-bottom: 20px;
                width: 100%;
                background: rgba(0, 154, 208, 0.08);
                text-align: center;
            }

            #emails_wrapper #email_header h2 {
                margin-top: 0px;
            }

            #emails_wrapper #content {
                position: relative;
                left: 15%;
                width: 70%;
                height: auto;
            }

            #emails_wrapper #content h4 {
                margin-top: 30px;
            }

            #emails_wrapper #content h5 {
                margin-top: 30px;
            }

            #emails_wrapper #email_footer {
                position: relative;
                left: 0px;
                width: 100%;
                height: 160px;
                margin-top: 200px;
                background: rgba(0, 154, 208, 0.08);
            }

            #emails_wrapper #email_footer .footer_image {
                position: absolute;
                left: 0px;
                top: 0px;
                width: 120px;
                height: 160px;
            }

            #emails_wrapper #email_footer .footer_image img {
                position: absolute;
                left: 0px;
                top: 0px;
                right: 0px;
                bottom: 0px;
                margin: auto;
            }

            #emails_wrapper #email_footer .footer_text {
                position: absolute;
                left: 120px;
                top: 0px;
                width: calc(100% - 300px);
                height: 300px;
                border-left: 1px solid white;
                padding-left: 20px;
                padding-top: 20px;
            }

            #emails_wrapper #email_footer .footer_text h4 {
                position: absolute;
                left: 20px;
                top: 20px;
            }

            #emails_wrapper #email_footer .footer_text h5 {
                position: absolute;
                top: 60px;
                margin-top: 0px;
                padding-top: 0px;
            }

            #emails_wrapper #email_footer .footer_text .single_value {
                position: absolute;
                width: 100%;
                top: 90px;
                height: 30px;
            }

            #emails_wrapper #email_footer .footer_text .single_value img {
                position: absolute;
                top: 7px;
            }

            #emails_wrapper #email_footer .footer_text .single_value #phone_image {
                left: 200px;
            }

            #emails_wrapper #email_footer .footer_text .single_value p {
                position: absolute;
                left: 26px;
                top: 4px;
            }

            #emails_wrapper #email_footer .footer_text .single_value #telephone_value {
                left: 226px;
            }

            #emails_wrapper #email_footer .footer_text .single_value2 {
                top: 120px;
            }


        </style>
    </head>
    <body>
        <div id="emails_wrapper">
            <div id="email_header">
                <h2>{{__('Vlada Brčko Distrikta')}}</h2>
                <h5>{{__('Pododjeljenje za ljudske resurse Brčko Distrikta')}}</h5>
            </div>

            <div id="content">
                <h4>{{__('Poštovani John Doe')}}</h4>
                <h5>
                    {{__('Obaviještavamo vas da je ovo poruka samo testnog karaktera i kao takva ne treb biti shvaćena ozbiljno.
                    U slučaju da vas stvarno zanima svrha ove poruke, obratite se njenom tvorcu koji također veze nema šta
                    ona treba da predstavlja. Cilj pisanja ove poruke je da bi se ustanovio konzistentan template koji
                    će se moći u opštem slučaju koristiti u mnoge svrhe.')}}

                    <br><br>

                    {{__('Za sva ostala pitanja obratite se Vladi Brčko Distrikta koja je zaposlila ove ljude.')}}


                    {{__('P.S. Jesam slatki, right ? Vaš email')}}
                </h5>
            </div>

            <div id="email_footer">
                <div class="footer_image">
                    {{ Html::Image('images/grb-bih.png', '', ['width' => 60]) }}
                </div>

                <div class="footer_text">
                    <h4>{{__('Vlada Brčkog distrikta')}}</h4>
                    <h5>{{__('Pododjeljenje za ljudske resurse Brčko Distrikta')}}</h5>

                    <div class="single_value">
                        {{ Html::Image('images/envelope.png', '', ['width' => 16]) }}
                        <p>info@email.com</p>

                        {{ Html::Image('images/telephone.png', '', ['width' => 16, 'id' => 'phone_image']) }}
                        <p id="telephone_value">+38761/225-886</p>
                    </div>
                    <div class="single_value single_value2">
                        {{ Html::Image('images/grid-world.png', '', ['width' => 16]) }}
                        <p>{{__('www.mojadomena.com')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>