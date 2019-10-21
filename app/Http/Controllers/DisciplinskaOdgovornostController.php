<?php

namespace App\Http\Controllers;

use App\Models\DisciplinskaOdgovornost;
use App\Models\DummyModels\Komisija;
use App\Models\DummyModels\Medijatori;
use App\Models\DummyModels\Suspenzija;
use App\Models\Organ;
use App\Models\Sluzbenik;
use App\Models\DummyModels\Zalbe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class DisciplinskaOdgovornostController extends Controller{
    public function index(){
        $odgovornosti = DisciplinskaOdgovornost::with('sluzbenik')
            ->with('sluzbenik.radnoMjesto');
        $odgovornosti = FilterController::filter($odgovornosti);

        $filteri = [
            'sluzbenik.ime_prezime'=>'Službenik',
            'sluzbenik.radnoMjesto.naziv_rm'=>'Radno mjesto',
            'datum_povrede'=>'Datum povrede',
            'opis_povrede'=>'Opis povrede',
            'opis_disciplinske_mjere'=>'Opis disciplinske mjere',
            'broj_rjesenja_zabrane'=>'Broj rješenja zabrane',
            'datum_rjesenja_zabrane'=>'Datum rješenja zabrane',
            'datum_zavrsetka_zabrane'=>'Datum završetka zabrane',
        ];

        return view('/hr/disciplinska_odgovornost/home', compact('odgovornosti', 'filteri'));
    }

    public function create(){
        $nizsluzbenika = Sluzbenik::select('ime', 'id', 'prezime', 'datum_rodjenja')->orderBy('ime')->get()->pluck('full_name', 'id' );
        $nizsluzbenika->prepend('Izaberite službenika', '0');

        // ** Organi javne uprave + defaultna vrijednost za organe javne uprave => Ako je 0 onda ga nema tu :) ** //
        $organi        = Organ::select('naziv', 'id')->orderBy('naziv')->get()->pluck('naziv', 'id');
        $organi->prepend('Izaberite Organ Javne uprave', '0');

        return view('/hr/disciplinska_odgovornost/add', compact('nizsluzbenika', 'organi'));
    }

    public function store(Request $request){
        $pravila = [
            "datum_povrede" => 'required',
            "broj_rjesenja_zabrane" => 'required',
        ];


        $poruke = HelpController::getValidationMessages();
        $this->validate($request, $pravila, $poruke);
        $request = HelpController::formatirajRequest($request);

        $id_disciplinske = DisciplinskaOdgovornost::create($request->except(['_method']))->id;

        /***************************************************************************************************************
         *
         *      Unos svih članova disciplinske komisije; Konvencija treba da važi : U slučaju da nije izabran ni jedan
         *      član (koji postoji u sistemu), onda je potrebno da se unese njegovo "Ime i prezime" , te
         *      "Organ Javne uprave" u kojem je on. U slučaju da to nije slučaj, neka ostane prazno :)
         *
         **************************************************************************************************************/

        for($i=1; $i<count($request->sluzbenik_id_kom); $i++){
           $komisija = DB::table('disciplinska_komisija')->insert([
               'disciplinska_odgovornost_id' => $id_disciplinske,

               'sluzbenik_id_kom'   => $request->sluzbenik_id_kom[$i],
               'sluzbenik_id_kom_e' => $request->sluzbenik_id_kom_e[$i],
               'oju_kom'            => $request->oju_kom[$i],
               'oju_kom_e'          => $request->oju_kom_e[$i],
               'created_at'         => Carbon::now(),
               'updated_at'         => Carbon::now(),
           ]);
        }

        /***************************************************************************************************************
         *
         *      Unos svih članova disciplinske komisije; Konvencija treba da važi : U slučaju da nije izabran ni jedan
         *      član (koji postoji u sistemu), onda je potrebno da se unese njegovo "Ime i prezime" , te
         *      "Organ Javne uprave" u kojem je on. U slučaju da to nije slučaj, neka ostane prazno :)
         *
         **************************************************************************************************************/

        for($i=1; $i<count($request->sluzbenik_id_med); $i++){
            $medijatori = DB::table('medijatori')->insert([
                'disciplinska_odgovornost_id' => $id_disciplinske,

                'sluzbenik_id_med'   => $request->sluzbenik_id_med[$i],
                'sluzbenik_id_med_e' => $request->sluzbenik_id_med_e[$i],
                'oju_med'            => $request->oju_med[$i],
                'oju_med_e'          => $request->oju_med_e[$i],
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ]);
        }


        return redirect('/hr/disciplinska_odgovornost/home')->with('success', __('Uspješno ste kreirali disciplinsku odgovornost!'));

    }


    public function show($id){
        $disciplinska  = DisciplinskaOdgovornost::where('id', '=', $id)->first();
        $komisije      = Komisija::where('disciplinska_odgovornost_id', '=', $id)->get();
        $medijatori    = Medijatori::where('disciplinska_odgovornost_id', '=', $id)->with('sluzbenik')->get();


        $nizsluzbenika = Sluzbenik::select('ime', 'id', 'prezime', 'datum_rodjenja')->orderBy('ime')->get()->pluck('full_name', 'id' );

        // ** Organi javne uprave + defaultna vrijednost za organe javne uprave => Ako je 0 onda ga nema tu :) ** //
        $organi        = Organ::select('naziv', 'id')->orderBy('naziv')->get()->pluck('naziv', 'id');
        $organi->prepend('Izaberite Organ Javne uprave', '0');

        $preview = true; // Čisto da bi znali jel pregledavamo ili editujemo : )


        return view('/hr/disciplinska_odgovornost/preview', compact('nizsluzbenika', 'organi', 'disciplinska', 'komisije', 'medijatori', 'preview'));
    }

    public function edit($id){
        $disciplinska  = DisciplinskaOdgovornost::where('id', '=', $id)->first();
        $komisije      = Komisija::where('disciplinska_odgovornost_id', '=', $id)->get();
        $medijatori    = Medijatori::where('disciplinska_odgovornost_id', '=', $id)->get();



        $nizsluzbenika = Sluzbenik::select('ime', 'id', 'prezime', 'datum_rodjenja')->orderBy('ime')->get()->pluck('full_name', 'id' );
        $nizsluzbenika->prepend('Izaberite službenika', '0');

        // ** Organi javne uprave + defaultna vrijednost za organe javne uprave => Ako je 0 onda ga nema tu :) ** //
        $organi        = Organ::select('naziv', 'id')->orderBy('naziv')->get()->pluck('naziv', 'id');
        $organi->prepend('Izaberite Organ Javne uprave', '0');

        return view('/hr/disciplinska_odgovornost/preview', compact('nizsluzbenika', 'organi', 'disciplinska', 'komisije', 'medijatori'));
    }

    public function update(Request $request){
        $pravila = [
            "datum_povrede" => 'required',
            "broj_rjesenja_zabrane" => 'required',
        ];



        $poruke = HelpController::getValidationMessages();
        $this->validate($request, $pravila, $poruke);
        $request = HelpController::formatirajRequest($request);
//        dd($request->all());

        DisciplinskaOdgovornost::where('id', '=', $request->disciplinska_id)->update($request->except([
            '_token',
            'disciplinska_id',
            'komisija_id',
            'sluzbenik_id_kom',
            'sluzbenik_id_kom_e',
            'oju_kom',
            'oju_kom_e',
            'medijatori_id',
            'sluzbenik_id_med',
            'sluzbenik_id_med_e',
            'oju_med',
            'oju_med_e',
        ]));

        /***************************************************************************************************************
         *
         *      Unos svih članova disciplinske komisije;
         *
         **************************************************************************************************************/



        for($i=1; $i<count($request->sluzbenik_id_kom); $i++){

            if($request->komisija_id[$i] == 'empty'){
                // Unosimo novog člana komisije
                $komisija = DB::table('disciplinska_komisija')->insert([
                    'disciplinska_odgovornost_id' => $request->disciplinska_id,

                    'sluzbenik_id_kom'   => $request->sluzbenik_id_kom[$i],
                    'sluzbenik_id_kom_e' => $request->sluzbenik_id_kom_e[$i],
                    'oju_kom'            => $request->oju_kom[$i],
                    'oju_kom_e'          => $request->oju_kom_e[$i],
                    'created_at'         => Carbon::now(),
                    'updated_at'         => Carbon::now(),
                ]);
            }else{
                $komisija = Komisija::where('id', '=', $request->komisija_id[$i])->update([
                    'sluzbenik_id_kom'   => $request->sluzbenik_id_kom[$i],
                    'sluzbenik_id_kom_e' => $request->sluzbenik_id_kom_e[$i],
                    'oju_kom'            => $request->oju_kom[$i],
                    'oju_kom_e'          => $request->oju_kom_e[$i],
                    'updated_at'         => Carbon::now(),
                ]);
            }
        }


        /***************************************************************************************************************
         *
         *      Unos svih članova medijatora;
         *
         **************************************************************************************************************/

        for($i=1; $i<count($request->sluzbenik_id_med); $i++){

            if($request->medijatori_id[$i] == 'empty'){
                // Unosimo novog člana komisije

                $medijatori = DB::table('medijatori')->insert([
                    'disciplinska_odgovornost_id' => $request->disciplinska_id,

                    'sluzbenik_id_med'   => $request->sluzbenik_id_med[$i],
                    'sluzbenik_id_med_e' => $request->sluzbenik_id_med_e[$i],
                    'oju_med'            => $request->oju_med[$i],
                    'oju_med_e'          => $request->oju_med_e[$i],
                    'created_at'         => Carbon::now(),
                    'updated_at'         => Carbon::now(),
                ]);
            }else{
                $medijatori = Medijatori::where('id', '=', $request->medijatori_id[$i])->update([
                    'sluzbenik_id_med'   => $request->sluzbenik_id_med[$i],
                    'sluzbenik_id_med_e' => $request->sluzbenik_id_med_e[$i],
                    'oju_med'            => $request->oju_med[$i],
                    'oju_med_e'          => $request->oju_med_e[$i],
                    'updated_at'         => Carbon::now(),
                ]);
            }
        }

        return redirect('/hr/disciplinska_odgovornost/home')->with('success', __('Uspješno ste kreirali disciplinsku odgovornost!'));
    }


    public function destroy($id){
        try{
            $disc = DisciplinskaOdgovornost::where('id', '=', $id)->delete();

            return back();
        }catch(\Exception $e){
            return "Greška prilikom brisanja Disciplinske odgovornost !!";
        }
    }



    /*******************************************************************************************************************
     *
     *      ŽALBE - CRUD SA ŽALBAMA
     *
     ******************************************************************************************************************/

    function pregledZalbi(){
        $zalbe = Zalbe::with('disciplinskaOdgovornost')
            ->with('disciplinskaOdgovornost.sluzbenik')
            ->with('disciplinskaOdgovornost.sluzbenik.radnoMjesto');
        $zalbe = FilterController::filter($zalbe);

        $filteri = [
            'disciplinskaOdgovornost.sluzbenik.ime_prezime'=>'Službenik',
            'disciplinskaOdgovornost.sluzbenik.radnoMjesto.naziv_rm'=>'Radno mjesto',
            'disciplinskaOdgovornost.opis_disciplinske_mjere'=>'Opis disciplinske mjere',
            'broj_ulozene_zalbe'=>'Broj uložene žalbe',
            'datum_ulozene_zalbe'=>'Datum uložene žalbe',
            'broj_odluke_zalbe'=>'Broj odluke žalbe',
            'datum_odluke_zalbe'=>'Datum odluke žalbe',
        ];
//        dd($zalbe[0]->disciplinskaOdgovornost->created_at);

        return view('hr.disciplinska_odgovornost.zalbe.pregled', compact('zalbe', 'filteri'));
    }

    public function unosZalbe(){
        $disciplinska = DisciplinskaOdgovornost::all()->pluck('opis_povrede', 'id');
        $disciplinska->prepend('Izaberite disciplinsku odgovornost', '0');

        return view('hr.disciplinska_odgovornost.zalbe.unos', compact('disciplinska'));
    }

    public function spremiZalbu(Request $request){
        $request = HelpController::formatirajRequest($request);
        try{
            Zalbe::create(
                $request->except(['_token'])
            );

            return redirect(Route('zalbe.pregled'));

        }catch(\Exception $e){
            dd($e);
        }
    }


    public function pregledajZalbu($id){
        $zalba = Zalbe::where('id', '=', $id)->first();
        $zalba['datum_ulozene_zalbe'] = HelpController::obrniDatum($zalba->datum_ulozene_zalbe);
        $zalba['datum_odluke_zalbe'] = HelpController::obrniDatum($zalba->datum_odluke_zalbe);

        $disciplinska = DisciplinskaOdgovornost::all()->pluck('opis_povrede', 'id');
        $disciplinska->prepend('Izaberite disciplinsku odgovornost', '0');
        $preview = true;

        return view('hr.disciplinska_odgovornost.zalbe.pregledaj', compact('zalba', 'disciplinska', 'preview'));
    }

    public function urediZalbu($id){
        $zalba = Zalbe::where('id', '=', $id)->first();
        $zalba['datum_ulozene_zalbe'] = HelpController::obrniDatum($zalba->datum_ulozene_zalbe);
        $zalba['datum_odluke_zalbe'] = HelpController::obrniDatum($zalba->datum_odluke_zalbe);

        $disciplinska = DisciplinskaOdgovornost::all()->pluck('opis_povrede', 'id');
        $disciplinska->prepend('Izaberite disciplinsku odgovornost', '0');

        return view('hr.disciplinska_odgovornost.zalbe.pregledaj', compact('zalba', 'disciplinska'));
    }

    public function azurirajZalbu(Request $request){
        try{
            $request = HelpController::formatirajRequest($request);


            $zalba = Zalbe::where('id', '=', $request->zalba_id)->update(
                $request->except(['_token', 'zalba_id'])
            );

            return back();

        }catch(\Exception $e){
            dd($e);
        }
    }

    public function obrisiZalbu($id){
        try{
            $suspenzija = Zalbe::where('id', '=', $id)->delete();

            return back();
        }catch(\Exception $e){
            return "Greška prilikom brisanja suspenzije !!";
        }
    }



    /*******************************************************************************************************************
     *
     *      SUSPENZIJE - CRUD SA ŽALBAMA
     *
     ******************************************************************************************************************/
    public function pregledSuspenzija(){
        $suspenzije = Suspenzija::with('disciplinskaOdgovornost')
            ->with('disciplinskaOdgovornost.sluzbenik')
            ->with('disciplinskaOdgovornost.sluzbenik.radnoMjesto');
        $suspenzije = FilterController::filter($suspenzije);

        $filteri = [
            'disciplinskaOdgovornost.sluzbenik.ime_prezime'=>'Službenik',
            'disciplinskaOdgovornost.sluzbenik.rasdnoMjesto.naziv_rm'=>'Radno mjesto',
            'disciplinskaOdgovornost.opis_disciplinske_mjere'=>'Opis disciplinske mjere',
            'broj_rjesenja'=>'Broj rješenja',
            'razlog_udaljenja'=>'Razlog udaljenja',
            'datum_udaljenja'=>'Datum udaljenja',
        ];

        return view('hr.disciplinska_odgovornost.suspenzije.pregled', compact('suspenzije', 'filteri'));
    }

    public function unosSuspenzija(){
        $disciplinska = DisciplinskaOdgovornost::all()->pluck('opis_povrede', 'id');
        $disciplinska->prepend('Izaberite disciplinsku odgovornost', '0');

        return view('hr.disciplinska_odgovornost.suspenzije.unos', compact('disciplinska'));
    }

    public function spremiSuspenziju(Request $request){
        try{
            $request = HelpController::formatirajRequest($request);
            $suspenzija = Suspenzija::create(
                $request->except('_token')
            );

            return redirect(Route('suspenzije.pregled'));

        }catch(\Exception $e){

        }
    }


    public function pregledajSuspenziju($id){
        $suspenzija = Suspenzija::where('id', '=', $id)->first();
        $suspenzija['datum_udaljenja'] = HelpController::obrniDatum($suspenzija->datum_ulozene_zalbe);


        $disciplinska = DisciplinskaOdgovornost::all()->pluck('opis_povrede', 'id');
        $disciplinska->prepend('Izaberite disciplinsku odgovornost', '0');
        $preview = true;

        return view('hr.disciplinska_odgovornost.suspenzije.unos', compact('suspenzija', 'disciplinska', 'preview'));
    }

    public function urediSuspenziju($id){
        $suspenzija = Suspenzija::where('id', '=', $id)->first();
        $suspenzija['datum_udaljenja'] = HelpController::obrniDatum($suspenzija->datum_udaljenja);



        $disciplinska = DisciplinskaOdgovornost::all()->pluck('opis_povrede', 'id');
        $disciplinska->prepend('Izaberite disciplinsku odgovornost', '0');



        return view('hr.disciplinska_odgovornost.suspenzije.unos', compact('suspenzija', 'disciplinska'));
    }

    public function azurirajSuspenziju(Request $request){
        try{
            $request = HelpController::formatirajRequest($request);

            $zalba = Suspenzija::where('id', '=', $request->zalba_id)->update(
                $request->except(['_token', 'zalba_id'])
            );

//            dd(Suspenzija::where('id', '=', $request->zalba_id)->first());

            return back();

        }catch(\Exception $e){
            dd($e);
        }
    }

    public function obrisiSuspenziju($id){

        try{
            $suspenzija = Suspenzija::where('id', '=', $id)->delete();

            return back();
        }catch(\Exception $e){
            return "Greška prilikom brisanja suspenzije !!";
        }
    }

}
