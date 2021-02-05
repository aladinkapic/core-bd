<?php

namespace App\Http\Controllers;
namespace App\Console\Commands;
use App\Models\DisciplinskaOdgovornost;
use App\Models\Uloge;
use App\Models\Updates\Notifikacija;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\SluzbenikController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Console\Command;
use App\Models\Sluzbenik;
use App\Notifications\NotifyMe;
use App\Notifications\DisciplinskaOdg;
use App\Notifications\StarosnaPenzija;
use App\Notifications\ZasnivanjeRO;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Faker\Provider\Uuid;
use App\Mail\Penzionisanje;


class createNotifications extends Command{
    protected $name        = 'create:Notifications';
    protected $signature   = 'create:Notifications';
    protected $description = 'First check if there is need for creating messages, and if id does, then create some !';

    public function broj_dana_izmedju($prvi_datum, $drugi_datum){
        $prvi_datum = Carbon::parse($prvi_datum);
        return $prvi_datum->diffInDays(Carbon::parse($drugi_datum));
    }

    public function __construct(){
        parent::__construct();
    }

    /*******************************************************************************************************************
     *
     *      Ovdje provjeravamo da li službenik ima doovljno staža za penzionisanje. Ako ima, kreiraj notifikaciju da
     *      je ostalo manje od 8 mjeseci za penzionisanje.
     *
     ******************************************************************************************************************/
    public function penzionisanje(){
        Session::put('_token', 'TxVramwuKWsHgYG6dpRhFUGWrNcndmCpkJPKcXRy');

        $sluzbenici = Sluzbenik::with('prethodnoRIRel')->with('zasnivanjeRORel')->get();

        foreach ($sluzbenici as $sluzbenik){
            $broj_dana_po_zasnivanju = 0;

            $date = Carbon::createFromDate( $sluzbenik->datum_rodjenja );
            $now  = Carbon::now();

            $months = $date->diffInMonths($now);
            $years_from_month = (int)($months / 12);
            $months = $months - ($years_from_month * 12);
            $years  = $date->diffInYears($now);

            if($years >= 64 and $months >= 6){
                $starosna_dob = false;

                foreach($sluzbenik->notifications as $notification){
                    if($notification->data['what'] == 'starosna_dob' and $notification->data['property_id'] == $sluzbenik->id){
                        $starosna_dob = true;
                    }
                }


                $sluzbeniciZaNotifikacije = Uloge::where('keyword', 'sluzbenici')->get(['sluzbenik_id'])->toArray();
                $users = Sluzbenik::whereIn('id', $sluzbeniciZaNotifikacije)->get();
                foreach($users as $user){
                    $user['ime_i_prezime'] = $sluzbenik->ime.' '.$sluzbenik->prezime;
                    $user['notifable_id']  = $sluzbenik->id;

                    // Sad za sad samo kreiramo notifikaciju;; Bez slanja emailvoa : )

                    try{
                        $not = Notifikacija::where('sluzbenik_id', $user->id)
                            ->where('what', 'starosna_dob')
                            ->where('to_who', $sluzbenik->id)->firstOrFail();
                    }catch (\Exception $e){
                        $notifikacija = Notifikacija::create([
                            'sluzbenik_id' => $user->id,
                            'what' => 'starosna_dob',
                            'to_who' => $sluzbenik->id,
                            'message' => $sluzbenik->ime.' '.$sluzbenik->prezime.' stiče uslove za penzionisanje za manje od 6 mjeseci !'
                        ]);
                    }
                    // $message = 'Obaviještavamo Vas da je službenik '.$sluzbenik->ime.' '.$sluzbenik->prezime.' napunio 64 godine života !';
                    // $user->notify(new StarosnaPenzija(array(' subject' => 'Obavijest o navršavanju 65 godina života.', 'from_address' => 'bot@core.bd', 'link' => 'home', 'message' => $message, 'send_email' => true)));
                }

                if(!$starosna_dob){
//                    $message = "Poštovani ".$sluzbenik->ime.' '.$sluzbenik->prezime."<br><br>";
//                    $message .= "Napunili ste 65 godina, in case you didnt' know :D   <br><br>";
//                    $message .= "Za sva ostala pitanja obratite se Pododjeljenju za ljudske resurse Vlade Bričkog Distrikta ! ";
//
//                    $sluzbenik->notify(new StarosnaPenzija(array(' subject' => 'Obavijest o navršavanju 65 godina života.', 'from_address' => 'bot@core.bd', 'link' => 'home', 'message' => $message, 'send_email' => true)));
                }
            }

            /***********************************************************************************************************
             *
             *      Ovdje dodajemo radno iskustvo koje je službenik stekao od trenutka zadnjeg zapošljenja do dašanjeg
             *      dana..
             *
             **********************************************************************************************************/


            if($sluzbenik->staz_godina > 39 and $sluzbenik->staz_mjeseci > 6){
                $sluzbeniciZaNotifikacije = Uloge::where('keyword', 'sluzbenici')->get(['sluzbenik_id'])->toArray();

                $users = Sluzbenik::whereIn('id', $sluzbeniciZaNotifikacije)->get();
                foreach($users as $user){
                    $user['ime_i_prezime'] = $sluzbenik->ime.' '.$sluzbenik->prezime;
                    $user['notifable_id']  = $sluzbenik->id;

                    // Sad za sad samo kreiramo notifikaciju;; Bez slanja emailvoa : )

                    try{
                        $not = Notifikacija::where('sluzbenik_id', $user->id)
                            ->where('what', 'radni_staz')
                            ->where('to_who', $sluzbenik->id)->firstOrFail();
                    }catch (\Exception $e){
                        $notifikacija = Notifikacija::create([
                            'sluzbenik_id' => $user->id,
                            'what' => 'radni_staz',
                            'to_who' => $sluzbenik->id,
                            'message' => $sluzbenik->ime.' '.$sluzbenik->prezime.' stiče uslove za penzionisanje za manje od 6 mjeseci !'
                        ]);
                    }
                    // $message = 'Obaviještavamo Vas da je službenik '.$sluzbenik->ime.' '.$sluzbenik->prezime.' napunio 64 godine života !';
                    // $user->notify(new StarosnaPenzija(array(' subject' => 'Obavijest o navršavanju 65 godina života.', 'from_address' => 'bot@core.bd', 'link' => 'home', 'message' => $message, 'send_email' => true)));
                }
            }
        }
    }

