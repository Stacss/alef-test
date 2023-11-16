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
    public static function addLectureToPlan($groupId, $lectureId, $lessonNumber)
    {
        $group = Group::findOrFail($groupId);
        $existingLesson = $group->lectures()->wherePivot('lesson_number', $lessonNumber)->first();

        if ($existingLesson) {
            return ['message' => 'Lesson number already exists for this group'];
        }

        $group->lectures()->attach($lectureId, ['lesson_number' => $lessonNumber]);

        return ['message' => 'Lecture added to the plan successfully'];
    }

    /**
     * Обновляет учебный план класса, изменяя порядок или добавляя лекции.
     *
     * @param int $groupId Идентификатор класса.
     * @param int $lectureId Идентификатор лекции.
     * @param int $lessonNumber Номер урока, который нужно обновить.
     *
     * @return array Массив с сообщением о выполненной операции.
     */
    public static function updateLessonInPlan($groupId, $lectureId, $lessonNumber)
    {
        $group = Group::findOrFail($groupId);
        $existingLesson = $group->lectures()->wherePivot('lecture_id', $lectureId)->first();

        if (!$existingLesson) {
            return ['message' => 'Lecture not found in the group\'s plan'];
        }

        $existingLesson = $group->lectures()->wherePivot('lesson_number', $lessonNumber)->first();

        if ($existingLesson) {
            return ['message' => 'Lesson number already exists for this group'];
        }

        $group->lectures()->detach($lectureId);

        $group->lectures()->attach($lectureId, ['lesson_number' => $lessonNumber]);

        return ['message' => 'Lecture updated in the plan successfully'];
    }
}
