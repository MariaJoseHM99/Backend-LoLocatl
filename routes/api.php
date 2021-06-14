<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusinessController;


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

Route::post('/user/signUp', [LoginController::class,'signUp']);
Route::post('/user/login',[LoginController::class,'login']);

Route::group(['middleware' => 'auth:api'],function(){
    //LOGIN CONTROLLER
Route::get('/user/logout',[LoginController::class,'logout']);
Route::post('/user/updateUser', [ProfileController::class,'updateUser']);
Route::delete('/user/deleteUser',[ProfileController::class,'deleteUser']);

    //BUSINESS CONTROLLER
Route::get('/business/getAllBusiness', [BusinessController::class, 'getAllBusiness']);
Route::get('/business/{businessSlug}/getBusinessBySlug', [BusinessController::class, 'getBusinessBySlug']);
Route::post('/business/createCategory', [BusinessController::class,'createCategory']);
Route::post('/business/createSchedule', [BusinessController::class,'createSchedule']);
Route::post('/business/{businessId}/createScheduleDay', [BusinessController::class,'createScheduleDay']);
Route::post('/business/registerBusiness', [BusinessController::class,'registerBusiness']);
Route::post('/business/{businessId}/registerPhoneNumber', [BusinessController::class,'registerPhoneNumber']);

    //REVIEW CONTROLLER
Route::post('/review/{businessId}/addReviewToBusiness', [ReviewController::class,'addReviewToBusiness']);
Route::get('/business/{businessId}/getBusinessReview', [BusinessController::class, 'getBusinessReview']);

});
