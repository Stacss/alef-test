<?php

namespace App\Http\Controllers;

use App\Lecture;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LectionController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/lections",
     *      operationId="getAllLections",
     *      tags={"Lections"},
     *      summary="Get all lections",
     *      description="Returns a list of all lections",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Failed to fetch lections",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Failed to fetch lections"),
     *              @OA\Property(property="error", type="string", example="Error message")
     *          )
     *      )
     * )
     */
    public function getAllLections()
    {
        try {
            $lections = Lecture::all();

            return response()->json(['data' => $lections], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch lections', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/lections",
     *      operationId="createLection",
     *      tags={"Lections"},
     *      summary="Create a new lection",
     *      description="Create a new lection with the given details.",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Lection data",
     *          @OA\JsonContent(
     *              required={"name", "description"},
     *              @OA\Property(property="name", type="string", example="Lection name"),
     *              @OA\Property(property="description", type="string", example="Lection description")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Lection created successfully",
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
     *          description="Error creating lection",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Error creating lection"),
     *              @OA\Property(property="error", type="string", example="Internal Server Error")
     *          )
     *      )
     * )
     */
    public function createLection(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|string|max:255|unique:lectures,name',
                'description' => 'required|string',
            ]);

            $data = $request->only(['name', 'description']);
            $lection = Lecture::create($data);

            return response()->json(['message' => 'Lection created successfully', 'data' => $lection], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating lection', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/lections/{id}",
     *      operationId="updateLecture",
     *      tags={"Lections"},
     *      summary="Update a lecture",
     *      description="Update an existing lecture's details.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Lecture ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Updated lecture data",
     *          @OA\JsonContent(
     *              required={"name", "description"},
     *              @OA\Property(property="name", type="string", example="Updated Lecture Name"),
     *              @OA\Property(property="description", type="string", example="Updated Lecture Description")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Lecture updated successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Lecture updated successfully"),
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
     *          description="Error updating lecture",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Error updating lecture"),
     *              @OA\Property(property="error", type="string", example="Internal Server Error")
     *          )
     *      )
     * )
     */
    public function updateLecture(Request $request, $id)
    {
        try {
            $lecture = Lecture::findOrFail($id);

            $this->validate($request, [
                'name' => 'required|string|max:255|unique:lectures,name,' . $id,
                'description' => 'required|string',
            ]);

            $data = $request->only(['name', 'description']);
            $lecture->update($data);

            return response()->json(['message' => 'Lecture updated successfully', 'data' => $lecture], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Lecture not found'], 404);
        }catch (\Exception $e) {
            return response()->json(['message' => 'Error updating lecture', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/lections/{id}",
     *      operationId="deleteLecture",
     *      tags={"Lections"},
     *      summary="Delete a lecture",
     *      description="Delete an existing lecture.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Lecture ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Lecture deleted successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Lecture deleted successfully")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Lecture not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Lecture not found")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error deleting lecture",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Error deleting lecture"),
     *              @OA\Property(property="error", type="string", example="Internal Server Error")
     *          )
     *      )
     * )
     */
    public function deleteLecture($id)
    {
        try {
            $lecture = Lecture::findOrFail($id);
            $lecture->delete();

            return response()->json(['message' => 'Lecture deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Lecture not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting lecture', 'error' => $e->getMessage()], 500);
        }
    }

}
