<?php

namespace App\Models;

use App\Models\Organizacija;
use App\Models\Updates\OrgJedinicaIzvjestaj;
use Illuminate\Database\Eloquent\Model;

class OrganizacionaJedinica extends Model
{
    //
    protected $table = 'org_jedinica';
    protected $guarded = ['id'];


    public function parent() {
        return $this->hasOne(OrganizacionaJedinica::class, 'id', 'parent_id');
    }

    public function organizacija(){
        return $this->hasOne(Organizacija::class, 'id', 'org_id');
    }

    public function radnaMjesta(){
        return $this->hasMany('App\Models\RadnoMjesto', 'id_oj');
    }

    public function childs() {
        return $this->hasMany(OrganizacionaJedinica::class, 'parent_id', 'id');
    }
    public function izvjestaj(){
        return $this->hasMany(OrgJedinicaIzvjestaj::class, 'org_jed', 'id');
    }
}
