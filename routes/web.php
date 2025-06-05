<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MetabaseController;
use App\Http\Controllers\DynamicDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chartjs', function () {
    return view('chartjs');
})->name('chartjs');

Route::get('/dynamicdashboard', [DynamicDashboardController::class, 'index'])->name('dynamicdashboard.index');
Route::post('/dynamicdashboard/loaddata', [DynamicDashboardController::class, 'loaddata'])->name('dynamicdashboard.loaddata');
Route::post('/dynamicdashboard/revenueDetails', [DynamicDashboardController::class, 'revenueDetails'])->name('dynamicdashboard.revenueDetails');
Route::post('/dynamicdashboard/customerDetails', [DynamicDashboardController::class, 'customerDetails'])->name('dynamicdashboard.customerDetails');

Route::get('metabase', function () {
    return view('metabase');
})->name('metabase');

Route::get('/metabase/embed/{type}/{id}', [MetabaseController::class, 'getEmbedUrl'])->name('metabase.embed');


