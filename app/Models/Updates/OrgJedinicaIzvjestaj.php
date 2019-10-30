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

    public function postotakNeZadovoljava(){
        if($this->ukupno != 0) return number_format((float)($this->ne_zadovoljava / $this->ukupno) * 100, 2, '.', '');
        else return "0.00";
    }
    public function postotakZadovoljava(){
        if($this->ukupno != 0) return number_format((float)($this->zadovoljava / $this->ukupno) * 100, 2, '.', '');
        else return "0.00";
    }
    public function postotakNadmasuje(){
        if($this->ukupno != 0) return number_format((float)($this->nadmasuje / $this->ukupno) * 100, 2, '.', '');
        else return "0.00";
    }
}
