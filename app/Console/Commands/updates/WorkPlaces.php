<?php

namespace App\Console\Commands\updates;

use App\Models\RadnoMjesto;
use Illuminate\Console\Command;

class WorkPlaces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workplace:no-of-employees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update number of employees at workplace';

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
        $radna_mjesta = RadnoMjesto::with('orgjed.organizacija.organ')->with('sluzbeniciRel')->get();

        foreach ($radna_mjesta as $rm){
            try{
                $rm->update([
                    'uposlenika' => count($rm->sluzbeniciRel),
                    'izvrsilaca' => (int)$rm->broj_izvrsilaca
                ]);
            }catch (\Exception $e){}
        }
    }
}
