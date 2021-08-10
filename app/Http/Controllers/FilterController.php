<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    //

    private static $limit = 10;

    public static function filter($query, $limit = false)
    {

        if(request()->has('limit')){
            self::$limit = request()->get('limit');
        }

        if($limit) self::$limit = $limit;

        $filters = request()->get('filter');
        $filter_values = request()->get('filter_values');

        $controller = self::class;

        if($filter_values[0] == null or $filters[0] == null){


            return $query->paginate(self::$limit);
        }


        foreach ($filters as $key => $value) {

            $temp = $value;
            $value = $filter_values[$key];
            $key = $temp;


            $exploded = explode(".", $key);

            $column = $key;


            if (count($exploded) >= 2) {
                $relation = implode(".", explode(".", $key, -1));
                $key = end($exploded);

                /*
                 * Check for relation concatenation
                 */

                $concat = explode("+", $column);


                if(count($concat) > 1){

                    $columns = "";


                    $relation1 = explode(".", $concat[0], -1);




                    foreach($concat as $rel){
                        $e = explode(".", $rel);
                        $columns .= "[" . end($e) . "]+";
                    }

                    $columns = substr($columns, 0, -1);


                    $query->whereHas($relation1[0], function ($query) use ($columns, $value, $controller) {
                        $query = self::applyFilters($query, $columns, $value, true);
                    });

                } else {
                    $query->whereHas($relation, function ($query) use ($key, $value, $controller) {
                        $query = self::applyFilters($query, $key, $value);
                    });
                }


            } else {
                $query = self::applyFilters($query, $key, $value);
            }

        }

        return $query->paginate(self::$limit);
    }

    public static function applyFilters($query, $column, $value, $raw = false)
    {



        /*
         * Extract operator
         */

        $operators = self::operators($value);

        $operator = '=';

        if (count($operators) > 0) {
            $array = explode($operators[0], $value);

            $operator = $operators[0];
            $value = $array[1];
        }


        // Trim string

        $value = trim($value);


        /*
         * ID, integers, exact numbers
         */

        if (is_numeric($value)) {
            $query->where($column, $operator, $value);

            return $query;
        }

        /*
         * Date
         */

        if (strpos($value, "..") !== false) {

            $dates = explode("..", $value);

            $query->whereBetween($column, [Carbon::parse($dates[0]), Carbon::parse($dates[1])]);

            return $query;

        }

        if (strpos($value, "|") !== false) {
            $strings = explode("|", $value);
            for($i=0; $i<count($strings); $i++){
                if($i==0) $query->whereRaw($column. " LIKE ?", ["%" . $strings[$i] . "%"]);
                else $query->orWhereRaw($column. " LIKE ?", ["%" . $strings[$i] . "%"]);
            }

            return $query;

        }

        if (self::validateDate($value)) {

            $date = Carbon::parse($value);

            $query->where($column, $operator, $date);

            return $query;
        }


        /*
         * Check for column concatenation
         */
        if($raw){

            $query->whereRaw($column. " LIKE ?", ["%" . $value . "%"]);

            return $query;

        }

        if(strpos($column, "+") !== false){

            $query->whereRaw("[ime] + [prezime] LIKE ?", ["%" . $value . "%"]);

            return $query;

        }




        $query->where($column, 'LIKE', '%' . $value . '%');

        return $query;
    }

    public static function operators($string)
    {
        $c2 = null;
        $ops = ['>=', '<=', '>', '<', '='];
        foreach ($ops as $op) {
            if (strpos($string, $op) !== false) {
                $c2 = $op;
                break;
            }
        }

        return ($c2 == null) ? [] : [$c2];


    }

    public static function validateDate($date, $format = 'd.m.Y'){

        try {
            $d = Carbon::createFromFormat($format, $date);
        } catch (\InvalidArgumentException $e){
            return false;
        }


        return ($d && $d->format($format) == $date);

    }

}
