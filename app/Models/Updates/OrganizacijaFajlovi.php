<?php

namespace App\Models\Updates;

use App\Models\Organizacija;
use App\Models\Sluzbenik;
use Illuminate\Database\Eloquent\Model;

class OrganizacijaFajlovi extends Model{
    protected $table = 'organizacija_fajlovi';
    protected $guarded = ['id'];


    public function organizacija(){
        return $this->hasOne(Organizacija::class, 'id', 'organizacija_id');
    }
}
