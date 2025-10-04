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
// Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('bristol-entries', 'BristolStoolController');

    Route::get('supplements/today', [SupplementController::class, 'getTodaySupplements']);
    Route::get('supplements/stats', [SupplementController::class, 'getStats']);
    Route::get('supplements/frequent', [SupplementController::class, 'getFrequentlyUsed']);
    Route::apiResource('supplements', 'SupplementController');
    
    Route::get('mood-entries/today', [MoodController::class, 'getTodayMoods']);
    Route::get('mood-entries/stats', [MoodController::class, 'getStats']);
    Route::get('mood-entries/trends', [MoodController::class, 'getTrends']);
    Route::get('mood-entries/tags/common', [MoodController::class, 'getCommonTags']);
    Route::apiResource('mood-entries', 'MoodController');

    Route::get('contents/experiments', [ContentController::class, 'getExperiments']);
    Route::get('contents/documentaries', [ContentController::class, 'getDocumentaries']);
    Route::get('contents/stats', [ContentController::class, 'getStats']);
    Route::get('contents/search', [ContentController::class, 'search']);
    Route::get('contents/{id}/experiment-entries', [ContentController::class, 'getExperimentEntries']);
    Route::post('contents/{id}/experiment-entries', [ContentController::class, 'addExperimentEntry']);
    Route::apiResource('contents', 'ContentController');
    
    Route::apiResource('experiment-entries', 'ExperimentEntryController');
// });
