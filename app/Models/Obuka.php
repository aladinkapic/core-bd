<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obuka extends Model
{
    protected $table = "obuke";

    protected $fillable = [
       'naziv', 'vrsta', 'opis', 'oblast', 'podtema', 'organizator', 'sjediste', 'zemlja_organizatora', 'pocetak', 'kraj', 'potvrda', 'datum_certifikata', 'broj_certifikata', 'finansiranje_obuke', 'stecena_znanja','broj_polaznika','predavac_id','status'
    ];
}
