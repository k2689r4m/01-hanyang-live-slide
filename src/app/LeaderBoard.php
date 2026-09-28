<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaderBoard extends Model
{
    protected $fillable = [
        'slide_id', 'leader_data'
    ];

    public function slide ()
    {
        return $this->belongsTo(Slides::class);
    }
}
