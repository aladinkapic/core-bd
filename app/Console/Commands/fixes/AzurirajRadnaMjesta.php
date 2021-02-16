<?php

namespace App\Console\Commands\fixes;

use App\Models\RadnoMjesto;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AzurirajRadnaMjesta extends Command{
    protected $signature = 'fix:radnaMjesta';

    protected $description = 'Command description';

    public function __construct(){
        parent::__construct();
    }

    public function handle(){
        $rms = RadnoMjesto::get('id');
        foreach ($rms as $rm){
            $r = RadnoMjesto::where('id', $rm->id)->first();
            $uslovi = DB::table('radno_mjesto_uslovi')->where('id_rm', '=', $rm->id)->get();

            if(count($uslovi) == 3){
                try{
                    $r->update([
                        'stepen__ss__' => $uslovi[1]->tekst_uslova,
                        'ostale_kvalifikacije' => $uslovi[2]->tekst_uslova
                    ]);
                }catch (\Exception $e){}
            }else if(count($uslovi)){
                try{
                    $r->update([
                        'stepen__ss__' => $uslovi[0]->tekst_uslova,
                        'ostale_kvalifikacije' => $uslovi[1]->tekst_uslova
                    ]);
                }catch (\Exception $e){}
            }
        }
    }
}
