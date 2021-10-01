<?php

namespace App\Console\Commands\updates;

use App\Models\DummyModels\ZasnivanjeRO;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ObrniDatume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'obrni:datum';

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
        $zasnivanje = ZasnivanjeRO::where('vrsta_r_o', 3)->get();

        foreach ($zasnivanje as $z){
            $datum = Carbon::parse($z->datum_zasnivanja_o);

            try{
                $z->datum_zasnivanja_o = $datum->format('Y-d-m');
                $z->save();

            }catch (\Exception $e){
                dump($e->getMessage());
            }
        }
    }
}
