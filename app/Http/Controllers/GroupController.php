<?php

namespace App\Http\Controllers;

use App\Group;
use App\Services\LessonPlanService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GroupController extends Controller
{
    protected $lessonPlanService;

    public function __construct(LessonPlanService $lessonPlanService)
    {
        $this->lessonPlanService = $lessonPlanService;
    }
    /**
     * @OA\Post(
     *      path="/api/groups",
     *      operationId="createGroup",
     *      tags={"Groups"},
     *      summary="Create a new group",
     *      description="Create a new group with the given name.",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Group data",
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string", example="Math Class"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Group created successfully"),
     *          )
     *      ),
     *     @OA\Response(
     *     response=422,
     *     description="Validation error",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="Validation error"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error creating group",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Error creating group"),
     *              @OA\Property(property="error", type="string", example="Internal Server Error"),
     *          )
     *      ),
     * )
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|string|max:255|unique:groups,name',
            ]);

            $group = Group::create($request->only(['name']));

            return response()->json(['message' => 'Group created successfully', 'data' => $group], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating group', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *      path="/api/groups/{group}",
     *      operationId="updateGroup",
     *      tags={"Groups"},
     *      summary="Update an existing group",
     *      description="Update the name of an existing group.",
     *      @OA\Parameter(
     *          name="group",
     *          in="path",
     *          description="ID of the group to be updated",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Group data",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="New Math Class Name"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Group updated successfully"),
     *          )
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation error",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="Validation error"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error updating group",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Error updating group"),
     *              @OA\Property(property="error", type="string", example="Internal Server Error"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, Group $group)
    {
        try {
            $this->validate($request, [
                'name' => 'required|string|max:255|unique:groups',
            ]);

            $group->update(['name' => $request->input('name')]);

            return response()->json(['message' => 'Group updated successfully', 'data' => $group]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating group', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/groups/{id}",
     *      operationId="deleteGroup",
     *      tags={"Groups"},
     *      summary="Delete a group",
     *      description="Delete a group by its ID. Students associated with the group will be detached but not deleted from the system.",
     *      @OA\Parameter(
     *          name="id",
     *          required=true,
     *          in="path",
     *          description="ID of the group to be deleted",
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Group deleted successfully"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error deleting group",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Error deleting group"),
     *              @OA\Property(property="error", type="string", example="Internal Server Error"),
     *          )
     *      ),
     * )
     */
    public function destroy(Group $group)
    {
        try {
            $group->members()->detach();

            $group->delete();

            return response()->json(['message' => 'Group deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting group', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/groups",
     *      operationId="getGroups",
     *      tags={"Groups"},
     *      summary="Get a list of all groups",
     *      description="Retrieve a list of all groups in the system.",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error retrieving groups",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Error retrieving groups"),
     *              @OA\Property(property="error", type="string", example="Internal Server Error"),
     *          )
     *      ),
     * )
     */
    public function index()
    {
        try {
            $groups = Group::all();

            return response()->json(['data' => $groups], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving groups', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/groups/{group}",
     *      operationId="getGroup",
     *      tags={"Groups"},
     *      summary="Get information about a specific group",
     *      description="Retrieve information about a specific group, including its name and the students in the group with attended lectures.",
     *      @OA\Parameter(
     *          name="group",
     *          in="path",
     *          required=true,
     *          description="ID of the group",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error retrieving group information",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Error retrieving group information"),
     *              @OA\Property(property="error", type="string", example="Internal Server Error"),
     *          )
     *      ),
     * )
     */
    public function show(Group $group)
    {
        try {
            $group->load('members');

            return response()->json(['data' => $group], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving group information', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api /groups/{groupId}/lectures",
     *      operationId="addLectureToPlan",
     *      tags={"Group Lectures"},
     *      summary="Add a lecture to the study plan of a group",
     *      description="Adds a lecture to the study plan of a specific group.",
     *      @OA\Parameter(
     *          name="groupId",
     *          in="path",
     *          required=true,
     *          description="ID of the group",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Data required to add the lecture to the plan",
     *          @OA\JsonContent(
     *              required={"lecture_id", "lesson_number"},
     *              @OA\Property(property="lecture_id", type="integer", example="1"),
     *              @OA\Property(property="lesson_number", type="integer", example="3")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success message",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Lecture added to the plan successfully")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Validation error"),
     *              @OA\Property(property="errors", type="object", example={"lecture_id": {"The lecture_id field is required."}})
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error adding lecture to the plan",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Error adding lecture to the plan"),
     *              @OA\Property(property="error", type="string", example="Internal Server Error")
     *          )
     *      )
     * )
     */
    public function addLectureToPlan(Request $request, $groupId)
    {
        try {
            $this->validate($request, [
                'lecture_id' => 'required|exists:lectures,id',
                'lesson_number' => 'required|integer|min:1',
            ]);

            $result = $this->lessonPlanService->addLectureToPlan(
                $groupId,
                $request->input('lecture_id'),
                $request->input('lesson_number')
            );

            return response()->json($result, $result['message'] ? 200 : 400);

        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error adding lecture to the plan', 'error' => $e->getMessage()], 500);
        }
    }


}
