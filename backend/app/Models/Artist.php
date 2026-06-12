<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'bio', 'image', 'instagram', 'spotify', 'website'])]
class Artist extends Model
{
    use HasFactory;

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }
}
