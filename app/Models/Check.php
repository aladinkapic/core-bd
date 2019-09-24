<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Check extends Model{

    // ** Ovdje zapisujemo sve moguće greške koje su predstavljene, te ih tako očitavamo u zavisnosti od naziva kolone ** //

    protected $errors = array( // keyword, code, message, link and special_event
        array('success'  , '0000', 'Uspjesno isprocesuirano !!', '', ''),


        /*********************** Ovdje se nalaze greške vezane za službenike   **************************/
        array('error'    , '1000', 'Postoji sluzbenik sa istim JMBG brojem !!', '', 'jmbg'),
        array('error'    , '1001', 'Postoji sluzbenik sa istim brojem licne karte', '', 'licna_karta'),


        /************************* Ovdje se nalaze greške vezane za query  *****************************/
        array('error'    , '2000', 'Greska prilikom unosa u tabelu !!', '', ''),


        /****************** Ovdje se nalaze greške vezane za kreiranje odsustva  ************************/
        array('error'    , '3000', 'Nije moguće unijeti odsustvo za prethodnu ili sljedeću godinu !!', '', ''),
    );

    /*
    |------------------------------------------------------------------------------------------------------
    | Ovaj model je kreiran da bi se mogle provjeravati jedinstvenosti kolona
    | u stvarnom vremenu. Potrebno je pozvati metodu provjeriKolonu, poslati joj
    | tri parametra:
    | 1. Naziv tabele
    | 2. Naziv kolone tabele
    | 3. Vrijednost kolone
    |
    | Očekivana vrijednost je niz, koji provjeravamo sa count() > 0 ili == 0
    |-------------------------------------------------------------------------------------------------------
    */

    public function provjeriKolonu($table, $base, $value){
        //$instance = new self();
        $this->table = $table;

        return $this->where($base, '=', $value)->get();
    }


    /*
    |------------------------------------------------------------------------------------------------------
    |
    |   Ovdje očitavamo sve greške i kreiramo odgovarajuće poruke za njih proslijeđujemo ih dalje, odnosno
    |   prepoznajemo koja je greška u pitanju u zavisnosti od toga li smo poslali naziv kolone ili smo
    |   poslali kod greške.
    |
    |   Ako pošaljemo jedan parametar, očekuje se da je to kod greške
    |   Ako pošaljemo dva (tri) parametra, prvi treba biti true (i/ili false) a drugi naziv kolone koja je smještena
    |   odnosno ako pošaljemo 'special_message', na taj način možemo modifikovati poruku i dodati još određđene parametre
    |
    |-------------------------------------------------------------------------------------------------------
    */

    public function getErrorCode($code, $column = null, $special_message = null){
        if($column and $column != 'special_message'){
            foreach($this->errors as $error){
                if($error[4] == $column) return $error;
            }
        }else{
            foreach($this->errors as $error){
                if($error[1] == $code){
                    if($column == 'special_message') $error[4] = $special_message;

                    return $error;
                }
            }
        }
    }
}
