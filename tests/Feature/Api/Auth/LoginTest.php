<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
        
    private const URL = '/api/login';

    /**
     * @return void
     */
    public function test_login_パラメータなし()
    {
        $response = $this->json('POST', self::URL);
        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email', 'password'])
        ;
    }

    /**
     * @return void
     */
    public function test_login_パスワード間違え()
    {
        $user = User::factory()->create();
        $response = $this->json('POST', self::URL, ['email' => $user->email, 'password' => 'test']);
        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
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
            ->assertStatus(Response::HTTP_BAD_REQUEST)
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
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonPath('id', $user->id)
            ->assertJsonPath('name', $user->name)
            ->assertJsonPath('email', $user->email)
        ;

        $this->assertAuthenticatedAs($user);
    }
}
