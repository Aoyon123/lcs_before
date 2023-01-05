<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Common\ProfileController;
use App\Http\Controllers\Admin\ConsultantController;
use App\Http\Controllers\AcademicQualificationController;


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
// });

////////  Admin   /////////////
Route::get('/admins', [RegisterController::class, 'index']);
Route::put('/admins/{id}/update', [RegisterController::class, 'update']);
Route::post('/admins/delete', [RegisterController::class, 'destroy']);


Route::post('/login', [LoginController::class, 'login']);
Route::get('/profile/{id}', [LoginController::class, 'profile']);
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/admins/{id}/retrieve', [RegisterController::class, 'retrieve']);


Route::get('/admin/consultants', [ConsultantController::class, 'index']);


////////////  Profile //////////////

Route::post('/profile/update', [ProfileController::class, 'update']);
Route::post('/password/change', [ProfileController::class, 'updatePassword']);
Route::delete('/profile/experience/{id}/delete', [ProfileController::class, 'experienceDestroy']);
Route::delete('/profile/academic_qualification/{id}/delete', [ProfileController::class, 'academicQualificationDestroy']);


////////  Education Qualification   /////////////
Route::post('/academic_qualification', [AcademicQualificationController::class, 'store']);
Route::get('/academic_qualification', [AcademicQualificationController::class, 'index']);
Route::get('/academic_qualification/{id}/retrieve', [AcademicQualificationController::class, 'retrieve']);
Route::put('/academic_qualification/{id}/update', [AcademicQualificationController::class, 'update']);
Route::post('/academic_qualification/delete', [AcademicQualificationController::class, 'destroy']);


/////////  Experince   ///////////
Route::get('/experience', [ExperienceController::class, 'index']);
Route::post('/experience', [ExperienceController::class, 'store']);
Route::get('/experience/{id}/retrieve', [ExperienceController::class, 'retrieve']);
Route::put('/experience/{id}/update', [ExperienceController::class, 'update']);
Route::post('/experience/delete', [ExperienceController::class, 'destroy']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    // Route::get('/admins', [RegisterController::class, 'index']);

});
