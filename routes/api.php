<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\AffiliationController;
use App\Http\Controllers\DirgaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('send',[AffiliationController::class,'sendEmail']);

Route::get('communes',[AffiliationController::class,'getCommunes']);
Route::get('prefectures',[AffiliationController::class,'getPrefectures']);
Route::get('branches',[AffiliationController::class,'getBranches']);

// Route::middleware(['cors'])->group(function () {
//     Route::post('affiliation/store',[AffiliationController::class,'AffStore']);
// });

Route::group(['middleware' => 'cors'], function () {
    Route::post('affiliation/store',[AffiliationController::class,'AffStore']);
    Route::get('dirga/all-aff',[DirgaController::class,'getAllAffiliation'])->middleware('auth:sanctum');
});


// Route::post('affiliation/store',[AffiliationController::class,'AffStore'])->middleware('cors');


Route::post('register',[UserAuthController::class,'register']);
Route::post('dirga/login',[UserAuthController::class,'dirgaLogin']);

Route::post('logout',[UserAuthController::class,'logout'])
  ->middleware('auth:sanctum');
