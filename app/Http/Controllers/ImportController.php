<?php

namespace App\Http\Controllers;

use App\Models\DummyModels\ClanoviPorodice;
use App\Models\DummyModels\Ispiti;
use App\Models\DummyModels\Obrazovanje;
use App\Models\DummyModels\Prebivaliste;
use App\Models\DummyModels\StrucnaSprema;
use App\Models\DummyModels\ZasnivanjeRO;
use App\Models\Organ;
use App\Models\Organizacija;
use App\Models\OrganizacionaJedinica;
use App\Models\RadnoMjesto;
use App\Models\Sifrarnik;
use App\Models\Sluzbenik;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPExcel_Cell;
use PHPExcel_IOFactory;
use PhpOffice\PhpWord\IOFactory;

class ImportController extends Controller{
    //

    private function clean($string){

        $string = trim($string);
        $string = str_replace(" ", "", $string);
        $string = str_replace("\\", "", $string);
        $string = str_replace("-", "", $string);
        $string = str_replace(".", "", $string);
        $string = str_replace("/", "", $string);
        $string = str_replace("š", "", $string);
        $string = str_replace("�", "", $string);
        $string = str_replace("č", "", $string);
        $string = str_replace("ć", "", $string);
        $string = str_replace("ž", "", $string);
        $string = str_replace("đ", "", $string);
        $string = str_replace("Š", "", $string);
        $string = str_replace("�", "", $string);
        $string = str_replace("Č", "", $string);
        $string = str_replace("Ć", "", $string);
        $string = str_replace("Ž", "", $string);
        $string = str_replace("Đ", "", $string);
        $string = strtolower($string);

        return $string;
    }

