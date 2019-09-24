<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OcjenaObuke extends Model
{
    protected $table = "ocjena_obukes";

    protected $fillable = [
        'obuka_id', 'sluzbenici_id', 'ocjena'
    ];
}
