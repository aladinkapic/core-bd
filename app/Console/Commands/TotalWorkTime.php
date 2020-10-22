<?php

namespace App\Console\Commands;

use App\Models\DummyModels\PrethodnoRI;
use App\Models\DummyModels\ZasnivanjeRO;
use App\Models\Sluzbenik;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TotalWorkTime extends Command{
    protected $signature = 'total:worktime';
    protected $description = 'Command description';

    public function __construct(){
        parent::__construct();
    }

    public function handle(){
        $sluzbenici = Sluzbenik::get(['id']);
        foreach($sluzbenici as $sluzbenik){
            if($sluzbenik->id == 529){
                $days = 0; // Total number of days
                $prethodnoRI = PrethodnoRI::where('id_sluzbenika', $sluzbenik->id)->get();
                foreach($prethodnoRI as $ri){
                    if($ri->vrsta_staza == 2){
                        $datum_od = Carbon::parse($ri->period_zaposlenja_od);
                        $datum_do = Carbon::parse($ri->period_zaposlenja_do);

                        $thisDays = (int)(($datum_do->diffInDays($datum_od) * $ri->koeficijent) / 100);
                        $days += $thisDays;
                    }
                }

                $zasnivanje = ZasnivanjeRO::where('id_sluzbenika', $sluzbenik->id)->first();
                if($zasnivanje){
                    $datum_od = Carbon::parse($zasnivanje->datum_zasnivanja_o);
                    if($zasnivanje->datum_prestanka_ro != null) $datum_do = Carbon::parse($zasnivanje->datum_prestanka_ro);
                    else $datum_do = Carbon::now();

                    $thisDays = (int)(($datum_do->diffInDays($datum_od) * $ri->koeficijent) / 100);
                    $days += $thisDays;
                }

                $years  = (int) ($days / 360);
                $months = (int)(($days - ($years * 365)) / 30);
                $day    = (int)(($days - ($years * 365) - ($months * 30)));

                $sluzbenik->update([
                    'staz_godina' => $years,
                    'staz_mjeseci' => $months,
                    'staz_dana' =>  $day
                ]);
                dd($days);
            }
        }
    }
}
