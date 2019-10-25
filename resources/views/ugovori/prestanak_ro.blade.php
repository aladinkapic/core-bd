@extends('template.main')
@section('other_css_links')
    <style>
        .a4 {
            width: 210mm !important;
            height: 297mm !important;
            margin: 0 auto;
            margin-top: 0;
            padding: 1.5cm 1.5cm 1.5cm 3cm;
            font-family: "Times New Roman", Times, serif;
            border: 1px solid black;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            .a4 {
                margin: 0 -2cm 0 0;
                border: initial;
                border-radius: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
                padding: 1.5cm 0cm 1.5cm 3cm;


                /*height: 100%;*/
                /*width: 100%;*/
                /*position: fixed;*/
                /*top: 0;*/
                /*left: 0;*/
            }

            .pagebreak {
                clear: both;
                page-break-before: always;
            }
        }

        .heading {
            text-align: center;
            line-height: 1.2;
            width: 100%;
            height: 10%;
            font-size: 3.4mm;
        }

        .lijevo {
            float: left;
            width: 40%;
        }

        .centar {
            float: left;
            width: 20%;
            height: 100%;
        }

        .desno {
            float: left;
            width: 40%;
            height: 100%;
        }

        .grb {
            height: 95%;
        }

        .n1 {
            font-size: 4mm;
            letter-spacing: 1mm;
            line-height: 1.6;
        }

        .n2 {
            font-size: 4.5mm;
            letter-spacing: 1.1mm;
            font-weight: bold;
        }

        .n3 {
            font-size: 4.5mm;
            letter-spacing: 0.3mm;
            font-weight: bold;
        }

        .n4 {
            font-size: 6mm;
            letter-spacing: 0.5mm;
            font-weight: bold;
            line-height: 1.6;
        }

        .linija {
            border: 0.5px solid black;
            margin: 0 0 1mm 0;
        }

        .adresa {
            margin-bottom: 0.5mm;
            text-align: center;
            line-height: 1.2;
            font-size: 2.4mm;
        }

        .info {
            margin-top: 4mm;
            font-size: 3mm;
        }

        .text1 {
            margin-top: 3mm;
            font-size: 3.7mm;
            line-height: 1.4;
        }

        .naslov {
            margin-top: 5mm;
            margin-bottom: 3mm;
            letter-spacing: 0.5mm;
            text-align: center;
            font-size: 3.8mm;
            line-height: 1.2;
            font-weight: bold;
        }

        li {
            line-height: 1.4 !important;
        }

        .myfooter {
            margin: 0.5cm;
        }
    </style>
