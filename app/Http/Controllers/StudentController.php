<?php

namespace App\Http\Controllers;

use App\Services\StudentService;
use App\Student;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

/**
 * @group Students
 *
 * API endpoints for managing students.
 */
class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }
    /**
     * @OA\Post(
     *      path="/api/students",
     *      operationId="storeStudent",
     *      tags={"Students"},
     *      summary="Create a new student",
     *      description="Create a new student with the given name and email.",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Student data",
     *          @OA\JsonContent(
     *              required={"name", "email"},
     *              @OA\Property(property="name", type="string", example="Ivan", description="The name of the student."),
     *              @OA\Property(property="email", type="string", format="email", example="ivan@example.com", description="The email address of the student."),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Student created successfully", description="A success message indicating that the student was created."),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Validation error", description="An error message indicating that there was a validation error."),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error creating student",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Error creating student", description="An error message indicating that there was an internal server error."),
     *              @OA\Property(property="error", type="string", example="Internal Server Error", description="A more detailed description of the internal server error."),
     *          )
     *      ),
     * )
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email',
            ]);

            $data = $request->only(['name', 'email']);

            $student = Student::create($data);

            return response()->json(['message' => 'Student created successfully', 'data' => $student], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating student', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/students/{id}",
     *      operationId="updateStudent",
     *      tags={"Students"},
     *      summary="Update a student",
     *      description="Update a student's name, email, and/or class affiliation.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Student ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Student data",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="Updated Name"),
     *              @OA\Property(property="email", type="string", format="email", example="updated@example.com"),
     *              @OA\Property(property="group_id", type="integer", example=1, description="Group ID to which the student belongs"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Student updated successfully"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="name", type="string", example="Updated Name"),
     *                  @OA\Property(property="email", type="string", format="email", example="updated@example.com"),
     *                  @OA\Property(property="group_id", type="integer", example=1),
     *                  @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01 12:00:00"),
     *                  @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01 12:00:00"),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Student not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Student not found"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Validation error"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error updating student",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Error updating student"),
     *              @OA\Property(property="error", type="string", example="Internal Server Error"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:students,email,' . $id,
                'group_id' => 'sometimes|exists:groups,id',
            ]);

            $student = Student::findOrFail($id);

            $data = $request->only(['name', 'email', 'group_id']);

            $this->studentService->updateStudent($student, $data);

            return response()->json(['message' => 'Student updated successfully', 'data' => $student], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating student', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/students/{id}",
     *      operationId="deleteStudent",
     *      tags={"Students"},
     *      summary="Delete a student",
     *      description="Delete a student and detach them from any associated groups.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID of the student to be deleted",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Student deleted successfully"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error deleting student",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Error deleting student"),
     *              @OA\Property(property="error", type="string", example="Internal Server Error"),
     *          )
     *      ),
     * )
     *
     * Delete a student and detach them from any associated groups and lectures.
     *
     * @param  Student  $student
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteStudent(Student $student)
    {
        try {
            $student->groups()->detach();
            $student->attendedLectures()->detach();

            $student->delete();

            return response()->json(['message' => 'Student deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting student', 'error' => $e->getMessage()], 500);
        }
    }
}
