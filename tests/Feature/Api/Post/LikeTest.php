<?php

namespace Tests\Feature\Api\Post;

use Tests\TestCase;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeTest extends TestCase
{

    private const LIKE_URL = '/api/post/{post}/like';
    private const UNLIKE_URL = '/api/post/{post}/unlike';

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_like_成功()
    {
        PostLike::query()->forceDelete();
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $response = $this->actingAs($user)->json('POST', Str::replaceFirst('{post}', $post->id, self::LIKE_URL));
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonPath('count', 1)
        ;
    }

    public function test_like_自分の投稿もいいねできる()
    {
        PostLike::query()->forceDelete();
        $post = Post::factory()->create();
        $response = $this->actingAs($post->user)->json('POST', Str::replaceFirst('{post}', $post->id, self::LIKE_URL));
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonPath('count', 1)
        ;
    }

    public function test_like_既にいいね済みの場合()
    {
        PostLike::query()->forceDelete();
        $user = User::factory()->create();
        $post = Post::factory()->create();
        PostLike::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
        $response = $this->actingAs($user)->json('POST', Str::replaceFirst('{post}', $post->id, self::LIKE_URL));
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonPath('count', 1)
        ;
    }

    public function test_unlike_成功()
    {
        PostLike::query()->forceDelete();
        $postLike = PostLike::factory()->create();
        $response = $this->actingAs($postLike->user)->json('DELETE', Str::replaceFirst('{post}', $postLike->post_id, self::UNLIKE_URL));
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonPath('count', 0)
        ;
    }

    public function test_unlike_既に解除している場合()
    {
        PostLike::query()->forceDelete();
        $postLike = PostLike::factory()->create();
        $postLike->delete();
        $response = $this->actingAs($postLike->user)->json('DELETE', Str::replaceFirst('{post}', $postLike->post_id, self::UNLIKE_URL));
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonPath('count', 0)
        ;
    }
}
