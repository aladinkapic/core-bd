<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MjestoRada extends Model
{
    //
    protected $table = 'ugovori_mjesto_rada';
    protected $guarded = ['id'];

    public function usluzbenik(){
        return $this->hasOne(Sluzbenik::class, 'id', 'sluzbenik');
    }
}