@endsection
@section('content')
    <div class="a4">
        <div class="heading">
            <div class="lijevo">
                <span class="n1"><b>Bosna i Hercegovina</b></span> <br>
                <span class="n2"> BRČKO DISTRIKT</span><br>
                <span class="n3"> BOSNE I HERCEGOVINE</span><br>
                <span class="n4"> GRADONAČELNIK</span>
            </div>
            <div class="centar">
                <img src="images/grb.png" class="grb">
            </div>
            <div class="desno">
                <span class="n1"><b>Босна и Херцеговина</b></span> <br>
                <span class="n2"> БРЧКО ДИСТРИКТ</span><br>
                <span class="n3"> БОСНЕ И ХЕРЦЕГОВИНЕ</span><br>
                <span class="n4"> ГРАДОНАЧЕЛНИК</span>
            </div>
        </div>

        <hr class="linija">

        <div class="adresa">
            <span>Bulevar mira 1, 76100 Brčko Distrit BiH; Tel: 049/240-655; Fax: 240-655; Centrala:240-600, lokal 653;</span>
            <br>
            <span>Булевар мира 1, 76100 Брчко Дистрит БиХ; Тел: 049/240-655; Фаx: 240-655; Централа:240-600, локал 653;</span>
        </div>

        <hr class="linija">

        <div class="row info">
            <div class="col-2">
                <b>Broj predmeta: </b><br>
                Broj akta:<br>
                Datum, <br>
                Mjesto,
            </div>
            <div class="col-3">
                <b>33-00004/19 </b><br>
                02-0368MZ-0995/19 <br>
                02.10.2019.. godine <br>
                Brčko
            </div>
        </div>

        <div class="text1">
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            Na osnovu člana 16. i člana 17. Zakona o Vladi Brčko distrikta BiH ("Službeni glasnik Brčko
            distrikta BiH. broj: (22/18-prečišceni tekst, 49/18), člana 116. stay (1). Zakona o državnoj službi u
            organima uprave Breko distrikta BiH Sluzbeni glasnik Breko distrikta BilH, broj: 09/14, 37/15,
            48/16, 09/17 i 50 i8), gradonačelnik donosi:
        </div>

        <div class="naslov">
            RJEŠENJE<br>
            O PRESTANKU RADNOG ODNOSA
        </div>

        <div class="text1">
            <ol>
                <li>
                    SAMIRI CIFRIC, zaposlenoj u Odjeljenju za javni registar Vlade Brčko distrikta.
                    BiH. Pododjeljenje za matičnu evidenciju,na poziciji Referent za potvrdivanje
                    tačnosti upisa u matične knjige u elektronskom abliku, na odredeno vrijeme, najduže do
                    dvije (2) godine. prestaje radni odnos zbog isteka vremena na koje je primljena.
                </li>
                <li>
                    Imenovanoj radni odnos prestaje sa 29.05.2019. godine.
                </li>
                <li>
                    Imenovana ima pravo na platu do dana koji je naveden kao dan prestanka radnog odnosa.
                </li>
                <li>
                    Za realizaciju ovog rješenja zadužuje se Odjeljenje za stručne i administrativne poslove-
                    Pododjeljenje za ljudske resurse, Odjeljenje za javni registar i Direkcija za finansije-Trezor,
                    Odsjek za centralizovani obračun plata.
                </li>
            </ol>
        </div>

        <div class="naslov">Obrazloženje</div>

        <div class="text1">
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            Samira Cifrić je Rješeniem o zasnivanju radnog odnosa. braj predmeta: 33-002139/17, broj
            akta: 01.1-1141SM-0002/17 od 23.05.2017. godine, zaposlena u Odjeljenju za javni registar Vlade
            Brčko distrikta BiH, Pododjeljenje za matičnu evidenciju, na poziciji Referent za potvrdivanje tačnosti
            upisa u matične knjige u elektronskom obliku, na odredeno vrijeme, najduže do dvije (2) godine.<br>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            Imenovanoj prestaje radni odnos zbog isteka vremena na koje je primljena.<br>
            <br>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            Odjeljenje za javni registar dostavilo je Odjeljenju za stručne i administrativne poslove,
            Pododjeljenju za ljudske resurse, dopis broj predmeta: 33-000798/19, broj akta: 10-1024Z1-001/19 od
            02.04.2019. godine, kojim traži da ovo Pododjeljenje izradi rješenje o prestanku radnog odnosa za
            zaposlenicu Samiru Cifrié, a da je razlog prestanka radnog odnosa istek vremena na koje je ista
            primljena.<br>
            <br>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            Clanom 46. stav (2) tačka a) Zakona o državnoj službi u organima uprave Brčko distrikta BiH
            propisano je da se radni odnos na odredeno vrijeme zasniva za period dok traju potrebe za obavljanjem
            tih poslova, a najduže do dvije godine, a članom 116. stav (1) istog zakona predvideno je da
            zaposleniku prestaje radni odnos istekom vremena na koje je primljen.
            Cijeneći naprijed navedeno odlučeno je kao u dispozitivu rješenja.
        </div>
    </div>

    {{--<div class="pagebreak"> </div>--}}

    {{--<div class="a4">--}}
        {{--<div class="row myfooter">--}}
            {{--<div class="col-6 text1">--}}
                {{--<b>Dostaviti:</b><br>--}}
                {{--1. Imenovanoj,<br>--}}
                {{--2 Odjeljenju za javnu sigurnost,<br>--}}
                {{--3. Pododjeljenju za ljudske resurse,<br>--}}
                {{--4. Direkeiji za finansije- Odsjek--}}
                {{--za centralizovani obračun plata.<br>--}}
                {{--5. Evidenciji<br>--}}
                {{--6. Arhivi.--}}
            {{--</div>--}}
            {{--<div class="col-6">--}}
                {{--<div class="naslov">GRADONAČELNIK</div>--}}
                {{--<div class="naslov">Mr. sc. Siniša Milić</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

@endsection