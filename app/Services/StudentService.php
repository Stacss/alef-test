<?php

namespace App\Services;

use App\Student;
use Illuminate\Support\Arr;

class StudentService
{
    /**
     * Update student and class information.
     *
     * @param  Student  $student
     * @param  array  $data
     * @return void
     */
    public function updateStudent(Student $student, array $data)
    {
        $student->update(Arr::except($data, ['group_id']));

        if ($data['group_id']) {
            $student->groups()->sync([$data['group_id']]);
        }
    }
}
