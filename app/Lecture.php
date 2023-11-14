<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $fillable = ['topic', 'description'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_lecture', 'lecture_id', 'course_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_lecture', 'lecture_id', 'student_id');
    }
}
