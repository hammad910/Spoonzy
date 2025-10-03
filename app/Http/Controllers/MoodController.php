<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use App\Http\Requests\StoreMoodRequest;
use App\Http\Requests\UpdateMoodRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $moodEntries = Mood::getUserMoodEntries();
            
            return response()->json([
                'success' => true,
                'data' => $moodEntries,
                'message' => 'Mood entries retrieved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve mood entries.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource.
     */
    public function store(StoreMoodRequest $request): JsonResponse
    {
        try {
            $moodEntry = Mood::createMoodEntry($request->validated());
            
            return response()->json([
                'success' => true,
                'data' => $moodEntry,
                'message' => 'Mood entry created successfully.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create mood entry.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $moodEntry = Mood::forCurrentUser()->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $moodEntry,
                'message' => 'Mood entry retrieved successfully.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Mood entry not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve mood entry.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     */
    public function update(UpdateMoodRequest $request, string $id): JsonResponse
    {
        try {
            $moodEntry = Mood::forCurrentUser()->findOrFail($id);
            $moodEntry->updateMoodEntry($request->validated());
            
            return response()->json([
                'success' => true,
                'data' => $moodEntry,
                'message' => 'Mood entry updated successfully.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Mood entry not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update mood entry.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $moodEntry = Mood::forCurrentUser()->findOrFail($id);
            $moodEntry->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Mood entry deleted successfully.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Mood entry not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete mood entry.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get today's mood entries
     */
    public function getTodayMoods(): JsonResponse
    {
        try {
            $moodEntries = Mood::getTodayMoodEntries();
            
            return response()->json([
                'success' => true,
                'data' => $moodEntries,
                'message' => "Today's mood entries retrieved successfully."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve today\'s mood entries.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get mood statistics
     */
    public function getStats(): JsonResponse
    {
        try {
            $stats = Mood::getMoodStats();
            
            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Mood statistics retrieved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve mood statistics.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get mood trends
     */
    public function getTrends(Request $request): JsonResponse
    {
        try {
            $days = $request->get('days', 30);
            $trends = Mood::getMoodTrends($days);
            
            return response()->json([
                'success' => true,
                'data' => $trends,
                'message' => 'Mood trends retrieved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve mood trends.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get common tags
     */
    public function getCommonTags(): JsonResponse
    {
        try {
            $tags = Mood::getCommonTags();
            
            return response()->json([
                'success' => true,
                'data' => $tags,
                'message' => 'Common mood tags retrieved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve common mood tags.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}