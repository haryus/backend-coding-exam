<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);

});
Route::middleware('auth:sanctum')->get('/rolesData', [UserController::class, 'roleData']);
Route::middleware('auth:sanctum')->get('/roles/without-users', [RoleController::class, 'rolesWithoutUsers']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
