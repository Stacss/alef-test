<?php

namespace App\Http\Controllers;

use App\Lecture;
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

}
