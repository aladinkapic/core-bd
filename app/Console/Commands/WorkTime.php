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
            if(1){
                $zasnivanje = ZasnivanjeRO::where('id_sluzbenika', $sluzbenik->id)->first();

                if($zasnivanje){
                    if($zasnivanje->datum_prestanka_ro == null) $datum_do = Carbon::now();
                    else $datum_do = Carbon::parse($zasnivanje->datum_prestanka_ro);

                    if($zasnivanje->datum_zasnivanja_o){
                        $datum_od = Carbon::parse($zasnivanje->datum_zasnivanja_o);
                        if($zasnivanje->koeficijent == 100){
                            $years  = $datum_od->diff($datum_do)->format('%y');
                            $months = $datum_od->diff($datum_do)->format('%m');
                            $days   = $datum_od->diff($datum_do)->format('%d');

                            $zasnivanje->update([
                                'obracunati_r_s_god' => $years,
                                'obracunati_r_s_mje' => $months,
                                'obracunati_r_s_dan' => $days
                            ]);
                        }else{
                            $total = $datum_od->diffInDays($datum_do);
                            $total = (int)($total * $zasnivanje->koeficijent) / 100;

                            $years  = (int)($total / 360);
                            $months = (int)(($total - ($years * 365)) / 30);
                            $days   = (int)(($total - ($years * 365) - ($months * 30)));


                            // $final = $datum_do->subDays($total);
                            // $years  = $final->diff($datum_od)->format('%y');
                            // $months = $final->diff($datum_od)->format('%m');
                            // $days   = $final->diff($datum_od)->format('%d');

                            // dd($total, $final, $years, $months, $days);
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
}
