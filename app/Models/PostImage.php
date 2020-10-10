<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'post_id',
        'filepath',
    ];

    protected $data = [
        'deleted_at'
    ];

    protected $append = [
        'url'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function getUrlAttribute(): ?string
    {
        if (empty($this->filepath)) {
            return null;
        }
        return Str::startsWith($this->filepath, 'http') ? $this->filepath : Storage::url($this->filepath);
    }
}
