<?php

namespace App\Http\Controllers;

use App\Mail\Penzionisanje;
use App\Models\Updates\Notifikacija;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Notifications\NotifyMe;

use App\Console\Commands\createNotifications;

use App\Models\Code;
use App\Models\Check;
use App\Models\Sluzbenik;
use App\Models\Organizacija;
use App\Models\Obuka;
use App;
use App\Models\RadnoMjesto;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Notification;
use mysql_xdevapi\Collection;
use App\Models\Obavijesti;
use PhpParser\Node\Expr\Cast\Object_;
use DateTime;

class HelpController extends Controller
{
    protected $validation_messages = [
        'required' => 'Polje :attribute je obavezno!',
        'min' => 'Minimalan  broj karaktera je :min.',
        'max' => 'Maksimalan  broj karaktera je :max.',
        'numeric' => 'Morate unjeti broj!',
        'email' => 'Molimo vas da unesete E-mail adresu u ispravnom formatu.',
        'regex' => 'Neispravan format',
        'between' => 'Molimo unesite vrijednosti između :min - :max!'
    ];

    private $sluzbenik_inst = null;


    public function __construct()
    {
        $this->sluzbenik_inst = new SluzbenikController();
    }


    public static function except($number = '404', $error_msg = 'Greška prilikom obrade zahtjeva. Molimo obratite se tehničkoj podršci !')
    {
        return view('errors.error', compact('error_msg', 'number'));
    }


    public static function dajDatum($datum){
        return Carbon::parse($datum)->format('Y-m-d');
    }

    public static function format($datum){
        return Carbon::parse($datum)->format('Y-m-d');
    }

    public static function obrniDatum($datum){
        return Carbon::parse($datum)->format('d.m.Y');
    }


    public static function check_your_datetime($x){
        return (date('d.m.Y', strtotime($x)) == $x);
    }

    public static function formatirajRequest(Request $request){
        foreach ($request->request as $req => $key) {
            if (gettype($key) === 'string') {
                if ((new self)->check_your_datetime($key)) {
                    $request[$req] = (new self)->dajDatum($key);
                }
            }
        }

        return $request;
    }


    public static function getValidationMessages(){
        $inst = new self();
        return $inst->validation_messages;
    }

    public static function breadcrumbs($data)
    {

        return view('template.snippets.breadcrumbs')->with(['data' => $data]);

    }


    public function obrisiIzBaze(Request $request)
    {
        if ($request->tabela == 'sluzbenici') {
            $sluzbenik = Sluzbenik::where('id', '=', $request->id)->first();


            $sluzbenik->radno_mjesto = null;
            $sluzbenik->save();
            return Code::generateCode(App::make('App\Models\Check')->getErrorCode('0000'));
        } else if ($request->tabela == 'disciplinska_komisija' || $request->tabela == 'medijatori') {
            DB::table($request->tabela)->delete($request->id);
            return "Uspjesno obrisano !!";
        } else {
            try {
                DB::table($request->tabela)->delete($request->id);
                return Code::generateCode(App::make('App\Models\Check')->getErrorCode('0000'));
            } catch (\Exception $e) {
                return $e;
            }
        }
    }


    /*******************************************************************************************************************
     *
     *      U ovom dijelu ćemo staviti sve rute koje nisu prethodno definisane kontroleru, kao što je prijavi me,
     *      home ruta i slično.
     *
     *      Nadalje, u ovom dijelu je potrebno napisati skripte koje će se izvršavati u tačno određeno vrijeme, jobs,
     *      konkretno skripte koje su potrebne da se kreiraju notifikacije.
     *
     *
     ******************************************************************************************************************/


    public function pocetak()
    {
        return view('welcome');
    }

