<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BidController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContractController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function(){
    //CRUD users
//    Route::get('/users',[UserController::class,'index']);
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);
    

    //client create a project
    Route::post('/projects',[ProjectController::class,'create'])->middleware('auth:sanctum','role:client');
    //a freelancer bids on the project
    Route::post('projects/{id}/bids',[BidController::class,'create'])->middleware('auth:sanctum','role:freelancer');
    //the client accepts the bid and create an contract
    Route::post('projects/{project}/bids/{bid}/contracts',[ContractController::class,'create'])->middleware('auth:sanctum','role:client');
    

});