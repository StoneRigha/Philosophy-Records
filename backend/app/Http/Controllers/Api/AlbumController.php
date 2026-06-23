<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['albums' => Album::with(['artist', 'tracks'])->get()]);
    }

    public function show(Album $album): JsonResponse
    {
        return response()->json(['album' => $album->load(['artist', 'tracks'])]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->ensureAdmin($request);

        $validated = $request->validate([
            'artist_id' => 'required|exists:artists,id',
            'title' => 'required|string|max:255',
            'release_date' => 'nullable|date',
            'cover' => 'nullable|file|image|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            $validated['cover_image'] = $request->file('cover')->store('albums/covers', 'public');
        }

        $album = Album::create([
            'artist_id' => $validated['artist_id'],
            'title' => $validated['title'],
            'release_date' => $validated['release_date'] ?? null,
            'cover_image' => $validated['cover_image'] ?? null,
        ]);

        return response()->json(['album' => $album], 201);
    }

    public function update(Request $request, Album $album): JsonResponse
    {
        $this->ensureAdmin($request);

        $validated = $request->validate([
            'artist_id' => 'sometimes|required|exists:artists,id',
            'title' => 'sometimes|required|string|max:255',
            'release_date' => 'nullable|date',
            'cover' => 'nullable|file|image|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            // delete old cover if exists
            if ($album->cover_image) {
                Storage::disk('public')->delete($album->cover_image);
            }
            $validated['cover_image'] = $request->file('cover')->store('albums/covers', 'public');
        }

        $album->update($validated);

        return response()->json(['album' => $album]);
    }

    public function destroy(Request $request, Album $album): JsonResponse
    {
        $this->ensureAdmin($request);

        if ($album->cover_image) {
            Storage::disk('public')->delete($album->cover_image);
        }

        $album->delete();

        return response()->json(['message' => 'Album deleted successfully']);
    }

    private function ensureAdmin(Request $request): void
    {
        if (!$request->user() || !method_exists($request->user(), 'hasRole') || !$request->user()->hasRole('Admin')) {
            throw new AuthorizationException('Admin access required.');
        }
    }
}
