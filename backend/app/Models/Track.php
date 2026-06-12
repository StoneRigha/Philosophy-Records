<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['album_id', 'title', 'duration', 'audio_url'])]
class Track extends Model
{
    use HasFactory;

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
}
