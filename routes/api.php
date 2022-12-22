<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RegisterController;

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

Route::post('/register',[RegisterController::class,'create']);
// Route::post('/register',function());

Route::post('/login',[LoginController::class,'login']);

Route::post('/logout', [LoginController::class, 'logout']);
Route::middleware('auth:api')->group(function() {
    Route::get('products', [ProductsController::class,'index']);
});





