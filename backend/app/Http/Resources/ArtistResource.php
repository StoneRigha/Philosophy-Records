<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArtistResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'bio' => $this->bio,
            'image' => $this->image,
            'links' => [
                'instagram' => $this->instagram,
                'spotify' => $this->spotify,
                'website' => $this->website,
            ],
            'albums' => AlbumResource::collection($this->whenLoaded('albums')),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