    public function handle(){

        $contents = Storage::disk('local')->get('public/podaci.csv');

        $i = 0;
        foreach(explode("\r\n", $contents) as $line){



            if($i == 0){ $i++; continue; }


            $podaci = explode("\\", $line);

            $osoba = new Sluzbenik();

            $osoba->prezime = $podaci[0];
            $osoba->ime_roditelja = $podaci[1];
            $osoba->ime = $podaci[2];
            $osoba->korisnicko_ime = self::clean($podaci[2]). "." . self::clean($podaci[0]) . rand(0,9);
            $osoba->sifra = md5(rand(0,9999));
            $osoba->pin = rand(1000,9999);
            $osoba->jmbg = $podaci[3];

            $nacionalnost = 1;

            if($podaci[4] == "H") {
                $nacionalnost = 2;
            } else if($podaci[4] == "S") {
                $nacionalnost = 3;
            } else if($podaci[4] != "B") {
                $nacionalnost = 4;
            }

            $osoba->nacionalnost = $nacionalnost;
            $osoba->pol = ($podaci[5] == "M") ? 1 : 2;

            if(strtotime($podaci[6])){
                $osoba->datum_rodjenja = Carbon::parse($podaci[6]);
            } else {
                $osoba->datum_rodjenja = Carbon::parse('1900-01-01');
            }

            $osoba->mjesto_rodjenja = $podaci[7];
            $osoba->PIO = $podaci[32];

            if($podaci[38] == 'Mandat'){
                $osoba->trenutno_radi = 3;
            } else if($podaci[38] == 'Neodređeno' or $podaci[38] == 'Neodređeno vrijeme'){
                $osoba->trenutno_radi = 2;
            } else {
                $osoba->trenutno_radi = 1;
            }



            $osoba->save();

            /*
             * TODO: Privremeni premještaj
             */

            // $osoba->privremeni_premjestaj = $podaci[33];

            /*
             * Adresa boravišta
             */

            $boraviste = new Prebivaliste();

            $boraviste->id_sluzbenika = $osoba->id;
            $boraviste->mjesto_prebivalista = "/";
            $boraviste->adresa_boravista = $podaci[9] . "," . $podaci[8];
            // $osoba->adresa = $podaci[9];

            $boraviste->save();

            /*
             * Obrazovanje
             */

            $obrazovanje = new StrucnaSprema();

            $obrazovanje->stepen_s_s = preg_replace('/\s+/', ' ', $podaci[10]);
            $obrazovanje->vrsta_s_s = preg_replace('/\s+/', ' ', $podaci[11]) ;
            $obrazovanje->komenta_o_diplomi = preg_replace('/\s+/', ' ', $podaci[13]);
            $obrazovanje->obrazovna_institucija = preg_replace('/\s+/', ' ', $podaci[12]);
            $obrazovanje->datum_zavrsetka = Carbon::parse("1.1.1800");
            $obrazovanje->nostrifikacija = $podaci[14];
            $obrazovanje->id_sluzbenika = $osoba->id;
            $obrazovanje->save();



            /*
             * Ispit za rad u organima
             */

            $ispit = new Ispiti();
            $ispit->ispit_za_rad = $podaci[15];
            $ispit->pravosudni_isp = $podaci[16];
            $ispit->strucni_isp = $podaci[17];
            $ispit->id_sluzbenika = $osoba->id;
            $ispit->save();

            /*
             * Organ javne uprave, org. jedinica
             */

            $radno_mjesto_org_jedinica = 0;

            if(Organ::where('naziv', '=', $podaci[22])->get()->count() == 0){
                $organ = new Organ();
                $organ->naziv = $podaci[22];
                $organ->tip = 1;
                $organ->save();

                $organizacija = new Organizacija();
                $organizacija->naziv = "Organizacioni plan Import";
                $organizacija->pravilnik = "import";
                $organizacija->oju_id = $organ->id;
                $organizacija->active = 1;
                $organizacija->datum_od = Carbon::parse("06.08.2019.");
                $organizacija->datum_do = Carbon::parse("06.08.2029.");
                $organizacija->save();
            } else {
                $organ = Organ::where('naziv', 'LIKE', '%'. $podaci[22] . '%')->first();
                $organizacija = Organizacija::where('oju_id', '=', $organ->id)->where('active', '=', 1)->first();
            }

            if(OrganizacionaJedinica::where('naziv', '=', $podaci[23])->get()->count() == 0 && trim($podaci[23]) != "-"){
                $pododjeljenje = new OrganizacionaJedinica();
                $pododjeljenje->naziv = $podaci[23];
                $pododjeljenje->org_id = $organizacija->id;

                if(OrganizacionaJedinica::where('org_id', '=', $organizacija->id)->get()->sortBy('broj')->last()){
                    $pododjeljenje->broj = (int) OrganizacionaJedinica::where('org_id', '=', $organizacija->id)->get()->sortBy('broj')->last()->broj + 1;
                } else {
                    $pododjeljenje->broj = 1;
                }

                $pododjeljenje->tip = 1;
                $pododjeljenje->opis = "/";

                $pododjeljenje->save();

                $radno_mjesto_org_jedinica = $pododjeljenje->id;
            } else if(OrganizacionaJedinica::where('naziv', '=', $podaci[23])->get()->count() != 0  && trim($podaci[23]) != "-"){
                $pododjeljenje = OrganizacionaJedinica::where('naziv', '=', $podaci[23])->first();
                $radno_mjesto_org_jedinica = $pododjeljenje->id;
            }


            if(OrganizacionaJedinica::where('naziv', '=', $podaci[24])->get()->count() == 0 && trim($podaci[24]) != "-"){
                $sektor = new OrganizacionaJedinica();
                $sektor->naziv = $podaci[24];
                $sektor->org_id = $organizacija->id;
                $sektor->parent_id = $pododjeljenje->id;
                $sektor->opis = "/";

                $novi_broj = self::increment(OrganizacionaJedinica::where('id', '=', $pododjeljenje->id)->first());
                $sektor->broj = $novi_broj;
                $sektor->tip = 2;

                $sektor->save();

                $radno_mjesto_org_jedinica = $sektor->id;
            } else if(OrganizacionaJedinica::where('naziv', '=', $podaci[24])->get()->count() != 0  && trim($podaci[24]) != "-"){
                $sektor = OrganizacionaJedinica::where('naziv', '=', $podaci[24])->first();
                $radno_mjesto_org_jedinica = $sektor->id;
            }


            if(OrganizacionaJedinica::where('naziv', '=', $podaci[25])->get()->count() == 0  && trim($podaci[25]) != "-"){

                if(empty($sektor)) $sektor = $pododjeljenje;

                $odsjek = new OrganizacionaJedinica();
                $odsjek->naziv = $podaci[25];
                $odsjek->org_id = $organizacija->id;
                $odsjek->parent_id = $sektor->id;

                $novi_broj = self::increment(OrganizacionaJedinica::where('id', '=', $sektor->id)->first());
                $odsjek->broj = $novi_broj;
                $odsjek->tip = 3;

                $odsjek->opis = "/";

                $odsjek->save();

                $radno_mjesto_org_jedinica = $odsjek->id;
            } else if(OrganizacionaJedinica::where('naziv', '=', $podaci[25])->get()->count() != 0  && trim($podaci[25]) != "-"){
                $odsjek = OrganizacionaJedinica::where('naziv', '=', $podaci[25])->first();
                $radno_mjesto_org_jedinica = $odsjek->id;
            }

            if(OrganizacionaJedinica::where('naziv', '=', $podaci[26])->get()->count() == 0 && trim($podaci[26]) != "-"){

                if(empty($odsjek) && !empty($sektor)) $odsjek = $sektor;
                if(empty($odsjek) && empty($sektor)) $odsjek = $pododjeljenje;

                $sluzba = new OrganizacionaJedinica();
                $sluzba->naziv = $podaci[26];
                $sluzba->org_id = $organizacija->id;
                $sluzba->parent_id = $odsjek->id;

                $novi_broj = self::increment(OrganizacionaJedinica::where('id', '=', $odsjek->id)->first());
                $sluzba->broj = $novi_broj;
                $sluzba->tip = 4;

                $sluzba->opis = "/";

                $sluzba->save();

                $radno_mjesto_org_jedinica = $sluzba->id;
            } else if(OrganizacionaJedinica::where('naziv', '=', $podaci[26])->get()->count() != 0  && trim($podaci[26]) != "-"){
                $sluzba = OrganizacionaJedinica::where('naziv', '=', $podaci[26])->first();
                $radno_mjesto_org_jedinica = $sluzba->id;
            }


            /*
             * Radno Mjesto
             */
            $radno_mjesto = new RadnoMjesto();

            $radno_mjesto->naziv_rm = $podaci[18];

            if(self::stringHas($podaci[18], ["sef", "šef", "Šef", "rukovodioc", "Rukovodioc", "rukovodilac", "Rukovodilac", "direktor"])){
                $radno_mjesto->rukovodioc = 1;
            }

            $kategorija = Sifrarnik::dajInstancuByName('kategorija_radnog_mjesta', $podaci[27]);

            if($kategorija == null){

                $daj_zadnji = Sifrarnik::dajSifrarnikCollection('kategorija_radnog_mjesta')->last();
                $novi_zadnji = $daj_zadnji->value++;

                DB::table('sifrarnici')->insert([
                   'type' => 'kategorija_radnog_mjesta',
                   'value' => $novi_zadnji,
                   'name' => $podaci[27],
                ]);
                $radno_mjesto->kategorija_rm = $novi_zadnji;
            } else {

                $radno_mjesto->kategorija_rm = $kategorija->value;
            }

            $radno_mjesto->platni_razred = $podaci[28];
            $radno_mjesto->id_oj = $radno_mjesto_org_jedinica;



            $radno_mjesto->save();

            $osoba->radno_mjesto = $radno_mjesto->id;
            $osoba->save();

            DB::table('radno_mjesto_uslovi')->insert([
                'id_rm' => $radno_mjesto->id,
                'tip' => 1,
                'tekst_uslova' => $podaci[20],
                'vrijednost' => $podaci[19]
            ]);


            /*
             * Zasnivanje radnog odnosa
             */
            $zasnivanje = new ZasnivanjeRO();
            if(strtotime($podaci[29])){
                $zasnivanje->datum_zasnivanja_o = Carbon::parse($podaci[29]);
            } else {
                $zasnivanje->datum_zasnivanja_o = Carbon::now();
            }
            $zasnivanje->id_sluzbenika = $osoba->id;
            $zasnivanje->nacin_zasnivanja_r_o = 1;
            $zasnivanje->vrsta_r_o = 1;
            $zasnivanje->obracunati_r_staz = 0;
            $zasnivanje->obracunati_r_s_god = $podaci[37];
            $zasnivanje->obracunati_r_s_mje = $podaci[36];
            $zasnivanje->obracunati_r_s_dan = $podaci[35];
            $zasnivanje->napomena = $podaci[21]; // kvalifikacija_za_radno_mjesto
            $zasnivanje->save();

            /*
            $osoba->datum_prestanka_radnog_odnosa = $podaci[30];
            $osoba->osnov_prestanka_radnog_odnosa = $podaci[31];
            */

            /*
             * Djeca
             */

            if($podaci[34] != '-'){
                    $clanovi = new ClanoviPorodice();
                    $clanovi->srodstvo = 'Djeca mlađa od 7 godina';
                    $clanovi->datum_rodjenja = Carbon::parse("01.01.1900");
                    $clanovi->napomena = $podaci[34];
                    $clanovi->id_sluzbenika = $osoba->id;
                    $clanovi->save();
            }


            /*
             * Staz
             */

            /*
            $osoba->staz_dan = $podaci[35];
            $osoba->staz_mjesec = $podaci[36];
            $osoba->staz_godina = $podaci[37];
            */

            echo "Importovan " . $osoba->ime . " " . $osoba->prezime;


        }

        return "ok";

    }

