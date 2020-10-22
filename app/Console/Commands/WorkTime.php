<?php

namespace App\Console\Commands;

use App\Models\DummyModels\ZasnivanjeRO;
use App\Models\Sluzbenik;
use Carbon\Carbon;
use Illuminate\Console\Command;

class WorkTime extends Command{
    protected $signature = 'work:time';

    protected $description = 'Command description';

    public function __construct(){
        parent::__construct();
    }

    public function handle(){
        $sluzbenici = Sluzbenik::get(['id']);

        foreach($sluzbenici as $sluzbenik){
            if(1){ // $sluzbenik->id == 529
                $zasnivanje = ZasnivanjeRO::where('id_sluzbenika', $sluzbenik->id)->first();

                if($zasnivanje){
                    if($zasnivanje->datum_prestanka_ro == null) $datum_do = Carbon::now();
                    else $datum_do = Carbon::parse($zasnivanje->datum_prestanka_ro);

                    if($zasnivanje->datum_zasnivanja_o){
                        $datum_od = Carbon::parse($zasnivanje->datum_zasnivanja_o);

                        $total = $datum_od->diffInDays($datum_do);
                        $total = (int)($total * $zasnivanje->koeficijent) / 100;

                        $years  = (int)($total / 360);
                        $months = (int)(($total - ($years * 365)) / 30);
                        $days   = (int)(($total - ($years * 365) - ($months * 30)));

                        $zasnivanje->update([
                            'obracunati_r_s_god' => $years,
                            'obracunati_r_s_mje' => $months,
                            'obracunati_r_s_dan' => $days
                        ]);
                    }
                }
            }

        }
    }
}
