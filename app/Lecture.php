<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function attendedBy()
    {
        return $this->belongsToMany(Student::class, 'attended_lectures', 'lecture_id', 'student_id')->withTimestamps();
    }
}
