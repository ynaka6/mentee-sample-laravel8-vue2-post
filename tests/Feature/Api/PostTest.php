<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

class PostTest extends TestCase
{

    private const INDEX_URL = '/api/posts';
    private const STORE_URL = '/api/post';
    private const DELETE_URL = '/api/post/{post}';


    public function test_index_未ログイン()
    {
        Post::query()->forceDelete();
        $posts = Post::factory()->count(20)->create();
        $response = $this->json('GET', self::INDEX_URL, []);
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(2)
            ->assertJsonPath('next', url('/api/posts?page=2'))
            ->assertJsonPath('posts.*.me', collect(range(1, 15))->map(function() { return false; })->toArray())
            ->assertJsonPath('posts.*.liking', collect(range(1, 15))->map(function() { return false; })->toArray())
            ->assertJsonPath('posts.*.id', $posts->reverse()->slice(0, 15)->map(function($p) { return $p->id; })->values()->all())
        ;
    }

    public function test_index_ログインユーザー（データあり）()
    {
        Post::query()->forceDelete();
        $user = User::factory()->create();
        $posts = Post::factory()->count(20)->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $post->like($user);
        $posts->push($post);
        $response = $this->actingAs($user)->json('GET', self::INDEX_URL, []);
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(2)
            ->assertJsonPath('next', url('/api/posts?page=2'))
            ->assertJsonPath('posts.*.me', [true] + collect(range(1, 15))->map(function() { return false; })->toArray())
            ->assertJsonPath('posts.*.liking', [true] + collect(range(1, 15))->map(function() { return false; })->toArray())
            ->assertJsonPath('posts.*.id', $posts->reverse()->slice(0, 15)->map(function($p) { return $p->id; })->values()->all())
        ;
    }

    public function test_store_パラメータなしの場合()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->json('POST', self::STORE_URL, []);
        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['message'])
        ;
    }

    public function test_store_成功()
    {
        $message = 'test';
        $user = User::factory()->create();
        $response = $this->actingAs($user)->json('POST', self::STORE_URL, [ 'message' => $message ]);
        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonPath('user.id', $user->id)
            ->assertJsonPath('user.name', $user->name)
            ->assertJsonPath('user.email', $user->email)
            ->assertJsonPath('message', $message)
            ->assertJsonPath('hashtags', [])
        ;
    }

    public function test_store_成功_ハッシュタグあり()
    {
        $message = 'アイウエオ #ABC #1234 いいい #1234567890';
        $user = User::factory()->create();
        $response = $this->actingAs($user)->json('POST', self::STORE_URL, [ 'message' => $message ]);
        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonPath('user.id', $user->id)
            ->assertJsonPath('user.name', $user->name)
            ->assertJsonPath('user.email', $user->email)
            ->assertJsonPath('message', $message)
            ->assertJsonPath('hashtags', [ 'ABC', '1234', '1234567890' ])
        ;
    }

    public function test_delete_権限エラー（別ユーザーの削除）()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $response = $this->actingAs($user)->json('DELETE', Str::replaceFirst('{post}', $post->id, self::DELETE_URL));
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN)
        ;
    }

    public function test_delete_成功()
    {
        $post = Post::factory()->create();
        $response = $this->actingAs($post->user)->json('DELETE', Str::replaceFirst('{post}', $post->id, self::DELETE_URL));
        $response
            ->assertStatus(Response::HTTP_NO_CONTENT)
        ;
    }

}
