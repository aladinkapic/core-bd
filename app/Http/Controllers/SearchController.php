<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    //

    public static function search($data)
    {

        foreach ($data as $v) {
            if ($v['master'] == true) {
                $objekat = DB::table($v['table']);
            }
        }
        // $objekat = DB::table('');

        foreach ($data as $tabela) {

            foreach ($tabela['columns'] as $key => $value) {


                if (count($y = explode('|', $value)) > 1) {

                    $objekat->where(function ($i) use ($y, $key) {
                        $i->where($key, 'LIKE', '%' . $y[0] . '%');

                        $d = 0;

                        foreach ($y as $x) {
                            if ($d == 0) {
                                $d++;
                                continue;
                            }
                            $i->orWhere($key, 'LIKE', '%' . $x . '%');
                            $d++;
                        }
                    });

                } else {
                    dump($value);
                    $objekat->where($key, '=', $value);

                }


            }
        }

        $objekti = $objekat->get();

        dd($objekti);
    }



    public function searchUserByName(Request $request){

        $names = explode(' ', $request->ime);

//        $sluzbenici = DB::table('sluzbenici')->where(
//            function (($query) use($names){
//                $query->whereIn('ime', $names);
//                $query->orWhere(function($query) use ($names){
//                    $query->whereIn('prezime', $names)
//                });
//            });
//        );

        /*
        return DB::table('sluzbenici')->where(function($query) use ($names) {
            $query->whereIn('ime', $names);
            $query->orWhere(function($query) use ($names) {
                $query->whereIn('prezime', $names);
            });
        })->get()->toJson(); */

        return DB::table('sluzbenici')->where(function($query) use ($names) {
            $query->where('ime', 'LIKE', '%' . $names[0   ] . '%');

            $query->orWhere(function($query) use ($names) {
                $query->whereIn('prezime', $names);
            });
        })->get()->toJson();

        //$sluzbenici = DB::table('sluzbenici')->where('[ime + prezime]', 'LIKE', '%' . $request->ime . '%')->orwhere('prezime + ime', 'LIKE', '%' . $request->ime . '%')->get();

        //return $sluzbenici;
    }
}
