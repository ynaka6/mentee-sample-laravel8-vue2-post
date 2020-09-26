<?php

namespace App\Http\Controllers\Api\Post;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        return response()
            ->json(
                [ 'count' => $post->like(Auth::user()) ],
                Response::HTTP_OK
            )
        ;
    }

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
