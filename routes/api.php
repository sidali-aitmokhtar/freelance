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
    Route::get('/users',[UserController::class,'index']);
    Route::get('/users/{id}',[UserController::class,'show'])->middleware('auth:sanctum','permission:users.view');
    Route::post('/users',[UserController::class,'store'])->middleware('auth:sanctum','permission:users.create');
    Route::put('/users/{id}',[UserController::class,'update'])->middleware('auth:sanctum','role:admin');
    Route::delete('/users/{id}',[UserController::class,'destroy'])->middleware('auth:sanctum','permission:users.delete');

    //just testing
    Route::get('/rol',[UserController::class,'rol']);


    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);
    
    //**************** */
    //project
    //**************** */
    //client create a project
    Route::post('/projects',[ProjectController::class,'store'])->middleware('auth.check','permission:projects.create');
    //client delete thier project
    Route::put('/projects/{project}',[ProjectController::class,'update'])->middleware('auth.check','permission:projects.update');
    //
    Route::delete('/projects/{project}',[ProjectController::class,'destroy'])->middleware('auth.check','permission:projects.delete');

    //**************** */
    //bid
    //**************** */
    //a freelancer bids on the project
    Route::post('projects/{project}/bids',[BidController::class,'store'])->middleware('auth.check','permission:bids.create');
    //change the bid
    Route::put('projects/{project}/bids/{bid}',[BidController::class,'update'])->middleware('auth.check','permission:bids.update');
    //delete the bid
    Route::delete('projects/{project}/bids/{bid}',[BidController::class,'destroy'])->middleware('auth.check','permission:bids.delete');

    //***************** */
    //contract
    //***************** */
    //the client accepts the bid and create an contract
    Route::post('projects/{project}/bids/{bid}/contracts',[ContractController::class,'store'])->middleware('auth.check','permission:contracts.create');
    //the client or the freelancer can delete the contract
    Route::delete('projects/{project}/bids/{bid}/contracts/{contract}',[ContractController::class,'destroy'])->middleware('auth.check','permission:contract.delete');
    

});