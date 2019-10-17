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
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
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
            Na osnovu člana 21. Zakona o Vladi Brčko distrikta BiH Službeni glasnik Brcko distrikta
            BH, broj. 22/18-prečišćeni tekst. 49/18, 08/19 i 10/19 člana 78. Zakona o državnoj službi u
            organima javne uprave Brčko distrikta BiH (Službeni glasnik Brčko distrikta BiH, broj 09/14
            37/15, 48 16, 09/17, 50/18 i 14 19) i člana 22. Zakona o platama i naknadama u organima javne uprave
            i institucijama Brčko distrikta BilH (Službeni glasnik Bröko distrikta BiH, broj 8/19, 10/19 i 12/19),
            Šef Odjeljenja za stručne i administrativne poslove donosi
        </div>

        <div class="naslov">
            <b>
                RJEŠENJE <br>
                O PLAĆENOM ODSUSTVU
            </b>
        </div>

        <div class="text1">
            <ol>
                <li>
                    Milanki Jovanovic, zaposlenoj u Odjeljenju za stručne i administrativne poslove, Pododjeljenu
                    za ljudske resurse, na radnom mjestu Viši strutni saradniku za ocjenjivanje, odobeava se
                    koristenje placenog odsustva u trajanju od 1 (jedan) radni dan, radi vjerskog praznika
                </li>
                <li>
                    Imenovana iz člana 1. ovog rjelenja koristit če plačeno odsustvo dana 13.09.2019. godine.
                </li>
                <li>
                    Za vrijeme korištenja plačenog odsustva imenovana ima sva peava iz radnog odnosa, kao i na
                    osnovnu platu za odsustvo s posla, a u skladu sa člana 22. Zakona o platama i naknadansa
                    organima javne uprave i institucijama Brčko distrikta BiH
                </li>
            </ol>
        </div>

        <div class="naslov">
            <b>Obrazloženje</b>
        </div>

        <div class="text1">
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            Milanka Jovanovid, zaposlena u Odjeljenju za stručne i administrativne poslove, Pododjeljenu
            za ljudske resurse, na radnom mjestu Viši stručni saradniku za ocjenjivanje, podnijela je zahtjev za
            odobravanje plaćenog odsustva. Imenovana je kao razlog za odsustvo navela vjerski prazmik, Sto je
            propisano Clanom 78. stav 1. Zakona o državnoj službi u organima javne uprave Briko distrikta BiH<br>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            U skladu sa Zakonom o platama i naknadama u organima javne uprave i institucijama Brčko
            distrikta BiH. imenovanoj ée za vrijeme korištenja navedenog odsustva biti isplaćena osnovna plata za
            odsustvo sa posla <br>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            Sef Odjeljenja za stručne i administrativne poslove ocijenio je da je zahtjev imenovane
            opravdan, te je na osnovu naprijed navedenog odluteno kao u dispozitivu rjelenja.<br>
            <br>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            <b>Pouka o pravnom lijeku:</b><br>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            Protiv ovog rjelenja može se izjaviti žalba Apelacionoj komisiji Brèko distrikta BiH u oku od
            15 dana od dana dostavljanja, a podnosi se putem ovog Odjeljenja.
        </div>

        <div class="row myfooter">
            <div class="col-6">
                Dostaviti:
                <ol>
                    <li>Imenovanoj</li>
                    <li>Pododjeljenju za ljudske resurse</li>
                    <li>Odjeljenje za stručne i administrativne poslove</li>
                    <li>Dirckciji za finansije- Odsjek za centralizovani obračun plata</li>
                    <li>Evidenciji</li>
                    <li>Arhivi</li>
                </ol>
            </div>
            <div class="col-6">
                <div class="naslov"><b>ŠEF ODJELJENJA</b></div>
                <div class="naslov mt-4"><b>Srđan Blazić</b></div>
            </div>
        </div>
    </div>
@endsection