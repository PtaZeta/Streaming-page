<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YouTubeController;
use App\Http\Controllers\StreamStatusController;

Route::get('/', [YouTubeController::class, 'index']);
Route::get('/api/stream-status', [StreamStatusController::class, 'checkStatus']);
Route::post('/api/stream-status/set', [StreamStatusController::class, 'setStatus']);
Route::get('/api/stream-status/override', [StreamStatusController::class, 'getOverrideStatus']);
Route::get('/api/stream-status/override/clear', [StreamStatusController::class, 'clearOverrideStatus']);
Route::get('/api/stream-status/debug', [StreamStatusController::class, 'debugStatus']);
Route::get('/api/stream-status/debug-scrape', [StreamStatusController::class, 'debugTwitchScrape']);
Route::get('/api/stream-status/debug-gql', [StreamStatusController::class, 'debugGraphQL']);
