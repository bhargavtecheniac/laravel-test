<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class Event extends Model
{
    /**
     * Get the workshop for the event.
     */
    public function workshops()
    {
        return $this->hasMany(Workshop::class);
    }
    
    /**
     * Get the future workshop for the event.
     */
    public function future_workshops()
    {
        return $this->hasMany(Workshop::class)->where('start', '>=', Carbon::today());
    }
}
