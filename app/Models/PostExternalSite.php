<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostExternalSite extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'post_id',
        'title',
        'description',
        'image',
        'url',
    ];

    protected $data = [
        'deleted_at'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
