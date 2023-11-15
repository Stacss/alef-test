<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

/**
 * @group Students
 *
 * API endpoints for managing students.
 */
class StudentController extends Controller
{
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
}
