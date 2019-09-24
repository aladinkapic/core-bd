<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model{
    protected $table = "teme";

    protected $fillable = [
        'naziv', 'oblast','napomena'
    ];
}
