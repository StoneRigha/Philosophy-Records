<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'artist' => new ArtistResource($this->whenLoaded('artist')),
            'title' => $this->title,
            'cover_image' => $this->cover_image,
            'release_date' => $this->release_date?->toDateString(),
            'tracks' => TrackResource::collection($this->whenLoaded('tracks')),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
