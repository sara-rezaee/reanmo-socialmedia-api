<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserTweetController;
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

//public Routes
Route::post('/register', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'signin']);

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', [AuthController::class, 'signout']);
    Route::get('/user', [ProfileController::class, 'showProfile']);
    Route::get('/tweets', [TweetController::class, 'index']);
    Route::put('/user', [ProfileController::class, 'updateProfile']);
    Route::post('/tweets', [TweetController::class, 'store']);
    Route::get('/user/tweets', [UserTweetController::class, 'index']);
});
