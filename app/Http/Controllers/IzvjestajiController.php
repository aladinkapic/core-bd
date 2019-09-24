<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izvjestaji;

class IzvjestajiController extends Controller{
    public function __construct(){
        $this->middleware('role:izvjestaji');
    }



    public function pregled(){
        $izvjestaji = Izvjestaji::with('sluzbenik')->get();
        return view('izvjestaji.pregled', compact('izvjestaji'));
    }
}
