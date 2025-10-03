<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\MoodController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PushNotificationsController;
use App\Http\Controllers\SupplementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('device/register', [PushNotificationsController::class, 'registerDevice']);
Route::get('device/delete', [PushNotificationsController::class, 'deleteDevice']);


// Health Tracking Work
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('bristol-entries', 'BristolStoolController');

    Route::apiResource('supplements', 'SupplementController');
    Route::get('supplements/today/today', [SupplementController::class, 'getTodaySupplements']);
    Route::get('supplements/stats/stats', [SupplementController::class, 'getStats']);
    Route::get('supplements/frequent/frequent', [SupplementController::class, 'getFrequentlyUsed']);

    Route::apiResource('mood-entries', 'MoodController');
    Route::get('mood-entries/today/today', [MoodController::class, 'getTodayMoods']);
    Route::get('mood-entries/stats/stats', [MoodController::class, 'getStats']);
    Route::get('mood-entries/trends/trends', [MoodController::class, 'getTrends']);
    Route::get('mood-entries/tags/common', [MoodController::class, 'getCommonTags']);

    Route::apiResource('contents', 'ContentController');
    Route::get('contents/experiments/experiments', [ContentController::class, 'getExperiments']);
    Route::get('contents/documentaries/documentaries', [ContentController::class, 'getDocumentaries']);
    Route::get('contents/stats/stats', [ContentController::class, 'getStats']);
    Route::get('contents/search/search', [ContentController::class, 'search']);
    Route::post('contents/{id}/experiment-entries', [ContentController::class, 'addExperimentEntry']);
    Route::get('contents/{id}/experiment-entries', [ContentController::class, 'getExperimentEntries']);
    
    Route::apiResource('experiment-entries', 'ExperimentEntryController');
});
