<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObukaInstanca extends Model
{
    protected $table = "obuka_instance";

    protected $fillable = [
        'obuka_id', 'postavke', 'predavaci', 'sluzbenici', 'odrzavanje_od', 'odrzavanje_do'
    ];
}
