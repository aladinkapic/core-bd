<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UgovoriController extends Controller
{
    public function uvjerenje_rm(){
        $withoutMenu = true;

        return view('/ugovori/uvjerenje_rm', compact('withoutMenu'));
    }
    public function placeno_odsustvo(){
        $withoutMenu = true;

        return view('/ugovori/placeno_odsustvo', compact('withoutMenu'));
    }
    public function go(){
        $withoutMenu = true;

        return view('/ugovori/go', compact('withoutMenu'));
    }
    public function rjesenje_plata(){
        $withoutMenu = true;

        return view('/ugovori/rjesenje_plata', compact('withoutMenu'));
    }
    public function prestanak_ro(){
        $withoutMenu = true;

        return view('/ugovori/prestanak_ro', compact('withoutMenu'));
    }

}
