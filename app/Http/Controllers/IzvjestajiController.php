<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izvjestaji;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class IzvjestajiController extends Controller{
    public function __construct(){
        $this->middleware('role:izvjestaji');
    }



    public function pregled(){
        $izvjestaji = Izvjestaji::where('id_sluzbenika', Crypt::decryptString(Session::get('ID')));
        $izvjestaji = FilterController::filter($izvjestaji);

        $filteri = [
            "naziv_korisnicki" => "Naziv izvještaja",
            "created_at" => "Datum",
        ];

        return view('izvjestaji.pregled', compact('izvjestaji', 'filteri'));
    }
}
