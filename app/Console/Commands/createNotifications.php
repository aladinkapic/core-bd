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

            /***********************************************************************************************************
             *
             *      Ovdje sabiramo cjelokupno prethodno iskustvo službenika.
             *
             **********************************************************************************************************/

//            if($sluzbenik->prethodnoRIRel){
//                foreach($sluzbenik->prethodnoRIRel as $radnoIskustvo){
//                    $sluzbenik->ukupan_broj_dana += $this->broj_dana_izmedju($radnoIskustvo->period_zaposlenja_od, $radnoIskustvo->period_zaposlenja_do);
//                }
//            }

            /***********************************************************************************************************
             *
             *      Ovdje sabiramo cjelokupno prethodno iskustvo službenika.
             *
             **********************************************************************************************************/

            $date = new Carbon( $sluzbenik->datum_rodjenja );
            if((date('Y') - $date->year) >= 64){
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
                            'message' => $sluzbenik->ime.' '.$sluzbenik->prezime.' je napunio 64 godine života !'
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


                dd();
            }

            /***********************************************************************************************************
             *
             *      Ovdje dodajemo radno iskustvo koje je službenik stekao od trenutka zadnjeg zapošljenja do dašanjeg
             *      dana..
             *
             **********************************************************************************************************/

//            if($sluzbenik->zasnivanjeRORel){
//                foreach($sluzbenik->zasnivanjeRORel as $trenutno){
//                    $sluzbenik->ukupan_broj_dana += $this->broj_dana_izmedju($trenutno->datum_zasnivanja_o, Carbon::now());
//
//                    if($this->broj_dana_izmedju($trenutno->datum_zasnivanja_o, Carbon::now()) > 100){
//                        $broj_dana_po_zasnivanju = $this->broj_dana_izmedju($trenutno->datum_zasnivanja_o, Carbon::now());
//                        $zasnivanje_found = false;
//
//                        foreach($sluzbenik->notifications as $notification){
//                            if($notification->data['what'] == 'zasnivanjeRO' and $notification->data['property_id'] == $trenutno->id){
//                                $zasnivanje_found = true;
//                            }
//                        }
//
//                        if(!$zasnivanje_found){
//                            $message = "Poštovani ".$sluzbenik->ime.' '.$sluzbenik->prezime."<br><br>";
//                            $message .= "Obaviještevamo vas da ste napunili 6 mjeseci od trenutnka zasnivanja radnog odnosa. Čestitamo !  <br><br>";
//                            $message .= "Za sva ostala pitanja obratite se Pododjeljenju za ljudske resurse Vlade Bričkog Distrikta ! ";
//
//                            $sluzbenik->notify(new ZasnivanjeRO(array(' subject' => 'Obavijest o zasnivanju radnog odnosa', 'from_address' => 'bot@core.bd', 'link' => 'home', 'message' => $message, 'send_email' => true)));
//                        }
//                    }
//                }
//            }
//
//            $sluzbenik->godina  = (int)(($sluzbenik->ukupan_broj_dana / 30 / 12));
//            $sluzbenik->mjeseci = (int)(($sluzbenik->ukupan_broj_dana / 30) - ($sluzbenik->godina * 12));
//            $sluzbenik->dana    = ($sluzbenik->ukupan_broj_dana % 30);
//
//
//
//            if($sluzbenik->ukupan_broj_dana > 14160){
//                // Haman ha pa penzionisan :D
//                Sluzbenik::where('id', $sluzbenik->id)->update(['vakaz_za_penzionisanje' => 1]);
//                $sluzbenik->vakaz_za_penzionisanje = 1;
//
//                $already_got = false;
//                foreach ($sluzbenik->notifications as $notification){
//                    if($notification->data['what'] == 'penzionisanje') $already_got = true;
//                    // echo $sluzbenik->ime.' '.$notification->type.'<br>';
//                }
//
//                if(!$already_got){
//                    // Notification::send($sluzbenik   , new NotifyMe());
//                    //Notification::route('mail', 'semso@poplava.com')->notify(new NotifyMe(array('subject' => 'Notifikacija bez emaila', 'from' => 'od@koga.com', 'link' => 'home', 'message' => 'Ako ima potrebe da se piše custom poruka, ovdje se piše :DD', 'send_email' => true)));
//
//                    // Create simple custom made notifications
////                    Session::put('_token', csrf_token());
//                    // $sluzbenik->notify(new NotifyMe());
//
//                    $message = "Poštovani ".$sluzbenik->ime.' '.$sluzbenik->prezime."<br><br>";
//                    $message .= "Obaviještavamo vas da je ovo poruka samo testnog karaktera i kao takva ne treb biti shvaćena ozbiljno. U slučaju da vas stvarno zanima svrha ove poruke, obratite se njenom tvorcu koji također veze nema šta ona treba da predstavlja. Cilj pisanja ove poruke je da bi se ustanovio konzistentan template koji će se moći u opštem slučaju koristiti u mnoge svrhe. <br><br>";
//                    $message .= "Za sva ostala pitanja obratite se Vladi Brčko Distrikta koja je zaposlila ove ljude. P.S. Jesam slatki, right ? Vaš email";
//
//                    $sluzbenik->notify(new NotifyMe(array(' subject' => 'Obavijest sa portala', 'from_address' => 'bot@core.bd', 'link' => 'home', 'message' => $message, 'send_email' => true)));
//                }
//            }
        }
    }

    public function disciplinskaOdgovornost(){
        $danas = mktime(0,0,0, date('m'), date('d') + 15, date('Y'));
        $za15 = (date('Y-m-d', $danas));

        $odgovornosti = DisciplinskaOdgovornost::with('sluzbenik')
            ->with('sluzbenik.radnoMjesto')
            ->where('datum_zavrsetka_zabrane', '=', $za15)
            ->get();

        foreach ($odgovornosti as $odgovornost) {
            $message = "Poštovani ".$odgovornost->sluzbenik->ime.' '.$odgovornost->sluzbenik->prezime."<br><br>";
            $message .= "Obaviještavamo Vas da vaša disciplinska mjera ističe za 15 dana.<br><br>";
            $message .= "Za sva ostala pitanja obratite se Vladi Brčko Distrikta koja je zaposlila ove ljude. P.S. Jesam slatki, right ? Vaš email";

            $odgovornost->sluzbenik->notify(new DisciplinskaOdg(array(' subject' => 'Obavijest sa portala', 'from_address' => 'bot@core.bd', 'link' => 'home', 'message' => $message, 'send_email' => true)));
        }
    }

    public function handle(){
        $this->penzionisanje();
        // $this->disciplinskaOdgovornost();

    }
}
