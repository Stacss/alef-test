<?php
namespace App\Services;

use App\Group;

class LessonPlanService
{
    /**
     * Adds a lecture to the group's curriculum.
     *
     * @param int $groupId - Group identifier
     * @param int $lectureId - Lecture identifier
     * @param int $lessonNumber - Lesson number
     *
     * @return array - Operation result
     *  - 'message' contains information about the operation result
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

    /**
     * Updates the class curriculum by changing the order or adding lectures.
     *
     * @param int $groupId Class identifier.
     * @param int $lectureId Lecture identifier.
     * @param int $lessonNumber Lesson number to be updated.
     *
     * @return array An array with a message about the operation performed.
     */
    public function updateLessonInPlan($groupId, $lectureId, $lessonNumber)
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
