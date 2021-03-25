<?php

namespace App\Console\Commands\fixes;

use App\Models\RadnoMjesto;
use App\Models\RadnoMjestoSluzbenik;
use App\Models\Sluzbenik;
use Illuminate\Console\Command;

class deletePassive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:passive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sluzbenici = Sluzbenik::where('status', 'Pasivan')->get();
        foreach ($sluzbenici as $sl){

            $rm_s = RadnoMjestoSluzbenik::where('sluzbenik_id', $sl->sluzbenik)->get();
            foreach($rm_s as $rm){
                $radno_mjesto = RadnoMjesto::where('id', $rm->radno_mjesto_id)->with('orgjed.organizacija')->first();
                if(isset($radno_mjesto->orgjed->organizacija) and $radno_mjesto->orgjed->organizacija->active == 1){
                    $rm->delete();
                }
            }
        }
    }
}
