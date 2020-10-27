<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\Post\CreateRequest;
use App\Http\Requests\Api\Post\SearchRequest;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    private $eloquentPost;

    /**
     * Constructor
     *
     * @param Post $eloquentPost
     */
    public function __construct(Post $eloquentPost)
    {
        $this->eloquentPost = $eloquentPost;
    }

    /**
     * 投稿一覧取得
     *
     * @param SearchRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SearchRequest $request)
    {
        $data = $this->eloquentPost->searchByCondition($request->validated());
        return response()
            ->json([
                'next' => $data->next,
                'posts' => $data->items->transform([$this, 'transformPost'])
            ])
        ;
    }

    /**
     * 投稿登録処理
     *
     * @param CreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $post = $this->eloquentPost->create($request->validated());
            return response()
                ->json(
                    $this->transformPost($post),
                    Response::HTTP_CREATED
                )
            ;
        });
    }

    /**
     * 投稿詳細
     *
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Post $post)
    {
        $post->loadCount('likes');
        return response()
            ->json($this->transformPost($post))
        ;
    }

    /**
     * 投稿削除
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function delete(Post $post)
    {
        $post->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * Postデータの変換処理
     *
     * @param Post $post
     * @return array
     */
    public function transformPost(Post $post): array
    {
        return [
            'id' => $post->id,
            'user' => $post->user,
            'message' => $post->message,
            'created_at' => $post->created_at->format('Y-m-d H:i'),
            'me' => $post->user->is(Auth::user()),
            'liking' => $post->liking(Auth::user()),
            'likesCount' => $post->likes_count ?? 0,
            'commentsCount' => $post->children_count ?? 0,
            'hashtags' => $post->hashtags->pluck('hashtag'),
            'externalSite' => $post->externalSite ?? null,
            'images' => $post->images->pluck('url'),
            'product' => $post->product ?? null
        ];
    }
}
