<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'email',
        'class_id'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lectures()
    {
        return $this->belongsToMany(Lecture::class, 'student_lecture', 'student_id', 'lecture_id');
    }
}
