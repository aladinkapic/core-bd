<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = "activity_logs";

    protected $fillable = [
        'user_id', 'tabela', 'old_data', 'new_data', 'broj', 'telefon', 'fax', 'web', 'email', 'check'
    ];

    public function sluzbenik(){
        return $this->hasOne('App\Models\Sluzbenik', 'id', 'user_id');
    }
}
