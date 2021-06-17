<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
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

Route::post('/user/signUp', [LoginController::class,'signUp']);
Route::post('/user/login',[LoginController::class,'login']);
Route::get('/business/getAllBusiness', [BusinessController::class, 'getAllBusiness']);

Route::get('/business/getAllBusiness', [BusinessController::class, 'getAllBusiness']);
Route::get('/business/{businessSlug}/getBusinessBySlug', [BusinessController::class, 'getBusinessBySlug']);

Route::group(['middleware' => 'auth:api'],function(){
    //LOGIN CONTROLLER
    Route::get('/user/logout',[LoginController::class,'logout']);
    Route::get('/user/getMe', [LoginController::class,'getMe']);
    Route::delete('/user/deleteUser',[ProfileController::class,'deleteUser']);
    Route::post('/user/updateUser', [ProfileController::class,'updateUser']);

    //BUSINESS CONTROLLER
    Route::post('/business/createCategory', [BusinessController::class,'createCategory']);
    Route::post('/business/createSchedule', [BusinessController::class,'createSchedule']);
    Route::post('/business/{businessId}/createScheduleDay', [BusinessController::class,'createScheduleDay']);
    Route::post('/business/registerBusiness', [BusinessController::class,'registerBusiness']);
    Route::post('/business/{businessId}/registerPhoneNumber', [BusinessController::class,'registerPhoneNumber']);
    Route::post('/business/{businessId}/uploadPhoto', [BusinessController::class,'uploadPhoto']);

    //REVIEW CONTROLLER
    Route::post('/review/{businessId}/addReviewToBusiness', [ReviewController::class,'addReviewToBusiness']);
    Route::get('/business/{businessId}/getBusinessReview', [BusinessController::class, 'getBusinessReview']);

    //CATEGORY CONTROLLER
    Route::get('/category/getAllCategories', [CategoryController::class,'getAllCategories']);

});
