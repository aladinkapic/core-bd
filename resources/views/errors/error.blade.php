<html>
    <head>
        <title>{{$error_msg}}</title>
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/grb-bih.ico')}}"/>
        <link rel="stylesheet" href="{{asset('/css/errors.css')}}">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="image_wrapper">
            {!! Html::image('/images/balloon.jpg') !!}

            <div class="inner_wrapper">
                <div class="left_image">
                    {!! Html::image('/images/balloon.jpg') !!}
                </div>

                <div class="right_part">
                    <div class="top_header">
                        {!! Html::image('/images/grb-bih.png', '', ['width' => '64px']) !!}
                        <h2>Vlada Brčko Distrikta</h2>
                        <h3>Pododjeljenje za ljudske resurse</h3>
                    </div>

                    <div class="error_header">
                        <p>Oooops.  {{$error_msg}}</p>
                        <p>
                            <span>Greška koda :</span>
                        </p>

                        <h1>
                            {{$number}}
                        </h1>

                        <a href="/home">
                            <div class="button">
                                <p>NAZAD NA NASLOVNU</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>