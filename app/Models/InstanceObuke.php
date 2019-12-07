<?php

namespace App\Models;

use App\Models\Updates\ObukeSluzbenik;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class InstanceObuke extends Model{
    protected $table = 'obuke_nove_instance';
    protected $guarded = ['id'];

    public function predavaci(){
        return $this->hasMany(InstancePredavaci::class, 'instanca_id', 'id');
    }
    public function obuka(){
        return $this->hasOne(Obuka::class, 'id', 'obuka_id');
    }
    public function sluzbenici(){
        return $this->hasMany(ObukeSluzbenik::class, 'obuka_id', 'id');
    }

    public function pocetakObuke(){
        if(!$this->pocetak_obuke) return '';
        return Carbon::parse($this->pocetak_obuke)->format('d.m.Y');
    }
    public function krajObuke(){
        if(!$this->kraj_obuke) return '';
        return Carbon::parse($this->kraj_obuke)->format('d.m.Y');
    }
    public function datumZatvaranja(){
        if(!$this->datum_zatvaranja) return '';
        return Carbon::parse($this->datum_zatvaranja)->format('d.m.Y');
    }
}