    private static function glue($broj){
        $broj = explode(".", $broj);

        if(count($broj) == 1){
            return $broj[0] . ".1";
        }

        $broj[count($broj) - 1] = (int) end($broj) + 1;

        $glue = implode(".", $broj);

        return $glue;
    }

    private static function stringHas($string, $stack){

        foreach($stack as $keyword){
            if(strpos($string, $keyword) !== false){
                return true;
            }
        }

        return false;

    }

    private static function increment($broj){

        $findlast = OrganizacionaJedinica::where('parent_id', '=', $broj->id)->orderBy('id', 'DESC')->first();

        if(!empty($findlast)){
            return self::glue($findlast->broj);
        }

        return self::glue($broj->broj . ".0");

    }

    // 22 - Organ javne uprave / Institucija

    public function insert_organisation($title, $organisation, $type, $number, $parent = null){
        $number = 1;
        try{
            $pododjeljenje_m = OrganizacionaJedinica::create([
                'naziv' => $title,
                'broj' => $number,
                'org_id' => $organisation,
                'tip' => $type,
                'opis' => ' ',
                'parent_id' => $parent
            ]);

            return $pododjeljenje_m->id;
        }catch (\Exception $e){dd($e);}
    }

    public function newImport(){
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);

        $objPHPExcel = $objReader->load("pravilnici/update.xlsx");
        $objWorksheet = $objPHPExcel->getActiveSheet();

        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();


        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

