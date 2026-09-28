<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Lecture extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * 모델 상세
     *
     * lecture_code:string 입장 코드, 서버 측 랜덤 생성
     * name:string 과목명
     * description:string 과목 소개
     * lecture_goal_desc:string 학습 목표
     * lecture_start_date:date 수강 시작 날짜
     * lecture_end_date:date 수강 종료 날짜
     * use_nickname:boolean 닉네임 사용 여부
     * use_classes:boolean 주차별 수업 안내 공개 여부
     * user_id:unsignedBigInteger 작성자 id
     * classes:json 주차별 수업 안내
     * use_evaluation:boolean 평가 방법 공개 여부
     * evaluation:json 평가 방법
     */

    protected $fillable = [
        'lecture_code', 'name', 'description', 'lecture_goal_desc', 'lecture_start_date', 'lecture_end_date', 'use_nickname',
        'use_classes', 'user_id', 'classes', 'use_evaluation', 'evaluation'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
//    protected $hidden = [
//        'password', 'remember_token',
//    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'classes' => 'object',
        'evaluation' => 'object',
    ];

    public function classes ()
    {
        return $this->hasMany(Classes::class);
    }

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function answer ()
    {
        return $this->hasMany(Answer::class);
    }

    public function members ()
    {
        return $this->hasMany(Members::class);
    }

    public function notice ()
    {
        return $this->hasMany(Notice::class);
    }

    public function archive ()
    {
        return $this->hasMany(Archive::class);
    }

    public function qna ()
    {
        return $this->hasMany(qna::class);
    }
}
