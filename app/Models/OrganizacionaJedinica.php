<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizacionaJedinica extends Model
{
    //
    protected $table = 'org_jedinica';


    public function parent() {
        return $this->hasOne(OrganizacionaJedinica::class, 'id', 'parent_id');
    }

    public function organizacija(){
        return $this->hasOne(Organizacija::class, 'id', 'org_id');
    }

    public function radnaMjesta(){
        return $this->hasMany('App\Models\RadnoMjesto', 'id_oj');
    }
}
