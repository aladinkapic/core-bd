<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PodrskaController extends Controller
{
    public function administratorska_uputstva(){
        return(view('podrska/administratorska_uputstva'));

    }

    public function korisnicka_uputstva(){
        return(view('podrska/korisnicka_uputstva'));
    }
}
