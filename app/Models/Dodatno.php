<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dodatno extends Model
{
    //

    protected $table = 'ugovori_dodatne_djelatnosti';

    protected $guarded = ['id'];

    public function usluzbenik(){
        return $this->hasOne(Sluzbenik::class, 'id', 'sluzbenik');
    }
}
