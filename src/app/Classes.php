<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Classes extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'active_always', 'record_always', 'active_start_date', 'active_end_date', 'record_start_date', 'record_end_date', 'lecture_id', 'user_id','date', 'slides_num', 'user_url', 'active_member_count'
    ];

    protected $casts = [
        'slides_num' => 'object',
    ];

    public function lecture ()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function answer ()
    {
        return $this->hasMany(Answer::class);
    }

    public function slides ()
    {
        return $this->hasMany(Slides::class, 'class_id', 'id');
    }
}
