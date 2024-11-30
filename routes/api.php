<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/get-users', [UsersController::class, 'GetAllUsers']);
Route::get('/get-single-user', [UsersController::class, 'GetSingleUserById']);
Route::head('/head-single-user', [UsersController::class, 'GetSingleUserUsingHeadHttpVerb']);
Route::post('/post-user', [UsersController::class, 'PostSingleUser']);
Route::patch('/patch-user/{id}', [UsersController::class, 'PatchUpdateUserById']);
Route::put('/put-user/{id}', [UsersController::class, 'UpdateUserById']);
Route::delete('/delete-user/{id}', [UsersController::class, 'DeleteUserById']);
Route::options('/get-options', [UsersController::class, 'GetOptions']);

Route::put('/patchupdate', [UsersController::class, 'AlternatePutOrPatchMethod']);