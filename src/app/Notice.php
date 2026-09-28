<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'title', 'content', 'file', 'lecture_id',
    ];

    protected $casts = [
        'file' => 'object'
    ];

    public function lecture ()
    {
        return $this->belongsTo(Lecture::class);
    }
}
