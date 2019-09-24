<?php

namespace App;

use App\Models\Sluzbenik;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    //
    protected $table = 'feedbacks';

    public function sl(){
        return $this->hasOne(Sluzbenik::class, 'id', 'sluzbenik');
    }
}
