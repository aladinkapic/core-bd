<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Napomena extends Model{
    protected $fillable = [
        'napomena','user_id'
    ];
}
