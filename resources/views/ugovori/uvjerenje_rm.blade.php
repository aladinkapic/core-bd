@extends('template.main')
@section('other_css_links')
    <style>
        /*UGOVORI CSS*/
        .a4 {
            width: 210mm !important;
            height: 297mm !important;
            padding: 2cm;
            margin: 1cm auto;
            margin-top: 0;
            padding-top: 1.5cm;
            font-family: "Times New Roman", Times, serif;
        }

        .vrh {
            text-align: center;
            line-height: 1.4;
            width: 100%;
            height: 12.5%;
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

        .naslov1 {
            letter-spacing: 1.4mm;
        }

        .naslov2 {
            letter-spacing: 1mm;
        }

        .naslov3 {
            letter-spacing: 0.5mm;
        }

        .linija1 {
            margin-top: 0;
            margin-bottom: 0;
            border: 0.4mm solid black;
        }

        .linija2 {
            margin-top: 0.5mm;
            margin-bottom: 0;
            border: 0.2mm solid black;
        }

        .adresa {
            text-align: center;
            line-height: 1.2;
            font-size: 2.6mm;
        }

        .info {
            margin-top: 7mm;
            font-size: 3mm;
        }

        .text1 {
            margin-top: 6mm;
            font-size: 3.5mm;
        }

        .uvjerenje {
            margin-top: 6mm;
            margin-bottom: 10mm;
            letter-spacing: 1.4mm;
            text-align: center;
            font-size: 4.5mm;
        }
        .potpis{
            margin: 35mm 10mm 0mm 50%;
            height: 30mm;
            text-align: center;
        }
        .dostavljeno{
            position: relative;
            width: 100%;
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
    </style>
@endsection
@section('content')
    <div class="a4">
        <div class="vrh">
            <div class="lijevo">
                <span class="naslov1">Босна и Херцеговина</span>
                <span class="naslov2">БРЧКО ДИСТРИКТ </span>
                <br>
                <span class="naslov2">БОСНЕ И ХЕРЦЕГОВИНЕ</span>
                <br>
                <b>
                    <span class="naslov3">Влада Брчко дистрикта</span>
                    <br>
                    <span class="naslov3">Одјељење за стручне и</span>
                    <br>
                    <span class="naslov3">административне послове</span>
                </b>
            </div>
            <div class="centar">
                <img src="images/grb.png" width="100px">
            </div>
            <div class="desno">
                <span class="naslov1">Bosna i Hercegovina</span>
                <span class="naslov2">BRČKO DISTRIKT </span>
                <br>
                <span class="naslov2">BOSNE I HERCEGOVINE</span>
                <br>
                <b>
                    <span class="naslov3">Vlada Brčko distrikta</span>
                    <br>
                    <span class="naslov3">Odjeljenje za stručne i</span>
                    <br>
                    <span class="naslov3">administrativne poslove</span>
                </b>
            </div>
        </div>

        <hr class="linija1">
        <hr class="linija2">

        <div class="adresa">
            <span>Булевар мира 1, 76100 Брчко Дистрит БиХ; Тел: 049/240-655; Фаx: 240-655; Централа:240-600, локал 653;</span>
            <br>
            <span>Bulevar mira 1, 76100 Brčko Distrit BiH; Tel: 049/240-655; Fax: 240-655; Centrala:240-600, lokal 653;</span>
        </div>

        <div class="row info">
            <div class="col-2">
                <b>Broj predmeta: <br>
                    Broj akta:<br>
                </b>
                Datum, <br>
                Mjesto,
            </div>
            <div class="col-3">
                <b>
                    33-00004/19 <br>
                    02-0368MZ-0995/19 <br>
                </b>
                02.10.2019.. godine <br>
                Brčko
            </div>
        </div>

        <div class="text1">
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            Odjeljenje za stručne i administrativne poslove, Pododjeljenje za ljudske resurse, po Ovlaštenju broj
            predmeta: 05-00007/19, broj akta: 02-0368MZ-0995/19 od 03.01.2019. godine, a na osnovu člana 156. Zakona o
            upravnom postupku-Prečišćeni text ("Sl. Glasnik Brčko distrikta BiH" broj: 48/11 i 21/18), na usmeni zahtjev
            <b>Hadžić (Mevludin) Samira,</b> izdaje
        </div>

        <div class="uvjerenje"><b>UVJERENJE</b></div>

        <div class="text1">
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            da je Hadžić (Mevludin) Samir, zaposlenik Odjeljenja za javnu bezbjednost, Pododjeljenje za zaštitu i
            spašavanje, Odsjek za zaštiu od požara i spašavanje, Profesionalna vatrogasna jedinica, na neodređeno
            vrijeme, na radnom mjestu profesionalni vatrogasac sa ispitom za rukovodioca akcije gašenja požara, od
            26.06.2019.godine.
            <br>
            <br>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            Uvjernje se izdaje u svrhu regulisanja kredita, te u druge svrhe se ne može koristiti.
        </div>

        <div class="col-4 text1 potpis">
            Stručni referent za matičnu evidenciju:
            <br>
            <br>
            Zlatko mušić
        </div>

        <div class="col-3 text1 dostavljeno">
            Dostavljeno:
            <ol>
                <li>Imenovanom</li>
                <li>Evidenciji</li>
                <li>Arhivi</li>
            </ol>
        </div>
    </div>
@endsection