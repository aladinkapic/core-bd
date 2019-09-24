<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternoTrziste extends Model{
    protected $table = 'sifrarnici'; // postavi custom tabelu za ovaj model
    protected $fillable = [
        'type', 'value', 'name'
    ];
}
