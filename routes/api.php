<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RegisterController;
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


// Route::post('/register', function () {
//     return true;
// });
Route::get('/admins', [RegisterController::class, 'index']);
// Route::get('/admins/{id}/retrieve', [RegisterController::class, 'retrieve']);
Route::put('/admins/{id}/update', [RegisterController::class, 'update']);
Route::delete('/admins/{id}', [RegisterController::class, 'destroy']);
Route::post('/login',[LoginController::class,'login']);
Route::post('/register',[RegisterController::class,'store']);
// Route::post('/logout', function () {
//     return auth()->user();
// });

// Route::post('/apical', function () {
//     return auth()->user();
// });
// Route::post('/logout', function () {
//     return "Working On This";
// });
Route::middleware('auth:api')->group(function() {

    Route::post('/logout', [LoginController::class, 'logout']);
    // Route::get('/admins', [RegisterController::class, 'index']);
    Route::get('/admins/{id}/retrieve', [RegisterController::class, 'retrieve']);


});





