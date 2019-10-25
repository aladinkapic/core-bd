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
            Na osnovu člana 17. stav (7) Zakona o Vladi Brčko distrikta Bill - prečišéen tekst (Slu2beni
            glasnik Breko distrikta BiH". brojeví: 22/18. 49/18, 08/19 i 10/19). clana 123. stav (1) Zakona o
            državnoj službi u organima javne uprave Breko distrikta BilH (Službeni glasnik Brčko distrikta BiH
            broj: 09/14. 37/15, 48/16, 09/17, 50/18 i 14/19), u skladu sa članom 5. Zakona o platama i naknadama
            u organima javne uprave i institucijama Breko distrikta BiH («Službeni glasnik Brčko distrikta BiH».
            broj: 8/19, 10/19 i 12/19). Odlukom o usvajanju Budžeta Bréko distrikta BiH za fiskalnu 2019, godinu,
            broj: 01-02-569/19 od 27.03.2019. gcdine, Oalukom o izmjenama i dopunama Budžeta Brčko distrikta
            BiH za 2019 godinu, broj: 01-02-646/19 od 19.06.2019. godine i Odlukom o izmjenama
            Organizacionog plana Odjeljenje za javnu sigurnost, broj: 02-000238/16, broj akta: 01.1-1141SM-
            89 19 od 30.07.2019.godine, gradonačelnik d o n o s i
        </div>

        <div class="naslov">
            RJEŠENJE
        </div>

        <div class="text1">
            <ol>
                <li>
                    <b>ADŽIKIĆ HUSEJINAGIĆ EMINI,</b> zaposlenici <b>Odjeljenje za javnu sigurnost,</b> Pododjeljenje za
                    zaštitu spašavanje, Odsjek civilne zaštite. Služba stručno administrativnih poslova iz oblasti
                    civilne zaštite, na radnom mjestu <b>Viši stručni saradnik za mjere zaštite i spasavanja u Odsjeku
                        civilne zaštite, utvrduje se mjesečna osnovna plata u iznosu od 1.603.23 KM, platni razred
                        VII5 i koeficijent 2,45067.</b>
                </li>
                <li>
                    Imenovana ima pravo na <b>dodatak na platu po osnovu radnog staža i to 0,30%</b> na osnovnu platu
                    za svaku navršenu godinu radnog staža.
                </li>
                <li>
                    Imenovana ima pravo na <b>dodatak na platu po osnovu pasebnib uslova radnog mjesta u iznosu
                        od 10% osnovne plate za efektivno radno vrijeme.</b>
                </li>
                <li>
                    Imenovanoj se plata iz tačke 1. ovog rješenja i pravo na dodatke na platu po ossnovu radnog staža iz
                    tačke 2. i posebnih uslova radnog mjesta iz tačke 3. utvrduju <b>počev od 01.07.2019. godine.</b>
                </li>
                <li>
                    Osnovica za obračun osnovne plate iz tačke 1. ovog rješenja utvrdena je za period od 01.07. do
                    31.12.2019. godine u iznosu od 654.20 KM, a ukoliko se budžet za narednu fiskalnu godinu ne
                    usvoji do 31.12.2019. godine, nova osnovica za obračun plate primjenjuje se od narednog mjeseca
                    od dana usvajanja budžeta.
                </li>
                <li>
                    Za realizaciju ovog rješenja zadužuje se Direkcija za finansije Breko distrikta BiH -Odsjek za
                    centralizovani obračun plata.
                </li>
            </ol>
        </div>

        <div class="naslov">Obrazloženje</div>

        <div class="text1">
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            U skladu sa odredbama Zakona o platama i naknadama u organima javne uprave i
            institucijama Brčko distrikta BiH («Službeni glasnik Breko distrikta Bil l», broj: 8/19, 10/19 i 12/19)
            Odlukom o usvajanju Budžeta Brčko distrikta BiH za fiskalnu 2019. godinu, broj: 01-02-569/19 oc
            27.03.2019. godine, Odlukom o izmjenama i dopunama Budžeta Brčko distrikta BiH za 2019, godinu
            broj: 01-02-646/19 od 19.06.2019 godine i Odlukom o izmjenama Organizacionog plana Odjeljenje za
            javnu sigurnost, broj: 02-000238/16, broj akta: O1.1-1141SM-089/19 od 30.07.2019 godine, ovim
            rješenjem ADŽIKIC HUSEJINAGIC EMINI, zaposlenici Odjeljenje za javnu sigumost. Pododjeljenje za zaštitu i
            spašavanje, Odsjek civilne zaštite. Služba stručno administrativnih poslova iz oblasti
            civilne zaštite, 1na radnom mjestu Visi stručni saradnik za mjere zaštite i spasavanja u Odsjeku civilne
            zaštite, utvrdena je mjesečna osnovna plata, platni razred i koeficijent, kao i pravo na dodatke na platu
            po osnovu radnog staza i po osnovu posebnih uslova radnog mjesta, počev od 01.07.2019. godine.
        </div>

        <div class="text1">
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            <b>Pouka o pravnom lijeku:</b><br>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            Protiv ovog rješenja može se izjaviti žalba Apelacionoj komisiji Kancelarije gradonačelnika u
            roku od 15 dana od dana dostavljanja, a podnosi se posredstvom Odjeljenja za stručne i
            administrativne poslove.
        </div>
    </div>

    <div class="pagebreak"> </div>

    <div class="a4">
        <div class="row myfooter">
            <div class="col-6 text1">
                <b>Dostaviti:</b><br>
                1. Imenovanoj,<br>
                2 Odjeljenju za javnu sigurnost,<br>
                3. Pododjeljenju za ljudske resurse,<br>
                4. Direkeiji za finansije- Odsjek
                za centralizovani obračun plata.<br>
                5. Evidenciji<br>
                6. Arhivi.
            </div>
            <div class="col-6">
                <div class="naslov">GRADONAČELNIK</div>
                <div class="naslov">Mr. sc. Siniša Milić</div>
            </div>
        </div>
    </div>

@endsection