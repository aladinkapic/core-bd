<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class eKonkurs extends Model{
    protected $table = 'ekonkurs_hs'; // postavi custom tabelu za ovaj model
    protected $master_key = 'somehasputhere';

    protected $fillable = [
        'id_sluzbenika', 'id_roota'
    ];

    public function getHash(){
        return $this->master_key;
    }
}
