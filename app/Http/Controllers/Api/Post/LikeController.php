<?php

namespace App\Http\Controllers\Api\Post;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{

    /**
     * いいね
     *
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function like(Post $post)
    {
        return response()
            ->json(
                [ 'count' => $post->like(Auth::user()) ],
                Response::HTTP_OK
            )
        ;
    }

    /**
     * いいね解除
     *
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function unlike(Post $post)
    {
        return response()
            ->json(
                [ 'count' => $post->unlike(Auth::user()) ],
                Response::HTTP_OK
            )
        ;
    }
}
