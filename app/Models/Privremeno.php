<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Privremeno extends Model
{
    //
    protected $table = 'ugovori_privremeni_premjestaj';
    protected $guarded = ['id'];

    public function usluzbenik(){
        return $this->hasOne(Sluzbenik::class, 'id', 'sluzbenik');
    }
}
