<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use App\Models\Check;
use App\Models\Code;
use App\Models\DisciplinskaKomisija;
use App\Models\DisciplinskaOdgovornost;
use App\Models\Dodatno;
use App\Models\DummyModels\ClanoviPorodice;
use App\Models\DummyModels\Ispiti;
use App\Models\DummyModels\Komisija;
use App\Models\DummyModels\KontaktDetalji;
use App\Models\DummyModels\Obrazovanje;
use App\Models\DummyModels\Medijatori;
use App\Models\DummyModels\Prebivaliste;
use App\Models\DummyModels\PrestanakRO;
use App\Models\DummyModels\PrethodnoRI;
use App\Models\DummyModels\StrucnaSprema;
use App\Models\DummyModels\Vjestine;
use App\Models\DummyModels\Zalbe;
use App\Models\DummyModels\ZasnivanjeRO;
use App\Models\eKonkurs;
use App\Models\Generic;
use App\Models\InstanceObuke;
use App\Models\InstancePredavaci;
use App\Models\InstanceSluzbenici;
use App\Models\InternoTrziste;
use App\Models\Izvjestaji;
use App\Models\Kretanje;
use App\Models\MjestoRada;
use App\Models\Napomena;
use App\Models\Obavijesti;
use App\Models\Obuka;
use App\Models\ObukaInstanca;
use App\Models\OcjenaObuke;
use App\Models\Odsustva;
use App\Models\Organ;
use App\Models\Organizacija;
use App\Models\OrganizacionaJedinica;
use App\Models\Predavac;
use App\Models\Prestanak;
use App\Models\Privremeno;
use App\Models\RadniStatus;
use App\Models\RadnoMjesto;
use App\Models\RadnoMjestoSluzbenik;
use App\Models\Sifrarnik;
use App\Models\Sluzbenik;
use App\Models\StrateskoPlaniranje;
use App\Models\Suspenzija;
use App\Models\Tema;
use App\Models\Uloge;
use App\Models\Updates\Notifikacija;
use App\Models\Updates\ObukeSluzbenik;
use App\Models\Updates\OrganizacijaFajlovi;
use App\Models\Updates\OrgJedinicaIzvjestaj;
use App\Models\Updates\RadnaMjestaUslovi;
use App\Models\Uprava;
use App\Models\UpravljanjeUcinkom;
use App\Models\UpravljanjeUcinkomProbni;
use App\Models\Zalba;
use Illuminate\Console\Command;

class TruncateTables extends Command{
    protected $signature = 'truncate:tables';
    protected $description = 'Command description';

    public function __construct(){
        parent::__construct();
    }

    public function handle(){
        $model = new ClanoviPorodice();
        $model->truncate();

        $model = new Ispiti();
        $model->truncate();

        $model = new Komisija();
        $model->truncate();

        $model = new KontaktDetalji();
        $model->truncate();

        $model = new Medijatori();
        $model->truncate();

        $model = new Obrazovanje();
        $model->truncate();

        $model = new Prebivaliste();
        $model->truncate();

        $model = new PrestanakRO();
        $model->truncate();

        $model = new PrethodnoRI();
        $model->truncate();

        $model = new StrucnaSprema();
        $model->truncate();

        $model = new Suspenzija();
        $model->truncate();

        $model = new Vjestine();
        $model->truncate();

        $model = new Zalbe();
        $model->truncate();

        $model = new ZasnivanjeRO();
        $model->truncate();

        $model = new Notifikacija();
        $model->truncate();

        $model = new ObukeSluzbenik();
        $model->truncate();

        $model = new OrganizacijaFajlovi();
        $model->truncate();

        $model = new OrgJedinicaIzvjestaj();
        $model->truncate();

        $model = new RadnaMjestaUslovi();
        $model->truncate();

        $model = new ActivityLog();
        $model->truncate();

//        $model = new Check();
//        $model->truncate();

//        $model = new Code();
//        $model->truncate();

        $model = new DisciplinskaKomisija();
        $model->truncate();

        $model = new DisciplinskaOdgovornost();
        $model->truncate();

        $model = new Dodatno();
        $model->truncate();

        $model = new eKonkurs();
        $model->truncate();

        $model = new Generic();
        $model->truncate();

        $model = new InstanceObuke();
        $model->truncate();

        $model = new InstancePredavaci();
        $model->truncate();

        $model = new InstanceSluzbenici();
        $model->truncate();

        $model = new InternoTrziste();
        $model->truncate();

        $model = new Izvjestaji();
        $model->truncate();

        $model = new Kretanje();
        $model->truncate();

        $model = new MjestoRada();
        $model->truncate();

        $model = new Napomena();
        $model->truncate();

        $model = new Obavijesti();
        $model->truncate();

        $model = new Obuka();
        $model->truncate();

        $model = new ObukaInstanca();
        $model->truncate();

        $model = new OcjenaObuke();
        $model->truncate();

        $model = new Odsustva();
        $model->truncate();

        $model = new Organ();
        $model->truncate();

        $model = new Organizacija();
        $model->truncate();

        $model = new OrganizacionaJedinica();
        $model->truncate();

        $model = new Predavac();
        $model->truncate();

        $model = new Prestanak();
        $model->truncate();

        $model = new Privremeno();
        $model->truncate();

        $model = new RadniStatus();
        $model->truncate();

        $model = new RadnoMjesto();
        $model->truncate();

        $model = new RadnoMjestoSluzbenik();
        $model->truncate();

        $model = new Sifrarnik();
        $model->truncate();

        $model = new Sluzbenik();
        $model->truncate();

        $model = new StrateskoPlaniranje();
        $model->truncate();

        $model = new Suspenzija();
        $model->truncate();

        $model = new Tema();
        $model->truncate();

        $model = new Uloge();
        $model->truncate();

        $model = new Uprava();
        $model->truncate();

        $model = new UpravljanjeUcinkom();
        $model->truncate();

        $model = new UpravljanjeUcinkomProbni();
        $model->truncate();

        $model = new Zalba();
        $model->truncate();
    }
}
