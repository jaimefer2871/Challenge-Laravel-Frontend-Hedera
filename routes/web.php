<?php

use Illuminate\Http\Request;
use App\Http\Middleware\Check;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HederaController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('login',  [AuthController::class, 'login'])->name('login');
Route::get('validate',  [AuthController::class, 'validate'])->name('validate');
Route::get('logout',  function (Request $request) {
    $request->session()->flush();
    return redirect()->route("login");
})->name('logout');
Route::get('/users/register',  [UsersController::class, 'register'])->name('register_user');
Route::get('/hedera/dashboard',  [HederaController::class, 'dashboard'])->name('hedera_index')->middleware([Check::class]);
