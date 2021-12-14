<?php

namespace App\Console\Commands\updates;

use App\Models\OrganizacionaJedinica;
use App\Models\Updates\OrgJedinicaIzvjestaj;
use Illuminate\Console\Command;

class UpravljanjeUcinkomIzvjestaj extends Command{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upravljanje-ucinkom:izvjestaj';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Popuni zbirno informacije po organizacionim jedinicama za svaku godinu';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        $jedinice = OrganizacionaJedinica::whereHas('organizacija', function ($query){
            $query->where('active', '=', 1);
        })->with('radnaMjesta.sluzbeniciRel.sluzbenik.upravljanjeUcinkom')->get();

        for ($i = (date('Y') - 2); $i<=date('Y'); $i++){
            foreach ($jedinice as $jedinica){
                $nadmasuje = 0; $zadovoljava = 0; $ne_zadovoljava = 0; $nijeOcjenjen = 0;

                if(isset($jedinica->radnaMjesta)){
                    foreach($jedinica->radnaMjesta as $radnoMjesto){
                        if(isset($radnoMjesto->sluzbeniciRel)){
                            foreach($radnoMjesto->sluzbeniciRel as $sluzbenik){

                                // if($sluzbenik->sluzbenik_id == 429 and $i == 2020) dd($sluzbenik->sluzbenik, $jedinica);

                                if(isset($sluzbenik->sluzbenik->upravljanjeUcinkomGen)){
                                    foreach ($sluzbenik->sluzbenik->upravljanjeUcinkomGen as $ucinak){
                                        if($ucinak->godina == $i){
                                            if($ucinak->opisna_ocjena == 'Nadmašuje očekivanja') $nadmasuje ++;
                                            else if($ucinak->opisna_ocjena == 'Zadovoljava očekivanja') $zadovoljava ++;
                                            else if($ucinak->opisna_ocjena == 'Nije zadovoljio') $ne_zadovoljava ++;
                                            else $nijeOcjenjen ++;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                try{
                    // Ako pronađemo rel sa željenim rezultatima, updejtujemo, ako ne, unosimo novu
                    $rel = OrgJedinicaIzvjestaj::where('org_jed', $jedinica->id)->where('godina', $i)->firstOrFail();
                    $rel->update([
                        'ne_zadovoljava'  => $ne_zadovoljava,
                        'zadovoljava'     => $zadovoljava,
                        'nadmasuje'       => $nadmasuje,
                        'nije_ocijenjeno' => $nijeOcjenjen,
                        'ukupno'          => $ne_zadovoljava + $zadovoljava + $nadmasuje
                    ]);
                }catch (\Exception $e){
                    try{
                        OrgJedinicaIzvjestaj::create([
                            'org_jed'         => $jedinica->id,
                            'godina'          => $i,
                            'ne_zadovoljava'  => $ne_zadovoljava,
                            'zadovoljava'     => $zadovoljava,
                            'nadmasuje'       => $nadmasuje,
                            'nije_ocijenjeno' => $nijeOcjenjen,
                            'ukupno'          => $ne_zadovoljava + $zadovoljava + $nadmasuje
                        ]);
                    }catch (\Exception $e){}
                }
            }
        }
    }
}
