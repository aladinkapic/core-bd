<?php

namespace App\Models\Updates;

use App\Models\Sluzbenik;
use Illuminate\Database\Eloquent\Model;

class ObukeSluzbenik extends Model{
    protected $table = 'obuke__sluzbenici';
    protected $guarded = ['id'];


    public function sluzbenik(){
        return $this->hasOne(Sluzbenik::class, 'id', 'sluzbenik_id');
    }
}
