<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\passwordController;
use App\Http\Controllers\usersController;
use App\Models\Passwords;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name("home");

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $data = Passwords::all();
        $admin = User::where("email", "admin@mail.ru")->first();

        return view('dashboard', ["data" => $data, "admin" => $admin]);
    })->name('dashboard');
});

Route::controller(passwordController::class)->group(function () {
    Route::POST('/createPass', 'createPass')->name('createPass');
    Route::POST('/viewPass', 'viewPass')->name('viewPass');
    Route::POST('/editPass', 'editPass')->name('editPass');
})->middleware("auth");


Route::controller(usersController::class)->group(function () {
    Route::get('/usersAll', 'usersAll')->name('usersAll');
    Route::POST('/createUser', 'createUser')->name('createUser');
    Route::POST('/editUser', 'editUser')->name('editUser');
    Route::POST("/updateUserPassword", "updateUserPassword")->name("updateUserPassword");
    Route::get('/{userId}/deleteUser', 'deleteUser')->name('deleteUser');
})->middleware("auth");