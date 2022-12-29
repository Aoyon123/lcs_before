<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\EducationQualificationController;
use Illuminate\Support\Facades\Auth;


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

// Route::get('/register', function () {
//     return "dsfgdfgh";
// });  `

Route::get('/admins', [RegisterController::class, 'index']);
// Route::get('/admins/{id}/retrieve', [RegisterController::class, 'retrieve']);
Route::put('/admins/{id}/update', [RegisterController::class, 'update']);

Route::post('/admins/delete', [RegisterController::class, 'destroy']);

Route::post('/login',[LoginController::class,'login']);
Route::post('/register',[RegisterController::class,'store']);
Route::get('/admins/{id}/retrieve', [RegisterController::class, 'retrieve']);

// Route::post('/logout', function () {
//     return "Working On This";
// });
Route::post('/education_qualification',[EducationQualificationController::class,'store']);
Route::get('/education_qualification', [EducationQualificationController::class, 'index']);
Route::get('/education_qualification/{id}/retrieve', [EducationQualificationController::class, 'retrieve']);
Route::put('/education_qualification/{id}/update', [EducationQualificationController::class, 'update']);
Route::delete('/education_qualification/{id}', [EducationQualificationController::class, 'destroy']);
Route::middleware('auth:api')->group(function() {

    Route::post('/logout', [LoginController::class, 'logout']);
    // Route::get('/admins', [RegisterController::class, 'index']);

});





