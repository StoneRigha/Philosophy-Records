<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ArtistController;
use App\Http\Controllers\Api\FirebaseAuthController;

Route::prefix('v1')->group(function () {
    Route::post('/auth/firebase', [FirebaseAuthController::class, 'authenticate']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'profile']);

        Route::get('/artists', [ArtistController::class, 'index']);
        Route::get('/artists/{artist}', [ArtistController::class, 'show']);

        Route::post('/artists', [ArtistController::class, 'store']);
        Route::put('/artists/{artist}', [ArtistController::class, 'update']);
        Route::delete('/artists/{artist}', [ArtistController::class, 'destroy']);

        // Albums
        Route::get('/albums', [\App\Http\Controllers\Api\AlbumController::class, 'index']);
        Route::get('/albums/{album}', [\App\Http\Controllers\Api\AlbumController::class, 'show']);
        Route::post('/albums', [\App\Http\Controllers\Api\AlbumController::class, 'store']);
        Route::put('/albums/{album}', [\App\Http\Controllers\Api\AlbumController::class, 'update']);
        Route::delete('/albums/{album}', [\App\Http\Controllers\Api\AlbumController::class, 'destroy']);

        // Tracks
        Route::get('/tracks', [\App\Http\Controllers\Api\TrackController::class, 'index']);
        Route::get('/tracks/{track}', [\App\Http\Controllers\Api\TrackController::class, 'show']);
        Route::post('/tracks', [\App\Http\Controllers\Api\TrackController::class, 'store']);
        Route::put('/tracks/{track}', [\App\Http\Controllers\Api\TrackController::class, 'update']);
        Route::delete('/tracks/{track}', [\App\Http\Controllers\Api\TrackController::class, 'destroy']);
    });
});
