<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;


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
            ->assertStatus(Response::HTTP_OK)
        ;
        $this->assertGuest();
    }
}
