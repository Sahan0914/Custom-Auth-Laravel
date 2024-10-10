<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get("register", [AuthController::class, 'register'])->name("register");
// Route::get("login", [AuthController::class, 'login'])->name("login");
// Route::get("dashboard", [AuthController::class, 'dashboard'])->name("dashboard");

// Route::post("profile", [AuthController::class, 'profile'])->name("profile");
// Route::post("logout", [AuthController::class, 'logout'])->name("logout");
Route::group([
    "middleware"=>["guest"]
],function(){
    Route::match(["get","post"],"register",[AuthController::class,"register"])->name("register");
    Route::match(["get","post"],"login",[AuthController::class,"login"])->name("login");

});
Route::group([
    "middleware"=>["auth"]
],function(){

Route::get("dashboard", [AuthController::class, 'dashboard'])->name("dashboard");
Route::match(["get","post"],"profile",[AuthController::class,"profile"])->name("profile");
Route::get("logout", [AuthController::class, 'logout'])->name("logout");

});