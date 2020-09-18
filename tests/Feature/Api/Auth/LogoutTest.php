<?php

namespace Tests\Feature\Api\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
    private const URL = '/api/logout';

    /**
     * @return void
     */
    public function test_logout_成功()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->json('DELETE', self::URL);
        $response
            ->assertStatus(200)
        ;
        $this->assertGuest();
    }
}
