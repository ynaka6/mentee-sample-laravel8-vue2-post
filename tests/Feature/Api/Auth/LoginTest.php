<?php

namespace Tests\Feature\Api\Auth;

use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    private const URL = '/api/login';

    /**
     * @return void
     */
    public function test_login_パラメータなし()
    {
        $response = $this->json('POST', self::URL);
        $response->assertStatus(422);
    }

    /**
     * @return void
     */
    public function test_login_パスワード間違え()
    {
        $user = User::factory()->create();
        $response = $this->json('POST', self::URL, ['email' => $user->email, 'password' => 'test']);
        $response
            ->assertStatus(422)
        ;
    }

    /**
     * @return void
     */
    public function test_login_既にログインしている場合()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->json('POST', self::URL, ['email' => $user->email, 'password' => 'password']);
        $response
            ->assertStatus(400)
        ;
    }

    /**
     * @return void
     */
    public function test_login_成功()
    {
        $user = User::factory()->create();
        $response = $this->json('POST', self::URL, ['email' => $user->email, 'password' => 'password']);
        $response
            ->assertStatus(200)
            ->assertJsonPath('user.id', $user->id)
        ;

        $this->assertAuthenticatedAs($user);
    }
}
