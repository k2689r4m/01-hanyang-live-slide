<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'depth', 'qna_id', 'bundle_id', 'content', 'lock', 'user_id'
    ];

    public function qna ()
    {
        return $this->belongsTo(qna::class);
    }

    public function user ()
    {
        return $this->belongsTo(User::class);
    }
}
