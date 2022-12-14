<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::post('User',[UserController::class,'User']);


Route::group(['middleware' => ['auth:api']], function (){

    Route::post('logout',[UserController::class,'logout']);
    Route::get('Token',[UserController::class,'Token']); 
});
