<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class myNotifications extends Model{
    protected $table = 'notifications';
    public $incrementing = false;

    public function sluzbenik(){
        return $this->hasOne('App\Models\Sluzbenik', 'id', 'notifiable_id');
    }
}
