<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ExperimentEntry;
use App\Http\Requests\StoreContentRequest;
use App\Http\Requests\UpdateContentRequest;
use App\Http\Requests\StoreExperimentEntryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $contents = Content::getUserContents();
            
            return response()->json([
                'success' => true,
                'data' => $contents,
                'message' => 'Contents retrieved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve contents.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource.
     */
    public function store(StoreContentRequest $request): JsonResponse
    {
        try {
            $content = Content::createContent($request->validated());
            
            return response()->json([
                'success' => true,
                'data' => $content,
                'message' => 'Content created successfully.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create content.',
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
            $content = Content::forCurrentUser()
                ->with(['experimentEntries'])
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $content,
                'message' => 'Content retrieved successfully.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Content not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve content.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     */
    public function update(UpdateContentRequest $request, string $id): JsonResponse
    {
        try {
            $content = Content::forCurrentUser()->findOrFail($id);
            $content->updateContent($request->validated());
            
            return response()->json([
                'success' => true,
                'data' => $content,
                'message' => 'Content updated successfully.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Content not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update content.',
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
            $content = Content::forCurrentUser()->findOrFail($id);
            $content->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Content deleted successfully.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Content not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete content.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get experiments only
     */
    public function getExperiments(): JsonResponse
    {
        try {
            $experiments = Content::getExperiments();
            
            return response()->json([
                'success' => true,
                'data' => $experiments,
                'message' => 'Experiments retrieved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve experiments.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get documentaries only
     */
    public function getDocumentaries(): JsonResponse
    {
        try {
            $documentaries = Content::getDocumentaries();
            
            return response()->json([
                'success' => true,
                'data' => $documentaries,
                'message' => 'Documentaries retrieved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve documentaries.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get content statistics
     */
    public function getStats(): JsonResponse
    {
        try {
            $stats = Content::getContentStats();
            
            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Content statistics retrieved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve content statistics.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search contents
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $searchTerm = $request->get('q');
            
            if (!$searchTerm) {
                return response()->json([
                    'success' => false,
                    'message' => 'Search term is required.'
                ], 400);
            }
            
            $contents = Content::forCurrentUser()
                ->search($searchTerm)
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $contents,
                'message' => 'Search results retrieved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to search contents.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add experiment entry to content
     */
    public function addExperimentEntry(StoreExperimentEntryRequest $request, string $id): JsonResponse
    {
        try {
            $content = Content::forCurrentUser()->findOrFail($id);
            
            if ($content->content_type !== 'experiment') {
                return response()->json([
                    'success' => false,
                    'message' => 'Can only add experiment entries to experiment content.'
                ], 400);
            }
            
            $entryData = $request->validated();
            $entryData['content_id'] = $id;
            
            $experimentEntry = ExperimentEntry::createExperimentEntry($entryData);
            
            return response()->json([
                'success' => true,
                'data' => $experimentEntry,
                'message' => 'Experiment entry added successfully.'
            ], 201);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Content not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add experiment entry.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get experiment entries for content
     */
    public function getExperimentEntries(string $id): JsonResponse
    {
        try {
            $content = Content::forCurrentUser()->findOrFail($id);
            
            if ($content->content_type !== 'experiment') {
                return response()->json([
                    'success' => false,
                    'message' => 'Content is not an experiment.'
                ], 400);
            }
            
            $entries = ExperimentEntry::getContentEntries($id);
            
            return response()->json([
                'success' => true,
                'data' => $entries,
                'message' => 'Experiment entries retrieved successfully.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Content not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve experiment entries.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}