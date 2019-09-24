<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uprava extends Model{
    protected $table = "organ_ju";

    protected $fillable = [
        'tin', 'naziv', 'tip', 'ulica', 'broj', 'telefon', 'fax', 'web', 'email', 'check'
    ];
}
