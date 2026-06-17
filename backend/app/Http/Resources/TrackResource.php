<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrackResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'album_id' => $this->album_id,
            'title' => $this->title,
            'duration' => $this->duration,
            'audio_url' => $this->audio_url,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
