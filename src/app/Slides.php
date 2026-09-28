<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slides extends Model
{
    protected $fillable = [
        'type', 'slide_content', 'available', 'order_num', 'class_id', 'user_id',
        'min_score','max_score','activation_answer','activation_time_limit','activation_score','activation_first_come','activation_layout',
    ];

    protected $casts = [
        'slide_content' => 'object',
    ];

    public function classes ()
    {
        return $this->belongsTo(Classes::class);
    }

    public function answer ()
    {
        return $this->hasMany(Answer::class, 'slide_id', 'id');
    }

    public function goodlistinfo ()
    {
        return $this->hasMany(GoodListInfo::class);
    }
}
