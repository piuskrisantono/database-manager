<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dbrequest extends Model
{


    public $incrementing = false;
    public $primaryKey = 'servicename';

    public function user()
    {
        return $this->belongsTo('App\User', 'requestedby');
    }
}
