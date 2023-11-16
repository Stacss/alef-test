<?php
namespace App\Services;

use App\Group;

class LessonPlanService
{
    /**
     * Добавляет лекцию в учебный план группы.
     *
     * @param int $groupId - Идентификатор группы
     * @param int $lectureId - Идентификатор лекции
     * @param int $lessonNumber - Номер урока
     *
     * @return array - Результат операции
     *  - 'message' содержит информацию о результате операции
     */
    public function addLectureToPlan($groupId, $lectureId, $lessonNumber)
    {
        $group = Group::findOrFail($groupId);
        $existingLesson = $group->lectures()->wherePivot('lesson_number', $lessonNumber)->first();

        if ($existingLesson) {
            return ['message' => 'Lesson number already exists for this group'];
        }

        $group->lectures()->attach($lectureId, ['lesson_number' => $lessonNumber]);

        return ['message' => 'Lecture added to the plan successfully'];
    }
}
