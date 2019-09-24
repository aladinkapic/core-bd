<html>
    <head>
        <title>Prijavite se</title>

        <link href="{{ asset('css/login.css') }}" rel="stylesheet">

        <!-- font-family: 'Nunito', sans-serif; -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    </head>
    <body>
        <div class="lijeva_slika">
            <img src="/images/grb-bih.png" alt="">
        </div>
            @if(!isset($good_to_go))
                <div class="login_forma">
                    <form action="/prijavi_me" method="post">
                        <div class="forma">
                            {{ csrf_field() }}
                            <div class="red_forme">
                                <h4>PRIJAVITE SE</h4>
                            </div>

                            <div class="input_okvir @if(isset($username_greska)) @if($username_greska == 'greska') crveni_okvir @endif @endif">
                                <div class="input_okvir_i">
                                    <i class="fas fa-user"></i>
                                </div>
                                <input type="text" name="username" placeholder="{{ isset($username_placeholder) ? $username_placeholder : 'Vaš username' }}" value="{{ isset($username_value) ? $username_value : '' }}" autocomplete="off">
                            </div>
                            <div class="input_okvir @if(isset($username_greska)) @if($sifra_greska == 'greska') crveni_okvir @endif @endif ">
                                <div class="input_okvir_i">
                                    <i class="fas fa-unlock-alt"></i>
                                </div>
                                <input type="password" name="sifra" placeholder="{{ isset($sifra_placeholder) ? $sifra_placeholder : 'Vaša šifra' }}">
                            </div>
                            <div class="input_okvir">
                                <div class="input_okvir_i">
                                    <i class="fas fa-globe-europe"></i>
                                </div>
                                <select class="form-control" name="jezik">
                                    <option value="bs">Bosanski</option>
                                    <option value="hr">Hrvatski</option>
                                    <option value="sr">Srpski</option>
                                    <option value="src">Srpski (ćirilica)</option>
                                </select>
                            </div>

                            <div class="input_button">
                                <input type="submit" value="DALJE">
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="login_forma">
                    <form action="/provjeri_pin" method="post">
                        <div class="forma">
                            {{ csrf_field() }}
                            <div class="red_forme">
                                <h4>UNESITE VAŠ PIN</h4>
                            </div>

                            <div class="input_okvir {{ isset($greska) ? 'crveni_okvir' : '' }}">
                                <div class="input_okvir_i">
                                    <i class="fas fa-user"></i>
                                </div>
                                <input type="password" name="pin" placeholder="{{ isset($greska) ? $greska : 'Vaš PIN kod' }}" autocomplete="off">
                            </div>

                            <div class="input_button">
                                <input type="submit" value="PRIJAVI ME">
                            </div>
                        </div>
                    </form>
                </div>
            @endif
    </body>
</html>