    public function naslovna(){
        if (!Session::has('ID')) return redirect('/');
        $this->middleware('role:pristup');

        /***************************************************************************************************************
         *
         *      Brojači za četiri kategorije na vrhu
         *
         **************************************************************************************************************/

        $radnih_mjesta = RadnoMjesto::aktivna('id')->count();
        $sluzbenika = Sluzbenik::count();
        $broj_obuka = Obuka::all()->count();
        $interno_trzis = Organizacija::where('active', '1')->count();


        /***************************************************************************************************************
         *
         *      Obavijesti na naslovnoj stranici : )
         *      -- Ovdje ćemo krenuti pod pretpostavkom da su sve notifikacije vezane za model službenika, odnosno
         *          notifiable_type App\Models\Sluzbenik
         *
         **************************************************************************************************************/

//        $sluzbeniciRaw = DB::table('sluzbenici')
//            ->select(['sluzbenici.id'])
//            ->rightJoin('notifications', function ($param) {
//                $param->on('sluzbenici.id', '=', 'notifications.notifiable_id');
//            })
//            ->where('notifications.read_at', '=', null)
//            ->get();

        $user = Sluzbenik::where('id', Crypt::decryptString(Session::get('ID')))->first();
//        $notifications = App\myNotifications::where('notifiable_id', '=', $user->id)->where('read_at', '=', null)->with('sluzbenik')->get();

        $notifications = Notifikacija::where('sluzbenik_id', $user->id)->where('read_at', null)->with('toWho')->get();

//        dd($notifications);

//        dd($notifications);
//        foreach ($sluzbeniciRaw as $sluzbenik) {
//            array_push($sluzbenici, Sluzbenik::where('id', '=', $sluzbenik->id)->first());
//        }



        /***************************************************************************************************************
         *
         *      Notifikacije za obuke : )
         *
         **************************************************************************************************************/
        $obukeNotifikacija = [];
        $obuke = App\Models\Obuka::all('id', 'naziv');
        foreach ($obuke as $obuka) {

            $instance = App\Models\ObukaInstanca::where('obuka_id', '=', $obuka->id)->get();
            foreach ($instance as $instanca) {
                $arr = [];
                $arr['id'] = $obuka->id;
                $arr['naziv'] = $obuka->naziv;
                $arr['od'] = self::obrniDatum($instanca->odrzavanje_od);
                $arr['do'] = self::obrniDatum($instanca->odrzavanje_do);
                $arr['status'] = app('App\Http\Controllers\ObukaController')->statusDatuma($instanca->odrzavanje_od, $instanca->odrzavanje_do);
                if ($arr['status'] == 'Prije')
                    $arr['doDanas'] = ceil((strtotime($instanca->odrzavanje_od) - time()) / 86400);
                if ($arr['status'] != 'Nakon')
                    $obukeNotifikacija[] = $arr;

            }

        }
//        $s = Sluzbenik::find(1);
//
//        $sluzbenik = Sluzbenik::find(1);
//        $sluzbenik->setAttribute('nesto', 'weee');
//        $message = "Poštovani ".$sluzbenik->ime.' '.$sluzbenik->prezime."<br><br>";
//        $message .= "Obaviještavamo vas da je ovo poruka samo testnog karaktera i kao takva ne treb biti shvaćena ozbiljno. U slučaju da vas stvarno zanima svrha ove poruke, obratite se njenom tvorcu koji također veze nema šta ona treba da predstavlja. Cilj pisanja ove poruke je da bi se ustanovio konzistentan template koji će se moći u opštem slučaju koristiti u mnoge svrhe. <br><br>";
//        $message .= "Za sva ostala pitanja obratite se Vladi Brčko Distrikta koja je zaposlila ove ljude. P.S. Jesam slatki, right ? Vaš email";
//
//        $sluzbenik->notify(new NotifyMe(array(' subject' => 'Obavijest sa portala', 'from' => 'noreply@core.bd', 'link' => 'home', 'message' => $message, 'send_email' => true)));
//

        // Notification::route('mail', 'aladin.kapic@teneo.ba')
        //     ->notify(new NotifyMe());
        // $me = Sluzbenik::where('id', Crypt::decryptString(Session::get('ID')))->with('uloge')->first();

        /** Ovo izvršavati u sklopu nekog job-a **/
        //$this->kreirajNotifikacije();

        return view('home', compact('radnih_mjesta', 'sluzbenika', 'obukeNotifikacija', 'broj_obuka', 'interno_trzis', 'notifications'));
    }

