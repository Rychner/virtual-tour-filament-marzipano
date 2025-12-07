<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VirtualTourController;

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
    return view('home');
});

Route::get('/virtual-tour', [VirtualTourController::class, 'index'])->name('virtualtour.start');;
