<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BandWidthController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [BandWidthController::class, 'index']);
Route::get('/speed-test', [BandWidthController::class, 'runSpeedTest']);
Route::get('/traffic-stats', [BandWidthController::class, 'getTrafficStats']);
