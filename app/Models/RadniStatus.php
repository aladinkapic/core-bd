<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadniStatus extends Model
{
    //
    protected $table = 'ugovori_radni_status';

    public function usluzbenik(){
        return $this->hasOne(Sluzbenik::class, 'id', 'sluzbenik');
    }
}
