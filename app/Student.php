<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'email'
    ];

    public function attendedLectures()
    {
        return $this->belongsToMany(Lecture::class, 'attended_lectures', 'student_id', 'lecture_id')->withTimestamps();
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_members', 'student_id', 'group_id')->withTimestamps();
    }
}
