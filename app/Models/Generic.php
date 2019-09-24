<?php

namespace App\Models;
use App;
use Illuminate\Database\Eloquent\Model;

class Generic extends Model{
    protected $table = 'sluzbenik_podaci_o_prebivalistu';
    public $prebivaliste = null;

    public function __construct($table = null){
//        $this->table = $table;

        echo "Proba  !! --";
    }



    public function dajElemente($table){
        $this->table = $table;
        return $this;
    }
}