        $structure = [
            'organ' => [
                'naziv' => 'Testni organ',
                'pododjeljenje' => [
                    'naziv' => 'Naziv pododjeljenja',
                    'sektor' => [
                        'naziv' => 'Naziv sektora',
                        'odsjek' => [
                            'naziv' => 'Naziv odsjeka',
                            'sluzba' => [
                                'naziv' => 'Naziv službe',
                                'radna_mjesta' => [
                                    'Prvo radno mjesto',
                                    'Drugo radno mjesto'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $organi = array();

        /*
        for ($row = 2; $row <= $highestRow; ++$row) {
            $found_organ = false;
            $organ_naziv = $objWorksheet->getCellByColumnAndRow(22, $row)->getValue();

            $ime_prezime = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue().' '.$objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
            if ($organ_naziv == 'Kancelarija gradonačelnika ') $organ_naziv = 'Kancelarija gradonačelnika';

              for ($i=0; $i<count($organi); $i++) {
                  if($organ_naziv == $organi[$i]['naziv']){
                      $found_organ = true;

                      // Pododjeljenja
                      $pododjeljenje_found = false;
                      for($j=0; $j<count($organi[$i]['pododjeljenje']); $j++){
                          if ($organi[$i]['pododjeljenje'][$j]['naziv'] == $objWorksheet->getCellByColumnAndRow(23, $row)->getValue()){
                              $pododjeljenje_found = true;
                              $sektor_found = false;
                              for($k=0; $k<count($organi[$i]['pododjeljenje'][$j]['sektor']); $k++){
                                  if($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['naziv'] == $objWorksheet->getCellByColumnAndRow(24, $row)->getValue()) $sektor_found = true;
                                  $odsjek_found = false;
                                  // Odjeljenje
                                  for($l=0; $l<count($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek']); $l++){
                                      if($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['naziv'] == $objWorksheet->getCellByColumnAndRow(25, $row)->getValue()) $odsjek_found = true;
                                      $sluzba_found = false;
                                      for($m=0; $m<count($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba']); $m++){
                                          if($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['naziv'] == $objWorksheet->getCellByColumnAndRow(26, $row)->getValue()) $sluzba_found = true;

                                          $rm_found = false;
                                          for($n=0; $n<count($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['radno_mjesto']); $n++){
                                              if($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['radno_mjesto'][$n]['naziv'] == $objWorksheet->getCellByColumnAndRow(18, $row)->getValue()) $rm_found = true;

                                              $sluzbenik_found = false;
                                              $ime_prezime = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue().' '.$objWorksheet->getCellByColumnAndRow(0, $row)->getValue();

                                              foreach(($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['radno_mjesto'][$n]['sluzbenici']) as $sluzbenik){
                                                  if($sluzbenik['ime_prezime'] == $ime_prezime) $sluzbenik_found = true;
                                              }

//                                              for($o=0; $i<count($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['radno_mjesto'][$n]['sluzbenici']); $o++){
//                                                  if(isset($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['radno_mjesto'][$n]['sluzbenici'][$o]['ime_prezime'])){
//                                                      if($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['radno_mjesto'][$n]['sluzbenici'][$o]['ime_prezime'] == $ime_prezime) $sluzbenik_found = true;
//                                                  }else{
//                                                  }
//                                              }
                                              if(!$sluzbenik_found){
                                                  array_push($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['radno_mjesto'][$n]['sluzbenici'], array('ime_prezime' => $ime_prezime));
                                              }
                                          }
                                          if(!$rm_found){
                                              array_push($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['radno_mjesto'], array('naziv' => $objWorksheet->getCellByColumnAndRow(18, $row)->getValue(), 'sluzbenici' => array()));
                                              array_push($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['radno_mjesto'][$n]['sluzbenici'], array('ime_prezime' => $ime_prezime));
                                          }
                                      }
                                      if(!$sluzba_found){
                                          array_push($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'], array('naziv' => $objWorksheet->getCellByColumnAndRow(26, $row)->getValue(), 'radno_mjesto' => array()));
                                          array_push($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][0]['radno_mjesto'], array('naziv' => $objWorksheet->getCellByColumnAndRow(18, $row)->getValue(), 'sluzbenici' => array()));
                                          array_push($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][0]['radno_mjesto'][0]['sluzbenici'], array('ime_prezime' => $ime_prezime));
                                      }
                                  }
                                  if(!$odsjek_found){
                                      array_push($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'], array('naziv' => $objWorksheet->getCellByColumnAndRow(25, $row)->getValue(), 'sluzba' => array()));
                                      array_push($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][0]['sluzba'], array('naziv' => $objWorksheet->getCellByColumnAndRow(26, $row)->getValue(), 'radno_mjesto' => array()));
                                      array_push($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][0]['sluzba'][0]['radno_mjesto'], array('naziv' => $objWorksheet->getCellByColumnAndRow(18, $row)->getValue(), 'sluzbenici' => array()));
                                      array_push($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][0]['sluzba'][0]['radno_mjesto'][0]['sluzbenici'], array('ime_prezime' => $ime_prezime));
                                  }
                              }
                              if(!$sektor_found){
                                  array_push($organi[$i]['pododjeljenje'][$j]['sektor'], array('naziv' => $objWorksheet->getCellByColumnAndRow(24, $row)->getValue(), 'odsjek' => array()));
                                  array_push($organi[$i]['pododjeljenje'][$j]['sektor'][0]['odsjek'], array('naziv' => $objWorksheet->getCellByColumnAndRow(25, $row)->getValue(), 'sluzba' => array()));
                                  array_push($organi[$i]['pododjeljenje'][$j]['sektor'][0]['odsjek'][0]['sluzba'], array('naziv' => $objWorksheet->getCellByColumnAndRow(26, $row)->getValue(), 'radno_mjesto' => array()));
                                  array_push($organi[$i]['pododjeljenje'][$j]['sektor'][0]['odsjek'][0]['sluzba'][0]['radno_mjesto'], array('naziv' => $objWorksheet->getCellByColumnAndRow(18, $row)->getValue(), 'sluzbenici' => array()));
                                  array_push($organi[$i]['pododjeljenje'][$j]['sektor'][0]['odsjek'][0]['sluzba'][0]['radno_mjesto'][0]['sluzbenici'], array('ime_prezime' => $ime_prezime));
                              }
                          }
                      }
                      if (!$pododjeljenje_found) {
                          array_push($organi[$i]['pododjeljenje'], array('naziv' => $objWorksheet->getCellByColumnAndRow(23, $row)->getValue(), 'sektor' => array()));
                          array_push($organi[$i]['pododjeljenje'][0]['sektor'], array('naziv' => $objWorksheet->getCellByColumnAndRow(24, $row)->getValue(), 'odsjek' => array()));
                          array_push($organi[$i]['pododjeljenje'][0]['sektor'][0]['odsjek'], array('naziv' => $objWorksheet->getCellByColumnAndRow(25, $row)->getValue(), 'sluzba' => array()));
                          array_push($organi[$i]['pododjeljenje'][0]['sektor'][0]['odsjek'][0]['sluzba'], array('naziv' => $objWorksheet->getCellByColumnAndRow(26, $row)->getValue(), 'radno_mjesto' => array()));
                          array_push($organi[$i]['pododjeljenje'][0]['sektor'][0]['odsjek'][0]['sluzba'][0]['radno_mjesto'], array('naziv' => $objWorksheet->getCellByColumnAndRow(18, $row)->getValue(), 'sluzbenici' => array()));
                          array_push($organi[$i]['pododjeljenje'][0]['sektor'][0]['odsjek'][0]['sluzba'][0]['radno_mjesto'][0]['sluzbenici'], array('ime_prezime' => $ime_prezime));
                      }
                  }
              }
            if(!$found_organ) {
                array_push($organi, array('naziv' => $organ_naziv, 'pododjeljenje' => array()));
            }
        }
        */

        for ($row = 2; $row <= $highestRow; ++$row) {
            $found_organ = false;
            $organ_naziv = $objWorksheet->getCellByColumnAndRow(22, $row)->getValue();
            if ($organ_naziv == 'Kancelarija gradonačelnika ') $organ_naziv = 'Kancelarija gradonačelnika';

            for ($i=0; $i<count($organi); $i++) {
                if($organ_naziv == $organi[$i]['naziv']){
                    $found_organ = true;
                }
            }
            if(!$found_organ) array_push($organi, array('naziv' => $organ_naziv, 'pododjeljenje' => array()));
        }
        for ($row = 2; $row <= $highestRow; ++$row) {
            $organ_naziv = $objWorksheet->getCellByColumnAndRow(22, $row)->getValue();
            if ($organ_naziv == 'Kancelarija gradonačelnika ') $organ_naziv = 'Kancelarija gradonačelnika';
            for ($i=0; $i<count($organi); $i++) {
                $pododjeljenje = $objWorksheet->getCellByColumnAndRow(23, $row)->getValue();
                if($pododjeljenje == null or $pododjeljenje == '-') $pododjeljenje = 'empty';

                if($organ_naziv == $organi[$i]['naziv']){
                    $pododjeljenje_found = false;
                    for($j=0; $j<count($organi[$i]['pododjeljenje']); $j++){
                        if ($organi[$i]['pododjeljenje'][$j]['naziv'] == $pododjeljenje){
                            $pododjeljenje_found = true;
                        }
                    }
                    if (!$pododjeljenje_found) {
                        array_push($organi[$i]['pododjeljenje'], array('naziv' => $pododjeljenje, 'sektor' => array()));
                    }
                }
            }
        }
        for ($row = 2; $row <= $highestRow; ++$row) {
            $organ_naziv = $objWorksheet->getCellByColumnAndRow(22, $row)->getValue();
            if ($organ_naziv == 'Kancelarija gradonačelnika ') $organ_naziv = 'Kancelarija gradonačelnika';
            for ($i=0; $i<count($organi); $i++) {
                $pododjeljenje = $objWorksheet->getCellByColumnAndRow(23, $row)->getValue();
                if($pododjeljenje == null or $pododjeljenje == '-') $pododjeljenje = 'empty';

                if($organ_naziv == $organi[$i]['naziv']){
                    for($j=0; $j<count($organi[$i]['pododjeljenje']); $j++){
                        if ($organi[$i]['pododjeljenje'][$j]['naziv'] == $pododjeljenje){

                            $sektor = $objWorksheet->getCellByColumnAndRow(24, $row)->getValue();
                            if($sektor == null or $sektor == '-') $sektor = 'empty';
                            $sektor_found = false;

                            for($k=0; $k<count($organi[$i]['pododjeljenje'][$j]['sektor']); $k++){
                                if($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['naziv'] == $sektor) $sektor_found = true;
                            }
                            if(!$sektor_found){
                                array_push($organi[$i]['pododjeljenje'][$j]['sektor'], array('naziv' => $sektor, 'odsjek' => array()));
                            }
                        }
                    }
                }
            }
        }
        for ($row = 2; $row <= $highestRow; ++$row) {
            $organ_naziv = $objWorksheet->getCellByColumnAndRow(22, $row)->getValue();
            if ($organ_naziv == 'Kancelarija gradonačelnika ') $organ_naziv = 'Kancelarija gradonačelnika';
            for ($i=0; $i<count($organi); $i++) {
                $pododjeljenje = $objWorksheet->getCellByColumnAndRow(23, $row)->getValue();
                if($pododjeljenje == null or $pododjeljenje == '-') $pododjeljenje = 'empty';

                if($organ_naziv == $organi[$i]['naziv']){
                    for($j=0; $j<count($organi[$i]['pododjeljenje']); $j++){
                        if ($organi[$i]['pododjeljenje'][$j]['naziv'] == $pododjeljenje){

                            $sektor = $objWorksheet->getCellByColumnAndRow(24, $row)->getValue();
                            if($sektor == null or $sektor == '-') $sektor = 'empty';

                            for($k=0; $k<count($organi[$i]['pododjeljenje'][$j]['sektor']); $k++) {
                                if ($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['naziv'] == $sektor){
                                    $odsjek = $objWorksheet->getCellByColumnAndRow(25, $row)->getValue();
                                    if($odsjek == null or $odsjek == '-') $odsjek = 'empty';

                                    $odsjek_found = false;
                                    for ($l = 0; $l < count($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek']); $l++) {
                                        if ($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['naziv'] == $odsjek){
                                            $odsjek_found = true;
                                        }
                                    }
                                    if(!$odsjek_found){
                                        array_push($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'], array('naziv' => $odsjek, 'sluzba' => array()));
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        for ($row = 2; $row <= $highestRow; ++$row) {
            $organ_naziv = $objWorksheet->getCellByColumnAndRow(22, $row)->getValue();
            if ($organ_naziv == 'Kancelarija gradonačelnika ') $organ_naziv = 'Kancelarija gradonačelnika';
            for ($i=0; $i<count($organi); $i++) {
                $pododjeljenje = $objWorksheet->getCellByColumnAndRow(23, $row)->getValue();
                if($pododjeljenje == null or $pododjeljenje == '-') $pododjeljenje = 'empty';

                if($organ_naziv == $organi[$i]['naziv']){
                    for($j=0; $j<count($organi[$i]['pododjeljenje']); $j++){
                        if ($organi[$i]['pododjeljenje'][$j]['naziv'] == $pododjeljenje){

                            $sektor = $objWorksheet->getCellByColumnAndRow(24, $row)->getValue();
                            if($sektor == null or $sektor == '-') $sektor = 'empty';

                            for($k=0; $k<count($organi[$i]['pododjeljenje'][$j]['sektor']); $k++) {
                                if ($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['naziv'] == $sektor){
                                    $odsjek = $objWorksheet->getCellByColumnAndRow(25, $row)->getValue();
                                    if($odsjek == null or $odsjek == '-') $odsjek = 'empty';

                                    for ($l = 0; $l < count($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek']); $l++) {
                                        if ($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['naziv'] == $odsjek) {
                                            $sluzba_found = false;
                                            $sluzba = $objWorksheet->getCellByColumnAndRow(26, $row)->getValue();
                                            if($sluzba == null or $sluzba == '-') $sluzba = 'empty';

                                            for ($m = 0; $m < count($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba']); $m++) {
                                                if ($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['naziv'] == $sluzba) {
                                                    $sluzba_found = true;
                                                }
                                            }
                                            if(!$sluzba_found){
                                                array_push($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'], array('naziv' => $sluzba, 'radno_mjesto' => array()));
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        for ($row = 2; $row <= $highestRow; ++$row) {
            $organ_naziv = $objWorksheet->getCellByColumnAndRow(22, $row)->getValue();
            if ($organ_naziv == 'Kancelarija gradonačelnika ') $organ_naziv = 'Kancelarija gradonačelnika';
            for ($i=0; $i<count($organi); $i++) {
                $pododjeljenje = $objWorksheet->getCellByColumnAndRow(23, $row)->getValue();
                if($pododjeljenje == null or $pododjeljenje == '-') $pododjeljenje = 'empty';

                if($organ_naziv == $organi[$i]['naziv']){
                    for($j=0; $j<count($organi[$i]['pododjeljenje']); $j++){
                        if ($organi[$i]['pododjeljenje'][$j]['naziv'] == $pododjeljenje){

                            $sektor = $objWorksheet->getCellByColumnAndRow(24, $row)->getValue();
                            if($sektor == null or $sektor == '-') $sektor = 'empty';

                            for($k=0; $k<count($organi[$i]['pododjeljenje'][$j]['sektor']); $k++) {
                                if ($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['naziv'] == $sektor){
                                    $odsjek = $objWorksheet->getCellByColumnAndRow(25, $row)->getValue();
                                    if($odsjek == null or $odsjek == '-') $odsjek = 'empty';

                                    for ($l = 0; $l < count($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek']); $l++) {
                                        if ($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['naziv'] == $odsjek) {
                                            $sluzba_found = false;
                                            $sluzba = $objWorksheet->getCellByColumnAndRow(26, $row)->getValue();
                                            if($sluzba == null or $sluzba == '-') $sluzba = 'empty';

                                            for ($m = 0; $m < count($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba']); $m++) {
                                                if ($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['naziv'] == $sluzba) {
                                                    $rm = $objWorksheet->getCellByColumnAndRow(18, $row)->getValue();
                                                    $rm_stepen = $objWorksheet->getCellByColumnAndRow(19, $row)->getValue();
                                                    $rm_stepen_dva = $objWorksheet->getCellByColumnAndRow(20, $row)->getValue();
                                                    $rm_kvalifikacija = $objWorksheet->getCellByColumnAndRow(21, $row)->getValue();
                                                    $rm_kategorizacija = $objWorksheet->getCellByColumnAndRow(27, $row)->getValue();
                                                    $rm_platni_razred = $objWorksheet->getCellByColumnAndRow(28, $row)->getValue();

                                                    if($rm == null or $rm == '-') $rm = 'empty';
                                                    $rm_found = false;
                                                    for($n=0; $n<count($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['radno_mjesto']); $n++) {
                                                        if ($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['radno_mjesto'][$n]['naziv'] == $objWorksheet->getCellByColumnAndRow(18, $row)->getValue()) {
                                                            $rm_found = true;
                                                        }
                                                    }

                                                    if(!$rm_found){
                                                        array_push($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['radno_mjesto'],
                                                            array(
                                                                'naziv' => $rm,
                                                                'rm_stepen' => $rm_stepen,
                                                                'rm_stepen_dva' => $rm_stepen_dva,
                                                                'kvalifikacija' => $rm_kvalifikacija,
                                                                'kategorizacija' => $rm_kategorizacija,
                                                                'platni_razred' => $rm_platni_razred,
                                                                'sluzbenici' => array()
                                                            )
                                                        );
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        for ($row = 2; $row <= $highestRow; ++$row) {
            $organ_naziv = $objWorksheet->getCellByColumnAndRow(22, $row)->getValue();
            if ($organ_naziv == 'Kancelarija gradonačelnika ') $organ_naziv = 'Kancelarija gradonačelnika';
            for ($i=0; $i<count($organi); $i++) {
                $pododjeljenje = $objWorksheet->getCellByColumnAndRow(23, $row)->getValue();
                if($pododjeljenje == null or $pododjeljenje == '-') $pododjeljenje = 'empty';

                if($organ_naziv == $organi[$i]['naziv']){
                    for($j=0; $j<count($organi[$i]['pododjeljenje']); $j++){
                        if ($organi[$i]['pododjeljenje'][$j]['naziv'] == $pododjeljenje){

                            $sektor = $objWorksheet->getCellByColumnAndRow(24, $row)->getValue();
                            if($sektor == null or $sektor == '-') $sektor = 'empty';

                            for($k=0; $k<count($organi[$i]['pododjeljenje'][$j]['sektor']); $k++) {
                                if ($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['naziv'] == $sektor){
                                    $odsjek = $objWorksheet->getCellByColumnAndRow(25, $row)->getValue();
                                    if($odsjek == null or $odsjek == '-') $odsjek = 'empty';

                                    for ($l = 0; $l < count($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek']); $l++) {
                                        if ($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['naziv'] == $odsjek) {
                                            $sluzba = $objWorksheet->getCellByColumnAndRow(26, $row)->getValue();
                                            if($sluzba == null or $sluzba == '-') $sluzba = 'empty';

                                            for ($m = 0; $m < count($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba']); $m++) {
                                                if ($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['naziv'] == $sluzba) {
                                                    $rm = $objWorksheet->getCellByColumnAndRow(18, $row)->getValue();
                                                    if($rm == null or $rm == '-') $rm = 'empty';
                                                    for($n=0; $n<count($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['radno_mjesto']); $n++) {
                                                        if ($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['radno_mjesto'][$n]['naziv'] == $rm) {
                                                            $sluzbenik_found = false;
                                                            $ime_prezime = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue().' '.$objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
                                                            $ime = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
                                                            $prezime = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
                                                            $ime_roditelja = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
                                                            $jmb = $objWorksheet->getCellByColumnAndRow(3, $row)->getValue();
                                                            $nacionalnost = $objWorksheet->getCellByColumnAndRow(4, $row)->getValue();
                                                            $pol = $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
                                                            $datum_rodjenja = $objWorksheet->getCellByColumnAndRow(6 , $row)->getValue();
                                                            $mjesto_rodjenja = $objWorksheet->getCellByColumnAndRow(7, $row)->getValue();
                                                            $mjesto_boravka = $objWorksheet->getCellByColumnAndRow(8, $row)->getValue();
                                                            $adresa = $objWorksheet->getCellByColumnAndRow(9, $row)->getValue();
                                                            $stepen = $objWorksheet->getCellByColumnAndRow(10, $row)->getValue();
                                                            $zanimanje = $objWorksheet->getCellByColumnAndRow(11, $row)->getValue();
                                                            $obrazovnaInstitucija = $objWorksheet->getCellByColumnAndRow(12, $row)->getValue();
                                                            $datum_zavrsetka = $objWorksheet->getCellByColumnAndRow(13, $row)->getValue();
                                                            $nostrifikacija = $objWorksheet->getCellByColumnAndRow(14, $row)->getValue();
                                                            $ispit_za_rad_u_organima = $objWorksheet->getCellByColumnAndRow(15, $row)->getValue();
                                                            $pravosudni_ispit = $objWorksheet->getCellByColumnAndRow(16, $row)->getValue();
                                                            $strucni_ispit = $objWorksheet->getCellByColumnAndRow(17, $row)->getValue();
                                                            $datum_zasnivanja_radnog_odnosa = $objWorksheet->getCellByColumnAndRow(29, $row)->getValue();
                                                            $datum_prestanka_ro = $objWorksheet->getCellByColumnAndRow(30, $row)->getValue();
                                                            $osnov_prestanka = $objWorksheet->getCellByColumnAndRow(31, $row)->getValue();
                                                            $pio = $objWorksheet->getCellByColumnAndRow(32, $row)->getValue();
                                                            $privremeni_premjestaj = $objWorksheet->getCellByColumnAndRow(33, $row)->getValue();
                                                            $godina_staza = $objWorksheet->getCellByColumnAndRow(35, $row)->getValue();
                                                            $mjeseci_staza = $objWorksheet->getCellByColumnAndRow(36, $row)->getValue();
                                                            $dana_staza = $objWorksheet->getCellByColumnAndRow(37, $row)->getValue();
                                                            $odredjeno_neodredjeno = $objWorksheet->getCellByColumnAndRow(38, $row)->getValue();


                                                            foreach(($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['radno_mjesto'][$n]['sluzbenici']) as $sluzbenik){
                                                                if($sluzbenik['ime_prezime'] == $ime_prezime) $sluzbenik_found = true;
                                                            }

                                                            if(!$sluzbenik_found){
                                                                array_push($organi[$i]['pododjeljenje'][$j]['sektor'][$k]['odsjek'][$l]['sluzba'][$m]['radno_mjesto'][$n]['sluzbenici'],
                                                                    array(
                                                                        'ime_prezime' => $ime_prezime,
                                                                        'ime' => $ime,
                                                                        'prezime' => $prezime,
                                                                        'ime_roditelja' => $ime_roditelja,
                                                                        'jmb' => $jmb,
                                                                        'nacionalnost' => $nacionalnost,
                                                                        'pol' => $pol,
                                                                        'datum_rodjenja' => $datum_rodjenja,
                                                                        'mjesto_rodjenja' => $mjesto_rodjenja,
                                                                        'mjesto_boravka' => $mjesto_boravka,
                                                                        'adresa' => $adresa,
                                                                        'stepen' => $stepen,
                                                                        'zanimanje' => $zanimanje,
                                                                        'obrazovna_institucija' => $obrazovnaInstitucija,
                                                                        'datum_zavrsetka' => $datum_zavrsetka,
                                                                        'nostrifikacija' => $nostrifikacija,
                                                                        'ispit_za_rad_u_organima' => $ispit_za_rad_u_organima,
                                                                        'pravosudni_ispit' => $pravosudni_ispit,
                                                                        'strucni_ispit' => $strucni_ispit,
                                                                        'datum_zasnivanja_ro' => $datum_zasnivanja_radnog_odnosa,
                                                                        'datum_prestanka_ro' => $datum_prestanka_ro,
                                                                        'osnov_prestanka' => $osnov_prestanka,
                                                                        'pio' => $pio,
                                                                        'privremeni_premjestaj' => $privremeni_premjestaj,
                                                                        'godina_staza' => (int)$godina_staza,
                                                                        'mjeseci_staza' => (int)$mjeseci_staza,
                                                                        'dana_staza' => (int)$dana_staza,
                                                                        'odredjeno_neodredjeno' => $odredjeno_neodredjeno
                                                                    )
                                                                );
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        foreach ($organi as $organ){
            $i = 1;
            try{
                $organ_m = Organ::create([
                    'naziv' => $organ['naziv'],
                ]);

                try{
                    $sist_id = Organizacija::create([
                        'naziv' => 'Migrirana sistematizacija',
                        'active' => 1,
                        'pravilnik' => 'test.pdf',
                        'datum_od' => Carbon::now()->format('Y-m-d'),
                        'datum_do' => Carbon::now()->format('Y-m-d'),
                        'oju_id' => $organ_m->id // Insert organ id
                    ]);
                }catch (\Exception $e){}
            }catch (\Exception $e){}
            foreach($organ['pododjeljenje'] as $pododjeljenje){
                $j = 1;
                $pododjeljenje_empty = false;
                if($pododjeljenje['naziv'] == 'empty') $pododjeljenje_empty = true;
                else{
                    try{
                        $pododjeljenje_id = $this->insert_organisation($pododjeljenje['naziv'], $sist_id->id, 1, $m);
                    }catch (\Exception $e){}
                }
                foreach($pododjeljenje['sektor'] as $sektor){
                    $k = 1;
                    $sektor_empty = false;

                    if($sektor['naziv'] == 'empty'){
                        $sektor_empty = true;
                    }else{
                        if($pododjeljenje_empty){
                            $sektor_id = $this->insert_organisation($sektor['naziv'], $sist_id->id, 2, $m);
                        }else{
                            $sektor_id = $this->insert_organisation($sektor['naziv'], $sist_id->id, 2, $m.'.'.$l, $pododjeljenje_id);
                        }
                    }
                    foreach($sektor['odsjek'] as $odsjek){
                        $l = 1;
                        $odsjek_empty = false;
                        if($odsjek['naziv'] == 'empty'){
                            $odsjek_empty = true;
                        }else{
                            if($sektor_empty){
                                if($pododjeljenje_empty){
                                    $odsjek_id = $this->insert_organisation($odsjek['naziv'], $sist_id->id, 3, $m);
                                }else{
                                    $odsjek_id = $this->insert_organisation($odsjek['naziv'], $sist_id->id, 3,$m.'.'.$l, $pododjeljenje_id);
                                }
                            }else{
                                $odsjek_id = $this->insert_organisation($odsjek['naziv'], $sist_id->id, 3,$m.'.'.$l.'.'.$k, $sektor_id);
                            }
                        }
                        foreach($odsjek['sluzba'] as $sluzba){
                            $sluzba_empty = false;
                            $m = 1;
                            if($sluzba['naziv'] == 'empty'){
                                $sluzba_empty = true;
                            }else{
                                if($odsjek_empty){
                                    if($sektor_empty){
                                        if($pododjeljenje_empty){
                                            $sluzba_id = $this->insert_organisation($sluzba['naziv'], $sist_id->id,4, $m);
                                        }else{
                                            $sluzba_id = $this->insert_organisation($sluzba['naziv'], $sist_id->id,4, $m.'.'.$l, $pododjeljenje_id);
                                        }
                                    }else{
                                        $sluzba_id = $this->insert_organisation($sluzba['naziv'], $sist_id->id,4,$m.'.'.$l.'.'.$k, $sektor_id);
                                    }
                                }else{
                                    $sluzba_id = $this->insert_organisation($sluzba['naziv'], $sist_id->id,4,$m.'.'.$l.'.'.$k.'.'.$j, $odsjek_id);
                                }
                            }
                            foreach($sluzba['radno_mjesto'] as $radno_mjesto){
                                if($radno_mjesto['naziv'] != 'empty'){
                                    foreach($radno_mjesto['sluzbenici'] as $sluzbenik){
                                        // dd($sluzbenik);
                                    }
                                }
                                // dd($radno_mjesto);
                            }
                            // dd($sluzba);
                            $m++;
                        }
                        // dd($odsjek);
                        $l++;
                    }
                    // dd($sektor);
                    $k++;
                }
                // dd($pododjeljenje);
                $j++;
            }
            $i++;
            dd($organ);
        }

        dd($organi[0]['pododjeljenje']);
    }
}
