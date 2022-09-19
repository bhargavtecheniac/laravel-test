<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class Workshop extends Model
{

    // Workshop has one event
    public function event(){
        return $this->belongsTo(Event::class);
    }
}
