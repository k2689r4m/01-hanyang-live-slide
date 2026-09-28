<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    protected $fillable = [
        'lecture_id', 'user_id','score'
    ];

    public function lecture ()
    {
        return $this->belongsTo(Lecture::class, 'id', 'lecture_id')->select(['user_id']);
    }

    public function user ()
    {
        return $this->belongsTo(User::class);
    }
}
