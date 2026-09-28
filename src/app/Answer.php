<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    protected $fillable = [
        'answer_data', 'user_id', 'lecture_id', 'class_id', 'slide_id', 'result', 'score'
    ];

    public function lecture ()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function classes ()
    {
        return $this->belongsTo(Classes::class);
    }

    public function slides ()
    {
        return $this->hasMany(Slides::class);
    }

    public function user ()
    {
        return $this->belongsTo(User::class);
    }
}