    public function unistiSesije($naziv_sesije)
    {
        Session::forget($naziv_sesije);

        if (Session::has($naziv_sesije)) {
            echo Session::get($naziv_sesije);
        }
    }

    /*******************************************************************************************************************
     *
     *      Označi notifikaciju kao pročitanu - u biti postavimo datum kad je ona označena kao pročitana : )
     *
     ******************************************************************************************************************/

    public function obavijesti(){
        $user = Sluzbenik::where('id', Crypt::decryptString(Session::get('ID')))->first();

        $obavijesti = Notifikacija::where('sluzbenik_id', $user->id)->with('toWho');
        $obavijesti = FilterController::filter($obavijesti);

        $filteri = [
            'toWho.ime_prezime'=>'Ime i prezime',
            'message' => 'Sadržaj',
            'read_at' => 'Status'
        ];

        return view('ostalo.obavijesti.pregled-obavijesti', compact('obavijesti', 'filteri'));
    }

    public function oznaciKaoProcitano(Request $request)
    {
        $obavijest = Notifikacija::where('id', '=', $request->id);
        $obavijest->read_at = Carbon::now();

        try {
            Notifikacija::where('id', '=', $request->id)->update(['read_at' => Carbon::now()]);

            return Code::generateCode(App::make('App\Models\Check')->getErrorCode('0000', 'special_message', $request->id));
        } catch (\Exception $e) {
            return Code::generateCode(App::make('App\Models\Check')->getErrorCode('2000', 'special_message', $request->id));
        }
    }


    public function kreirajNotifikacije()
    {
//        $sluzbenik = Sluzbenik::find(1);
//        $message = "Poštovani ".$sluzbenik->ime.' '.$sluzbenik->prezime."<br><br>";
//        $message .= "Obaviještavamo vas da je ovo poruka samo testnog karaktera i kao takva ne treb biti shvaćena ozbiljno. U slučaju da vas stvarno zanima svrha ove poruke, obratite se njenom tvorcu koji također veze nema šta ona treba da predstavlja. Cilj pisanja ove poruke je da bi se ustanovio konzistentan template koji će se moći u opštem slučaju koristiti u mnoge svrhe. <br><br>";
//        $message .= "Za sva ostala pitanja obratite se Vladi Brčko Distrikta koja je zaposlila ove ljude. P.S. Jesam slatki, right ? Vaš email";
//
//        $sluzbenik->notify(new NotifyMe(array(' subject' => 'Obavijest sa portala', 'from' => 'noreply@core.bd', 'link' => 'home', 'message' => $message, 'send_email' => true)));

//        $not = new createNotifications();
//        $not->penzionisanje();
//
//
//        $sluzbenik = Sluzbenik::find(3);
//        $sluzbenik->notify(new NotifyMe(array(' subject' => 'Give it a little try', 'from' => 'aladin.kapic@stu.ibu.edu.ba', 'link' => 'home', 'message' => 'Ako ima potrebe da se piše custom poruka, ovdje se piše :DD', 'send_email' => true)));
//
//
//        \Mail::to($sluzbenik)->send(new Penzionisanje());
//        if( count(\Mail::failures()) > 0 ) {
//
//            echo "There was one or more failures. They were: <br />";
//
//            foreach(Mail::failures as $email_address) {
//                echo " - $email_address <br />";
//            }
//
//        } else {
//            echo "No errors, all sent successfully!";
//        }
//
//        return;
//        $sluzbenici = Sluzbenik::with('prethodnoRI')->with('zasnivanjeRO')->get();
//
//        foreach ($sluzbenici as $sluzbenik){
//
//            /***********************************************************************************************************
//             *
//             *      Ovdje sabiramo cjelokupno prethodno iskustvo službenika.
//             *
//             **********************************************************************************************************/
//
//            if($sluzbenik->prethodnoRI){
//                foreach($sluzbenik->prethodnoRI as $radnoIskustvo){
//                    $sluzbenik->ukupan_broj_dana += $this->sluzbenik_inst->broj_dana_izmedju($radnoIskustvo->period_zaposlenja_od, $radnoIskustvo->period_zaposlenja_do);
//                }
//            }
//
//            /***********************************************************************************************************
//             *
//             *      Ovdje dodajemo radno iskustvo koje je službenik stekao od trenutka zadnjeg zapošljenja do dašanjeg
//             *      dana..
//             *
//             **********************************************************************************************************/
//
//            if($sluzbenik->zasnivanjeRO){
//                foreach($sluzbenik->zasnivanjeRO as $trenutno){
//                    $sluzbenik->ukupan_broj_dana += $this->sluzbenik_inst->broj_dana_izmedju($trenutno->datum_zasnivanja_o, Carbon::now());
//                }
//            }
//
//            $sluzbenik->godina  = (int)(($sluzbenik->ukupan_broj_dana / 30 / 12));
//            $sluzbenik->mjeseci = (int)(($sluzbenik->ukupan_broj_dana / 30) - ($sluzbenik->godina * 12));
//            $sluzbenik->dana    = ($sluzbenik->ukupan_broj_dana % 30);
//
//            if($sluzbenik->ukupan_broj_dana > 14160){
//                // Haman ha pa penzionisan :D
//                Sluzbenik::where('id', $sluzbenik->id)->update(['vakaz_za_penzionisanje' => 1]);
//
//                $already_got = false;
//                foreach ($sluzbenik->notifications as $notification){
//                    if($notification->data['what'] == 'penzionisanje') $already_got = true;
//
//                    echo $sluzbenik->ime.' '.$notification->type.'<br>';
//                }
//
//                if(!$already_got) $sluzbenik->notify(new NotifyMe());
//            }
//        }


    }


