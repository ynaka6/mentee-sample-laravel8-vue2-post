<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query;
    }

    public function paginateByCondition(array $confition): LengthAwarePaginator
    {
        $sortBy = $confition['sortby'] ?? 'id';
        $order = $confition['order'] ?? 'desc';
        return $this->with('user')
            ->filter($confition)
            ->orderBy($sortBy, $order)
            ->paginate()
        ;
    }

    public function liking(?User $user): bool
    {
        return $user && $this->likes()->where('user_id', $user->id)->count() > 0;
    }

    public function like(User $user): int
    {
        $like = $this->likes()
            ->withTrashed()
            ->where('user_id', $user->id)
            ->firstOrCreate(['user_id' => $user->id]);
        ;
        $like->restore();
        return $this->likes()->count();
    }

    public function unlike(User $user): int
    {
        $this->likes()
            ->where('user_id', $user->id)
            ->delete();
        return $this->likes()->count();
    }
}
