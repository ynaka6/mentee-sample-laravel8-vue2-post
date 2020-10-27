<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'user_id',
        'message'
    ];

    protected $data = [
        'deleted_at'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function externalSite(): HasOne
    {
        return $this->hasOne(PostExternalSite::class);
    }

    public function product(): HasOne
    {
        return $this->hasOne(PostProduct::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(Post::class, 'parent_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class);
    }

    public function hashtags(): BelongsToMany
    {
        return $this->belongsToMany(Hashtag::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['hashtag'] ?? null, function ($query, $hashtag) {
                $query->whereHas('hashtags', function ($query) use ($hashtag) {
                    $query->where('hashtag', $hashtag);
                });
            })
            ->when($filters['maxId'] ?? null, function ($query, $maxId) {
                $query->where('id', '<=', $maxId);
            })
            ->when(
                $filters['parentId'] ?? null,
                function ($query, $parentId) {
                    $query->where('parent_id', '=', $parentId);
                },
                function ($query) {
                    $query->whereNull('parent_id');
                },
            )
        ;
    }

    /**
     * 登録処理
     *
     * @param array $attibutes
     * @return self
     */
    public function create(array $attibutes): self
    {
        $this->fill($attibutes)->save();
        if (($attibutes['hashtags'] ?? null) && is_array($attibutes['hashtags'])) {
            collect($attibutes['hashtags'])->map(function ($hashtag) {
                return $this->hashtags()->save(Hashtag::firstOrCreate(compact('hashtag')));
            });
        }
        if ($attibutes['external_site'] ?? null) {
            $this->externalSite()->create($attibutes['external_site']);
        }
        if (($attibutes['images'] ?? null) && is_array($attibutes['images'])) {
            collect($attibutes['images'])->map(function ($filepath) {
                return $this->images()->create(compact('filepath'));
            });
        }
        if ($attibutes['product'] ?? null) {
            $this->product()->create($attibutes['product'] + [ 'interval' => 'month' ]);
        }
        return $this->fresh();
    }

    /**
     * 検索処理
     *
     * @param array $condition
     * @return object
     */
    public function searchByCondition(array $condition): object
    {
        $items = $this->with('user')
            ->withCount('likes', 'children')
            ->filter($condition)
            ->orderBy('id', 'desc')
            ->limit($this->perPage + 1)
            ->get()
        ;

        $next = null;
        if ($items->count() === $this->perPage + 1) {
            $model = $items->pop();
            $next = $model->id;
        }
        return (object) compact('items', 'next');
    }

    /**
     * 指定され条件を元にページネーションを取得します。
     *
     * @param array $condition
     * @return LengthAwarePaginator
     */
    public function paginateByCondition(array $condition): LengthAwarePaginator
    {
        $sortBy = $condition['sortby'] ?? 'id';
        $order = $condition['order'] ?? 'desc';
        return $this->with('user')
            ->filter($condition)
            ->orderBy($sortBy, $order)
            ->paginate()
        ;
    }

    /**
     * いいねしているかどうかの判定
     *
     * @param User|null $user
     * @return boolean
     */
    public function liking(?User $user): bool
    {
        return $user && $this->likes()->where('user_id', $user->id)->count() > 0;
    }

    /**
     * いいね処理
     *
     * @param User $user
     * @return integer
     */
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

    /**
     * いいね解除処理
     *
     * @param User $user
     * @return integer
     */
    public function unlike(User $user): int
    {
        $this->likes()
            ->where('user_id', $user->id)
            ->delete();
        return $this->likes()->count();
    }
}
