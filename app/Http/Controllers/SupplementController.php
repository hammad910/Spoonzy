<?php

namespace App\Http\Controllers;

use App\Models\Supplement;
use App\Http\Requests\StoreSupplementRequest;
use App\Http\Requests\UpdateSupplementRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // $supplements = Supplement::where('user_id', Auth::id())->get();
            dd('route hit', Auth::id());
            $supplements = Supplement::all();

            dd($supplements);
            
            return response()->json([
                'success' => true,
                'data' => $supplements,
                'message' => 'Supplement entries retrieved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve supplement entries.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource.
     */
    public function store(StoreSupplementRequest $request): JsonResponse
    {
        try {
            $supplement = Supplement::createSupplement($request->validated());
            
            return response()->json([
                'success' => true,
                'data' => $supplement,
                'message' => 'Supplement entry created successfully.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create supplement entry.',
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
            $supplement = Supplement::forCurrentUser()->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $supplement,
                'message' => 'Supplement entry retrieved successfully.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Supplement entry not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve supplement entry.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     */
    public function update(UpdateSupplementRequest $request, string $id): JsonResponse
    {
        try {
            $supplement = Supplement::forCurrentUser()->findOrFail($id);
            $supplement->updateSupplement($request->validated());
            
            return response()->json([
                'success' => true,
                'data' => $supplement,
                'message' => 'Supplement entry updated successfully.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Supplement entry not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update supplement entry.',
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
            $supplement = Supplement::forCurrentUser()->findOrFail($id);
            $supplement->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Supplement entry deleted successfully.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Supplement entry not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete supplement entry.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get today's supplement entries
     */
    public function getTodaySupplements(): JsonResponse
    {
        try {
            $supplements = Supplement::getTodaySupplements();
            
            return response()->json([
                'success' => true,
                'data' => $supplements,
                'message' => "Today's supplement entries retrieved successfully."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve today\'s supplement entries.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get supplement statistics
     */
    public function getStats(): JsonResponse
    {
        try {
            $stats = Supplement::getSupplementStats();
            
            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Supplement statistics retrieved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve supplement statistics.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get frequently used supplements
     */
    public function getFrequentlyUsed(Request $request): JsonResponse
    {
        try {
            $limit = $request->get('limit', 5);
            $supplements = Supplement::getFrequentlyUsedSupplements($limit);
            
            return response()->json([
                'success' => true,
                'data' => $supplements,
                'message' => 'Frequently used supplements retrieved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve frequently used supplements.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}