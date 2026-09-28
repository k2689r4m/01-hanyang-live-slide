<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class qna extends Model
{
    protected $fillable = [
        'title', 'content', 'file', 'lecture_id', 'lock', 'user_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'file' => 'object'
    ];

    public function lecture ()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function comment () {
        return $this->hasMany(Comment::class);
    }
}
