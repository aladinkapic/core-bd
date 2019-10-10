<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Zalba extends Model{
    protected $table = "zalba";

    protected $fillable = [
        'disciplinska_odgovornost_id', 'broj_ulozene_zalbe', 'datum_ulozene_zalbe','broj_odluke_zalbe','datum_odluke_zalbe'
    ];
}
