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

    public function __construct(Post $eloquentPost)
    {
        $this->eloquentPost = $eloquentPost;   
    }

    public function index(SearchRequest $request)
    {
        return response()
            ->json(
                $this->eloquentPost
                    ->with('user')
                    ->filter($request->validated())
                    ->orderBy('id', 'desc')
                    ->paginate()
                    ->transform([$this, 'transformPost'])
            )
        ;
    }

    public function store(CreateRequest $request)
    {
        return response()
            ->json(
                $this->transformPost($this->eloquentPost->create($request->validated())),
                Response::HTTP_CREATED
            )
        ;
    }


    public function delete(Post $post)
    {
        $post->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }


    public function transformPost(Post $post): array
    {
        return $post->getAttributes() + [ 'me' => $post->user->is(Auth::user()) ];
    }
}
