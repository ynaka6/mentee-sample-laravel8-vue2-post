<?php

namespace Tests\Feature\Api\Auth;

use Mockery;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    private const URL = '/api/register';

    /**
     * @return void
     */
    public function test_register_パラメータなし()
    {
        $response = $this->json('POST', self::URL);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password'])
        ;
    }

    /**
     * @return void
     */
    public function test_register_パスワード一致しない()
    {
        $faker = \Faker\Factory::create();
        $email = $faker->email;
        $name = $faker->name;
        $response = $this->json('POST', self::URL, ['email' => $email, 'name' => $name, 'password' => 'test', 'password_confirmation' => 'test1']);
        $response
            ->assertStatus(422)
        ;
    }

    /**
     * @return void
     */
    public function test_register_既にログインしている場合()
    {
        $faker = \Faker\Factory::create();
        $email = $faker->email;
        $name = $faker->name;
        $password = $faker->password;
        $user = User::factory()->create();
        $response = $this->actingAs($user)->json('POST', self::URL, ['email' => $email, 'name' => $name, 'password' => $password, 'password_confirmation' => $password]);
        $response
            ->assertStatus(400)
        ;
    }

    /**
     * @return void
     */
    public function test_login_成功()
    {
        $faker = \Faker\Factory::create();
        $email = $faker->email;
        $name = $faker->name;
        $password = $faker->password;
        $response = $this->json('POST', self::URL, ['email' => $email, 'name' => $name, 'password' => $password, 'password_confirmation' => $password]);
        $user = User::where('email', $email)->first();
        $response
            ->assertStatus(200)
            ->assertJsonPath('user.id', $user->id)
            ->assertJsonPath('user.name', $user->name)
            ->assertJsonPath('user.email', $user->email)
        ;
    }

}
