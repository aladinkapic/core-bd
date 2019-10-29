<?php

namespace App\Models\Updates;

use App\Models\OrganizacionaJedinica;
use Illuminate\Database\Eloquent\Model;

class OrgJedinicaIzvjestaj extends Model{
    protected $table = "org_jedinica_izvjestaj";
    protected $guarded = ['id'];

    public function orgJedinica(){
        return $this->hasOne(OrganizacionaJedinica::class, 'id', 'org_jed');
    }
}
