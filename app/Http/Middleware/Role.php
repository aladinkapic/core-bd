<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;       /** za kreiranje sesija **/
use Illuminate\Support\Facades\Crypt;
use App\Models\Sluzbenik;
use Closure;
use Illuminate\Support\Facades\Route;


class Role{
    protected $roles = [
        'pristup'           => 'Pristup sistemu',
        'radna_mjesta'      => 'Radna mjesta',
        'unutrasnja_org'    => 'Unutrašnja organizacija',
        'organ_ju'          => 'Organ javne uprave',
        'sluzbenici'        => 'Službenici',
        'regitar_ugovora'   => 'Registar ugovora',
        'odsustva'          => 'Odsustva',
        'upravljanje_ucin'  => 'Upravljanje učinkom',
        'disciplinska_odg'  => 'Disciplinska odgovornost',
        'ekonkurs'          => 'eKonkurs',
        'obuke'             => 'Obuke',
        'predavaci'         => 'Predavači',
        'teme_za_obuku'     => 'Teme za obuku',
        'interno_trziste'   => 'Interno tržište',
        'stratesko_pl'      => 'Strateško planiranje',
        'izvjestaji'        => 'Izvještaji',
        'historizacija'     => 'Historizacija',
        'postavke'          => 'Postavke',
     ];


    /***************************************************************************************************************** /
     *
     *      Definisanje midleware-a će biti naknadno urađeno.
     *
     *      Jedan od prijedloga je da se svakom korisniku dodijeli
     *
    /******************************************************************************************************************/

    public function handle($request, Closure $next, $keyword){
//        $action = app('request')->route()->getAction();
//
//        $route = Route::getCurrentRoute()->getActionName();


//        dd($controller);

        if(Session::has('ID')){
             $sluzbenik = Sluzbenik::where('id', Crypt::decryptString(Session::get('ID')))->with('uloge')->first();
             $found = false;

             if($sluzbenik->uloge){
                 foreach ($sluzbenik->uloge as $uloga){
                     if($uloga -> keyword == $keyword and $uloga->vrijednost){
                         $found = true;
                     }
                 }

                 if(!$found){
                     return redirect()->back();
                 }
             } else{
                 return redirect()->back();
             }


            //return $next($request);
        }else{
            return redirect('/prijava');
        }


        return $next($request); //<-- this line :)
    }
}
