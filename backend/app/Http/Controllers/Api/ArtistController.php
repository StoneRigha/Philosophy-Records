<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Access\AuthorizationException;

class ArtistController extends Controller
{
    /**
     * Return a list of artists.
     */
    public function index(): JsonResponse
    {
        return response()->json(['artists' => Artist::all()]);
    }

    /**
     * Return a single artist.
     */
    public function show(Artist $artist): JsonResponse
    {
        return response()->json(['artist' => $artist]);
    }

    /**
     * Create a new artist.
     */
    public function store(Request $request): JsonResponse
    {
        $this->ensureAdmin($request);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|string|max:1024',
            'instagram' => 'nullable|string|max:255',
            'spotify' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
        ]);

        $artist = Artist::create($validated);

        return response()->json(['artist' => $artist], 201);
    }

    /**
     * Update an existing artist.
     */
    public function update(Request $request, Artist $artist): JsonResponse
    {
        $this->ensureAdmin($request);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|string|max:1024',
            'instagram' => 'nullable|string|max:255',
            'spotify' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
        ]);

        $artist->update($validated);

        return response()->json(['artist' => $artist]);
    }

    /**
     * Delete an artist.
     */
    public function destroy(Request $request, Artist $artist): JsonResponse
    {
        $this->ensureAdmin($request);

        $artist->delete();

        return response()->json(['message' => 'Artist deleted successfully']);
    }

    private function ensureAdmin(Request $request): void
    {
        if (!$request->user() || !method_exists($request->user(), 'hasRole') || !$request->user()->hasRole('Admin')) {
            throw new AuthorizationException('Admin access required.');
        }
    }
}
