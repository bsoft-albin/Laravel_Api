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

Route::get('/get-users', [UsersController::class, 'GetAllUsers']);
Route::get('/get-single-user', [UsersController::class, 'GetSingleUserById']);

// the HEAD Endpoint is Not Natively Supported in Laravel, so the alternative way [MATCH] i used....
//Route::head('/head-single-user', [UsersController::class, 'GetSingleUserUsingHeadHttpVerb']);
Route::match(['get', 'head'], '/head-single-user', [UsersController::class, 'GetSingleUserUsingHeadHttpVerb']);

Route::post('/post-user', [UsersController::class, 'PostSingleUser']);
Route::patch('/patch-user/{id}', [UsersController::class, 'PatchUpdateUserById']);
Route::put('/put-user/{id}', [UsersController::class, 'UpdateUserById']);
Route::delete('/delete-user/{id}', [UsersController::class, 'DeleteUserById']);
Route::options('/get-options', [UsersController::class, 'GetOptions']);
// the Below Endpoint is Combined Way of PUT and Patch, without Query or Route Parameter, only pure Json Body!!!
Route::put('/patchupdate', [UsersController::class, 'AlternatePutOrPatchMethod']);