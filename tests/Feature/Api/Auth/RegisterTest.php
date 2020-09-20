<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use WithFaker;

    private const URL = '/api/register';

    /**
     * @return void
     */
    public function test_register_パラメータなし()
    {
        $response = $this->json('POST', self::URL);
        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name', 'email', 'password'])
        ;
    }

    /**
     * @return void
     */
    public function test_register_パスワード一致しない()
    {
        $email = $this->faker->email;
        $name = $this->faker->name;
        $response = $this->json('POST', self::URL, ['email' => $email, 'name' => $name, 'password' => 'test', 'password_confirmation' => 'test1']);
        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ;
    }

    /**
     * @return void
     */
    public function test_register_既にログインしている場合()
    {
        $email = $this->faker->email;
        $name = $this->faker->name;
        $password = $this->faker->password;
        $user = User::factory()->create();
        $response = $this->actingAs($user)->json('POST', self::URL, ['email' => $email, 'name' => $name, 'password' => $password, 'password_confirmation' => $password]);
        $response
            ->assertStatus(Response::HTTP_BAD_REQUEST)
        ;
    }

    /**
     * @return void
     */
    public function test_register_成功()
    {
        $email = $this->faker->email;
        $name = $this->faker->name;
        $password = $this->faker->password;
        $response = $this->json('POST', self::URL, ['email' => $email, 'name' => $name, 'password' => $password, 'password_confirmation' => $password]);
        $user = User::where('email', $email)->first();
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonPath('id', $user->id)
            ->assertJsonPath('name', $user->name)
            ->assertJsonPath('email', $user->email)
        ;
        $this->assertAuthenticatedAs($user);
    }

}