    /*******************************************************************************************************************
     *
     *      Obavijesti o disciplinskim odgovornostima
     *
     ******************************************************************************************************************/
    public function disciplinskaOdgovornost(){
        $danas = mktime(0,0,0, date('m'), date('d') + 15, date('Y'));
        $za15 = (date('Y-m-d', $danas));

        $odgovornosti = DisciplinskaOdgovornost::with('sluzbenik')
            ->with('sluzbenik.radnoMjesto')
            ->where('datum_zavrsetka_zabrane', '=', $za15)
            ->get();

        $sluzbeniciZaNotifikacije = Uloge::where('keyword', 'disciplinska_odg')->get(['sluzbenik_id'])->toArray();
        $users = Sluzbenik::whereIn('id', $sluzbeniciZaNotifikacije)->get();

        foreach ($odgovornosti as $odgovornost) {
            foreach($users as $user){
                try{
                    $not = Notifikacija::where('sluzbenik_id', $user->id)
                        ->where('what', 'disciplinske_odgovornosti')
                        ->where('to_who', $odgovornost->sluzbenik->id)->firstOrFail();
                }catch (\Exception $e){
                    $notifikacija = Notifikacija::create([
                        'sluzbenik_id' => $user->id,
                        'what' => 'disciplinske_odgovornosti',
                        'to_who' => $odgovornost->sluzbenik->id,
                        'message' => ':: Zabrana za službenika / cu '.$odgovornost->sluzbenik->ime.' '.$odgovornost->sluzbenik->prezime.' na osnovu disciplinskih odgovornosti ističe za 15 dana !'
                    ]);
                }
            }

//            dd($odgovornost);
//            $message = "Poštovani ".$odgovornost->sluzbenik->ime.' '.$odgovornost->sluzbenik->prezime."<br><br>";
//            $message .= "Obaviještavamo Vas da vaša disciplinska mjera ističe za 15 dana.<br><br>";
//            $message .= "Za sva ostala pitanja obratite se Vladi Brčko Distrikta koja je zaposlila ove ljude. P.S. Jesam slatki, right ? Vaš email";
//
//            $odgovornost->sluzbenik->notify(new DisciplinskaOdg(array(' subject' => 'Obavijest sa portala', 'from_address' => 'bot@core.bd', 'link' => 'home', 'message' => $message, 'send_email' => true)));
        }
    }

    /*******************************************************************************************************************
     *
     *      Računanje starosti i radnog staža službenika
     *
     ******************************************************************************************************************/

    public function starost(){
        Session::put('_token', 'TxVramwuKWsHgYG6dpRhFUGWrNcndmCpkJPKcXRy');

        $sluzbenici = Sluzbenik::with('prethodnoRIRel')->with('zasnivanjeRORel')->get();

        foreach($sluzbenici as $sluzbenik){
            try{
                $rodjenje = Carbon::createFromDate($sluzbenik->datum_rodjenja)->format('Y');
                $now = Carbon::now()->format('Y');

                $sluzbenik->update([
                    'godina' => $now-$rodjenje
                ]);

            }catch (\Exception $e){}
        }
    }

    public function handle(){
        $this->penzionisanje();
        $this->disciplinskaOdgovornost();
        $this->starost();
    }
}
