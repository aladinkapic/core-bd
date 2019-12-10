<?php

namespace App\Models\Updates;

use App\Models\Sluzbenik;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Notifikacija extends Model{
    protected $table = 'notifikacije';
    protected $guarded = ['id'];

    public function toWho(){
        return $this->hasOne(Sluzbenik::class, 'id', 'to_who');
    }

    public function readAt(){
        if(!$this->read_at) return 'Aktivna';
        return Carbon::parse($this->read_at)->format('d.m.Y');
    }
}
