<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
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
     * @return void
     */
    public function index(SearchRequest $request)
    {
        $patinate = $this->eloquentPost->paginateByCondition($request->validated());
        return response()
            ->json([
                'next' => $patinate->nextPageUrl(),
                'posts' => $patinate->transform([$this, 'transformPost'])
            ])
        ;
    }

    /**
     * 投稿登録処理
     *
     * @param CreateRequest $request
     * @return void
     */
    public function store(CreateRequest $request)
    {
        return response()
            ->json(
                $this->transformPost($this->eloquentPost->create($request->validated())),
                Response::HTTP_CREATED
            )
        ;
    }

    /**
     * 投稿削除
     *
     * @param Post $post
     * @return void
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
        ];
    }
}
