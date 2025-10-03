<?php

namespace App\Http\Controllers;

use App\Models\BristolStool;
use App\Http\Requests\StoreBristolStoolRequest;
use App\Http\Requests\UpdateBristolStoolRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BristolStoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $entries = BristolStool::getUserEntries();
            
            return response()->json([
                'success' => true,
                'data' => $entries,
                'message' => 'Bristol stool entries retrieved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve entries.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource.
     */
    public function store(StoreBristolStoolRequest $request): JsonResponse
    {
        try {
            $entry = BristolStool::createEntry($request->validated());
            
            return response()->json([
                'success' => true,
                'data' => $entry,
                'message' => 'Bristol stool entry created successfully.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create entry.',
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
            $entry = BristolStool::forCurrentUser()->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $entry,
                'message' => 'Bristol stool entry retrieved successfully.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Entry not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve entry.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     */
    public function update(UpdateBristolStoolRequest $request, string $id): JsonResponse
    {
        try {
            $entry = BristolStool::forCurrentUser()->findOrFail($id);
            $entry->updateEntry($request->validated());
            
            return response()->json([
                'success' => true,
                'data' => $entry,
                'message' => 'Bristol stool entry updated successfully.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Entry not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update entry.',
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
            $entry = BristolStool::forCurrentUser()->findOrFail($id);
            $entry->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Bristol stool entry deleted successfully.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Entry not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete entry.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get today's entries
     */
    public function getTodayEntries(): JsonResponse
    {
        try {
            $entries = BristolStool::getTodayEntries();
            
            return response()->json([
                'success' => true,
                'data' => $entries,
                'message' => "Today's entries retrieved successfully."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve today\'s entries.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics
     */
    public function getStats(): JsonResponse
    {
        try {
            $stats = BristolStool::getStats();
            
            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Statistics retrieved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve statistics.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}