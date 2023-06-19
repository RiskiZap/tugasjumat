<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\DepartementsController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\MasjidController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class, 'register_action'])->name('register.action');
Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'login_action'])->name('login.action');


Route::middleware('auth')->group(
    function (){
        Route::get('/', function () {
            return view('home', ['title' => 'Chart Ajax']);
        })->name('home');
        Route::get('password', [UserController::class, 'password'])->name('password');
        Route::post('password', [UserController::class, 'password_action'])->name('password.action');
        Route::get('logout', [UserController::class, 'logout'])->name('logout');

        //route positions
        Route::resource('positions', PositionsController::class);
        Route::get('position/export-excel', [PositionsController::class, 'exportExcel'])->name('positions.exportExcel');

        //route departments
        Route::resource('departements', DepartementsController::class);
        Route::get('departement/export-pdf', [DepartementsController::class, 'exportPdf'])->name('departements.export-Pdf');

        //route user
        Route::resource('user', UserController::class);
        Route::get('users/export-pdf', [UserController::class, 'exportPdf'])->name('users.export-Pdf');
        
        //route dokters
        Route::resource('petugass', PetugasController::class);
        Route::get('search/masjid', [MasjidController::class, 'autocomplete'])->name('search.masjid');

        Route::resource('masjids', MasjidController::class);

        //route chart
        Route::get('chart-line', [MasjidController::class, 'chartLine'])->name('petugass.chartLine');
        Route::get('chart-line-ajax', [MasjidController::class, 'chartLineAjax'])->name('petugass.chartLineAjax');
    });
