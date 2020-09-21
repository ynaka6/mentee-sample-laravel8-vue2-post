<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'message'
    ];

    protected $data = [
        'deleted_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query;
    }

    public function paginateByCondition(array $confition)
    {
        $sortBy = $confition['sortby'] ?? 'id';
        $order = $confition['order'] ?? 'desc';
        return $this->with('user')
            ->filter($confition)
            ->orderBy($sortBy, $order)
            ->paginate()
        ;
    }
}
