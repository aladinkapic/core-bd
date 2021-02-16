<?php

namespace App\Console\Commands\fixes;

use App\Models\DummyModels\Obrazovanje;
use App\Models\DummyModels\StrucnaSprema;
use App\Models\Sluzbenik;
use Illuminate\Console\Command;

class AzurirajObrazovanje extends Command{
    protected $signature = 'fix:azuriraj-obrazovanje';

    protected $description = 'Command description';

    public function __construct(){
        parent::__construct();
    }
    public function handle(){
        $sluzbenici = Sluzbenik::where('id', '!=', 1)->get('id');
        foreach ($sluzbenici as $sluzbenik){
            $strucnaSprema = StrucnaSprema::where('id_sluzbenika', $sluzbenik->id)->orderBy('id')->get();
            $obrazovanje   = Obrazovanje::where('id_sluzbenika', $sluzbenik->id)->orderBy('id')->get();

            for($i=0; $i<count($strucnaSprema); $i++){
                try{
                    $obrazovanje[$i]->update([
                        'dip_poslana_na_pr' => $strucnaSprema[$i]->diploma_poslana_na_provjeru,
                        'dip_vracena_sa_pr' => $strucnaSprema[$i]->diploma_vracena_sa_provjere,
                        'datum_dostavljanja_dip' => $strucnaSprema[$i]->datum_dostavljanja_diplome,
                        'dodatak_diplomi' => $strucnaSprema[$i]->broj_obavijestenja_provjere,
                    ]);
                }catch (\Exception $e){
                    // dd($e, $strucnaSprema, $obrazovanje);
                }
            }
        }
    }
}
