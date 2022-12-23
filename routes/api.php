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

Route::post('/register',[RegisterController::class,'store']);
// Route::post('/register', function () {
//     return true;
// });
Route::get('/admins', [RegisterController::class, 'index']);
Route::get('/admins/{id}', [RegisterController::class, 'retrive']);
//Route::get('/admins/{id}', [RegisterController::class, 'update']);
Route::post('/login',[LoginController::class,'login']);

Route::post('/logout', function () {
    return "Working On This";
});
Route::middleware('auth:api')->group(function() {
    Route::post('/logouts', [LoginController::class, 'logout']);
});





