@extends('template.main')
@section('other_css_links')
    <style>

        .a4 {
            width: 210mm !important;
            height: 297mm !important;
            padding: 2cm;
            margin: 1cm auto;
            margin-top: 0;
            padding-top: 1.5cm;
            padding-left: 3cm;
            font-family: "Times New Roman", Times, serif;
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

        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            .a4 {
                margin: 1cm;
                border: initial;
                border-radius: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;

                height: 100%;
                width: 100%;
                position: fixed;
                top: 0;
                left: 0;
            }
        }

        .linija {
            margin-top: 0;
            margin-bottom: 0;
            border: 0.2mm solid black;
        }

        .adresa {
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
            font-size: 3.3mm;
            line-height: 1.4;
        }

        .naslov {
            margin-top: 3mm;
            margin-bottom: 3mm;
            letter-spacing: 0.5mm;
            text-align: center;
            font-size: 3.8mm;
            line-height: 1.2;
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
                <span class="naslov1"><b>Bosna i Hercegovina</b></span>
                <br>
                <span class="naslov2">BRČKO DISTRIKT </span>
                <br>
                <span class="naslov2">BOSNE I HERCEGOVINE</span>
                <br>

                <span class="naslov3"><b>Vlada Brčko distrikta</b></span>
                <br>
                <span class="naslov3">Odjel/Odjeljenje za stručne i</span>
                <br>
                <span class="naslov3">administrativne poslove</span>
            </div>
            <div class="centar">
                <img src="images/grb.png" class="grb">
            </div>
            <div class="desno">
                <span class="naslov1"><b>Босна и Херцеговина</b></span><br>
                <span class="naslov2">БРЧКО ДИСТРИКТ </span>
                <br>
                <span class="naslov2">БОСНЕ И ХЕРЦЕГОВИНЕ</span>
                <br>
                <span class="naslov3"><b>Влада Брчко дистрикта</b></span>
                <br>
                <span class="naslov3">Одјељење за стручне и</span>
                <br>
                <span class="naslov3">административне послове</span>
            </div>
        </div>

        <hr class="linija">

        <div class="adresa">
            <span>Bulevar mira 1, 76100 Brčko Distrit BiH; Tel: 049/240-655; Fax: 240-655; Centrala:240-600, lokal 653;</span>
            <br>
            <span>Булевар мира 1, 76100 Брчко Дистрит БиХ; Тел: 049/240-655; Фаx: 240-655; Централа:240-600, локал 653;</span>
        </div>

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
            Na osnovu Odluke o davanju ovlaštenja broj: 05-000928/15, broj akta: 02-0578TS-0002/15 od
            05.10.2015. godine, šef Pododjeljenja za ljudske resurse, u skladu sa članom 71, 72. 73. i 74. Zakona o
            državnoj službi u organima javne uprave Brčko distrikta BilH («Službeni glasnik Brčko distrikta BiH»,
            broj (11/14) donosi
        </div>

        <div class="naslov">
            <b>
                RJEŠENJE <br>
                O KORISTENJU GODIŠNJEG ODMORA
            </b>
        </div>

        <div class="text1">
            <ol>
                <li>
                    <b>MILANKI KEREZOVIĆ,</b> rasporedenoj na poziciji Viši stručni saradnik za ocjenjivanje u
                    Odjeljenju za stručne i administrativne poslove, Pododjeljenje za ljudske resurse, utvrduje
                    se pravo na korištenje godišnjeg odmora za 2016. godinu u trajanju od 22 radna dana.
                </li>
                <li>
                    Imenovana iz tačke 1. ovog rješenja koristit će prvi dio godišnjeg odmora u periodu od
                    15.08.2016. do 26.08.2016. godine, a preostali dio ée iskoristiti do 30.06.2017. godine u
                    skladu sa zahtjevom za godišnji odmor ovjerenim od strane neposredno pretpostavljenog.
                </li>
                <li>
                    Za vrijeme korištenja godišnjeg odmora imenovana ima pravo na osnovnu platu za odsustvo s
                    posla, a u skladu sa élanom 8. Zakona o platama zaposlenih u organima uprave Brčko distrikta BiH
                </li>
            </ol>
        </div>

        <div class="naslov">
            <b>Obrazloženje</b>
        </div>

        <div class="text1">
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            Na osnovu člana 71. i 72. Zakona o državnoj službi u organima javne uprave Brčko distrikta
            BiH, imenovanoj iz člana 1. dispozitiva ovog rješenja utvrduje se pravo na godišnji odmor u trajanju
            od 22 radna dana<br>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            U skladu sa Planom korištenja godišnjeg odmora Odjeljenja za stručne i administrativne
            poslove, broj: 33-000480/16, broj akta: 02-0578TS-0002/16 od 21.04.2016. godine, imenovana će
            koristiti godišnji odmor u periodu kako je navedeno u dispozitivu rješenja.<br>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            U skladu sa Zakonom o platama zaposlenih u organima uprave Brčko distrikta BiH.
            imenovanoj će za vrijeme korištenja godišnjeg odmora biti isplaćena osnovna plata.<br>
            <br>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            <b>Pouka o pravnom lijeku:</b><br>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            Protiv ovog rješenja može se izjaviti žalba Apelacionoj komisiji Brèko distrikta BiH u roku od
            15 dana od dana dostavljanja, a podnosi se putem ovog Odjeljenja.
        </div>

        <div class="row myfooter">
            <div class="col-6">
                Dostaviti:
                <ol>
                    <li>Imenovanoj</li>
                    <li>Odjeljenje za stručne i administrativne poslove</li>
                    <li>Pododjeljenju za ljudske resurse</li>
                    <li>Dirckciji za finansije- Odsjek za centralizovani obračun plata</li>
                    <li>Arhivi</li>
                </ol>
            </div>
            <div class="col-6 text1 text-center">
                <div class=""><b>Sef Pododjeljenja za ljudske resurse</b></div>
                <div class=" mt-4"><b>Arijana Ćulibrk, dipl. pravnik</b></div>
            </div>
        </div>
    </div>
@endsection