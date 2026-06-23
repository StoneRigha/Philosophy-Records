<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Storage;

class TrackController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['tracks' => Track::with('album')->get()]);
    }

    public function show(Track $track): JsonResponse
    {
        return response()->json(['track' => $track->load('album')]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->ensureAdmin($request);

        $validated = $request->validate([
            'album_id' => 'required|exists:albums,id',
            'title' => 'required|string|max:255',
            'duration' => 'nullable|integer',
            'audio' => 'nullable|file|mimes:mp3,wav,aac|sometimes|max:10240',
        ]);

        if ($request->hasFile('audio')) {
            $validated['audio_url'] = $request->file('audio')->store('tracks/audio', 'public');
        }

        $track = Track::create([
            'album_id' => $validated['album_id'],
            'title' => $validated['title'],
            'duration' => $validated['duration'] ?? null,
            'audio_url' => $validated['audio_url'] ?? null,
        ]);

        return response()->json(['track' => $track], 201);
    }

    public function update(Request $request, Track $track): JsonResponse
    {
        $this->ensureAdmin($request);

        $validated = $request->validate([
            'album_id' => 'sometimes|required|exists:albums,id',
            'title' => 'sometimes|required|string|max:255',
            'duration' => 'nullable|integer',
            'audio' => 'nullable|file|mimes:mp3,wav,aac|sometimes|max:10240',
        ]);

        if ($request->hasFile('audio')) {
            if ($track->audio_url) {
                Storage::disk('public')->delete($track->audio_url);
            }
            $validated['audio_url'] = $request->file('audio')->store('tracks/audio', 'public');
        }

        $track->update($validated);

        return response()->json(['track' => $track]);
    }

    public function destroy(Request $request, Track $track): JsonResponse
    {
        $this->ensureAdmin($request);

        if ($track->audio_url) {
            Storage::disk('public')->delete($track->audio_url);
        }

        $track->delete();

        return response()->json(['message' => 'Track deleted successfully']);
    }

    private function ensureAdmin(Request $request): void
    {
        if (!$request->user() || !method_exists($request->user(), 'hasRole') || !$request->user()->hasRole('Admin')) {
            throw new AuthorizationException('Admin access required.');
        }
    }
}