    public function genericEmails()
    {

        return view('emails.generic');
    }

    /*
     *      snake case to normal formatiranje _ u space i prvo veliko slovo
     */
    public static function format_table_columns($objekat)
    {
        $app = app();
        $novi = $app->make('stdClass');
        foreach ($objekat as $key => $value) {



            if ($key === 'created_at') {
                $key = 'Kreirano';
                $value = new DateTime($value);
                $value = date_format($value, "d.m.Y H:i:s");
            }
            if ($key === 'updated_at') {
                $key = 'Uređivano';
                $value = new DateTime($value);
                $value = date_format($value, "d.m.Y H:i:s");
            }

            $key = ucfirst($key);
            $key = str_replace("_", " ", $key);
            $novi->$key = $value;
        }
        return $novi;
    }

    public static function clean($str){
        $str = str_replace("č", "c", $str);
        $str = str_replace("Č", "C", $str);
        $str = str_replace("ć", "c", $str);
        $str = str_replace("Ć", "C", $str);
        $str = str_replace("ž", "z", $str);
        $str = str_replace("Ž", "Z", $str);
        $str = str_replace("đ", "d", $str);
        $str = str_replace("Đ", "D", $str);

        return $str;
    }

    public static function generateUsername($ime, $prezime){

        $ime         = self::clean($ime);
        $prezime     = self::clean($prezime);

        $ime = str_replace("-", "", $ime);
        $ime = str_replace("/", "", $ime);
        $ime = str_replace(".", "", $ime);

        $prezime = str_replace("-", "", $prezime);
        $prezime = str_replace("/", "", $prezime);
        $prezime = str_replace(".", "", $prezime);

        $username = strtolower($ime).".".strtolower($prezime);
        $i = 0;

        while(True){
            $check = Sluzbenik::where('korisnicko_ime', '=', $username)->count();

            if($check > 0){
                $username .= $i;
            } else {
                break;
            }
            $i++;
        }
        return $username;
    }
}
