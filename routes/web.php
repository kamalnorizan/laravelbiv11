<?php

use App\Http\Controllers\DynamicDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chartjs', function () {
    return view('chartjs');
})->name('chartjs');

Route::get('/dynamicdashboard', [DynamicDashboardController::class,'index'])->name('dynamicdashboard.index');
Route::post('/dynamicdashboard/loadData', [DynamicDashboardController::class,'loadData'])->name('dynamicdashboard.loadData');
Route::post('/dynamicdashboard/revenueDetails', [DynamicDashboardController::class,'revenueDetails'])->name('dynamicdashboard.revenueDetails');


