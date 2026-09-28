<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodListInfo extends Model
{
    protected $fillable = [
        'flag_num', 'slide_id', 'user_id'
    ];

    public function slides ()
    {
        return $this->belongsTo(Slides::class);
    }
}
