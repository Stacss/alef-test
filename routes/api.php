<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/students', 'StudentController@store');
Route::put('/students/{id}', 'StudentController@update');
Route::delete('/students/{student}', 'StudentController@deleteStudent');
Route::get('/students', 'StudentController@getStudents');
Route::get('/students/{student}', 'StudentController@getStudent');

Route::post('/groups', 'GroupController@store');
Route::put('/groups/{group}', 'GroupController@update');
Route::delete('/groups/{group}', 'GroupController@destroy');
Route::get('/groups', 'GroupController@index');
Route::get('/groups/{group}', 'GroupController@show');
Route::post('/groups/{groupId}/lectures', 'GroupController@addLectureToPlan');
Route::get('/groups/{groupId}/lecture-plan', 'GroupController@getLecturePlanForGroup');
Route::put('/groups/{groupId}/lectures/{lectureId}', 'GroupController@updateLectureInPlan');







