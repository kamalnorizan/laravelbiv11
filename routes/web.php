<?php

use App\Http\Controllers\DynamicDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chartjs', function () {
    return view('chartjs');
})->name('chartjs');

Route::get('/dynamicdashboard', [DynamicDashboardController::class, 'index'])->name('dynamicdashboard.index');
Route::post('/dynamicdashboard/loaddata', [DynamicDashboardController::class, 'loaddata'])->name('dynamicdashboard.loaddata');


